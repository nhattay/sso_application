<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

class SsoAuthenticationController extends Controller
{
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $request->session()->put(
            'code_verifier', $code_verifier = Str::random(128)
        );

        $codeChallenge = strtr(rtrim(
            base64_encode(hash('sha256', $code_verifier, true))
            , '='), '+/', '-_');

        $query = http_build_query([
            'client_id' => config('services.sso.client_id'),
            'redirect_uri' => url('auth/callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            // 'prompt' => '', // "none", "consent", or "login"
        ]);

        return redirect(config('services.sso.host').'/oauth/authorize?'.$query);

    }

    public function authenticate(Request $request)
    {
        if ($request->get('error')) {
            return redirect('login');
        }

        $state = $request->session()->pull('state');
        $codeVerifier = $request->session()->pull('code_verifier');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $response = Http::asForm()->post(config('services.sso.host').'/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.sso.client_id'),
            'redirect_uri' => route('sso.authenticate'),
            'code_verifier' => $codeVerifier,
            'code' => $request->get('code'),
        ]);

        $ssoUser = Http::withToken($response->json()['access_token'])
            ->get(config('services.sso.host').'/api/user')
            ->throw()
            ->json();

        if ($ssoUser) {
            $user = User::firstOrCreate(
                ['email' => $ssoUser['email']],
                ['password' => '', 'name' => '', ...$ssoUser]
            );
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}
