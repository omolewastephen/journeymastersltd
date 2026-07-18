<?php
/**
 * Application configuration.
 * Values come from environment (.env) with safe production defaults.
 */
return [
    'app' => [
        'name'     => 'Journey Masters Ltd',
        'tagline'  => 'Travel · Study Abroad · Visa Consultancy',
        'env'      => env('APP_ENV', 'production'),
        'debug'    => filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOL),
        'url'      => env('APP_URL', ''),
        'timezone' => 'Africa/Lagos',
    ],

    'business' => [
        'legal_name' => 'Journey Masters Ltd',
        'phone'      => '0707 171 2755',
        'phone_raw'  => '07071712755',
        'phone_intl' => '+2347071712755',
        'whatsapp'   => 'https://wa.link/8k9dsz',
        'facebook'   => 'https://facebook.com/profile.php?id=61564686459957',
        'email'      => 'info@journeymastersltd.com',
        'address'    => 'Abeokuta, Ogun State, Nigeria',
        'city'       => 'Abeokuta',
        'region'     => 'Ogun State',
        'founded'    => 2016,
    ],

    'db' => [
        'host'    => env('DB_HOST', '127.0.0.1'),
        'port'    => env('DB_PORT', '3306'),
        'name'    => env('DB_NAME', 'journeymasters'),
        'user'    => env('DB_USER', 'root'),
        'pass'    => env('DB_PASS', ''),
        'charset' => 'utf8mb4',
        'enabled' => filter_var(env('DB_ENABLED', 'false'), FILTER_VALIDATE_BOOL),
    ],

    'mail' => [
        'to'      => env('MAIL_TO', 'inquiries@journeymastersltd.com'),
        'from'    => env('MAIL_FROM', 'no-reply@journeymastersltd.com'),
        'subject' => 'New enquiry from journeymastersltd.com',
    ],
];
