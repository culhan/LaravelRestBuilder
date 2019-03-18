<?php

if( config('laravelrestbuilder.build_active') )
{
    Route::get('create', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@create');
    Route::get('modul', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@modul');
    Route::get('table', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@table');
    Route::post('build', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@build');
}