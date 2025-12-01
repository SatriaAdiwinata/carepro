<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use App\Models\Pengguna; // Pastikan Anda mengimpor model Pengguna

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'penggunas',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great starting point is the "web" guard which uses
    | session storage and the Eloquent user provider.
    |
    | All authentication guards have a "driver" that defines how they store
    | and retrieve users. The "session" driver provides session-based
    | storage while the "token" driver provides token-based storage.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'penggunas', // Ganti 'users' menjadi 'penggunas'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved from the database or other storage
    | mechanisms used by this application.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers here.
    |
    */

    'providers' => [
        'penggunas' => [ // Buat provider baru
            'driver' => 'eloquent',
            'model' => Pengguna::class, // Tentukan model Pengguna sebagai sumber data
        ],

        // Anda dapat menghapus provider 'users' jika tidak digunakan.
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings for each. This is a common setup.
    |
    */

    'passwords' => [
        'penggunas' => [
            'provider' => 'penggunas',
            'table' => 'password_resets', // atau sesuai nama tabel Anda
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and a user is required to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];