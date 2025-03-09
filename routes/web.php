<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/books', function () {
    return view('books');
});

Route::get('/authors', function () {
    return view('authors');
});

Route::get('/publishers', function () {
    return view('publishers');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/submit-contact-info', function (Request $request) {
    return view('contact-info', ['data' => $request->all()]);
});
