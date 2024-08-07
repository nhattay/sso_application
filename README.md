## Laravel SSO Integration with Identity Server and PKCE
Welcome to the repository for our application that integrates Single Sign-On (SSO) using Laravel Passport as an Identity Server with Proof Key for Code Exchange (PKCE). This project demonstrates how to set up and use Laravel Passport to create a secure, centralized authentication system with enhanced security using PKCE, providing a seamless login experience across multiple applications.

Here is the Identity Server: https://github.com/nhattay/sso_identity_server

## Features
* Centralized Authentication: Implement SSO to allow users to authenticate once and access multiple applications without needing to log in again.
* OAuth2 with PKCE Support: Utilize Laravel Passport to support OAuth2 with PKCE, enhancing security for public clients and preventing interception attacks.
* User Management: Simplify user management with centralized user profiles and streamlined authentication flows.
* Extensible and Scalable: Designed to be easily extensible for additional authentication and authorization requirements.

## Prerequisites
- PHP ^8.2
- Nodejs ^18
- Composer 2
- MySQL or other compatible database

## Installation

```
composer install
```

```
php artisan migrate
```

## Configuration

#### .env file

| Variable        | Description                                                                                                                    | Default value |
|:----------------|:-------------------------------------------------------------------------------------------------------------------------------|:--------------|
| `SSO_HOST`      | The host of SSO server.<br/> Eample: `SSO_HOST=http://sso-server.test`                                                         |               |
| `SSO_CLIENT_ID` | The Laravel Passport Client ID that generated on SSO server.<br/> Eample: `SSO_CLIENT_ID=9cb31461-8307-4a5c-bb07-20282d814c01` |               |

## Localhost development

```
yarn
```

```
yarn dev
```

## Production build

```
yarn
```

```
yarn build
```

## Cronjob


