# Starter Kit for Laravel Sanctum
An opinionated Laravel starter kit for RESTful API development with Sanctum.

## Requirements
- Laravel ^10
- PHP ^8.1

## Features
- Login
- Registration
- Email verification
- Password reset
- Users management

## To do
1. Add front-end url in the ***.env*** file
```php
FRONT_END_URL=http://localhost
```

2. Edit the ***boot*** method in ***AuthServiceProvider.php*** file to ensure that your front-end endpoints are correct
```php
VerifyEmail::createUrlUsing(function ($notifiable) {
    // $url is directly set as the API endpoint for email verification
    // see 'verification.verify' route
    $url = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(Config::get('auth.verification.expire', 60)), [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]
    );

    return Config::get('app.frontend_url').'/email-verification?url='.urlencode($url);
});

ResetPassword::createUrlUsing(
    fn ($user, string $token) => Config::get('app.frontend_url').'/reset-password?email=' . $user->email . '&token='.$token
);
```
3. Setup your mail server

## Testing
```php
php artisan test
```

## Documenation
Run ```php artisan serve``` and open ```http://127.0.0.1:8000/docs``` in hour browser
