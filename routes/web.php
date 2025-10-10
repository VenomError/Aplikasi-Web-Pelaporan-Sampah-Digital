<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-mail', function () {
    Mail::raw('Ini test email dari Laravel', function ($message) {
        $message->to('venoms00001@gmail.com')
            ->subject('Test Kirim Email Laravel');
    });

    return 'Email terkirim!';
});
