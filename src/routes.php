<?php

if( config('laravelrestbuilder.build_active') )
{
    Route::group(['middleware' => [\Illuminate\Session\Middleware\StartSession::class]], function () {
        Route::group(['middleware' => [KhanCode\LaravelRestBuilder\Middleware\SetConfigMiddleware::class]], function () {
        Route::get('login', 'KhanCode\LaravelRestBuilder\Auth@login');
        Route::post('login', 'KhanCode\LaravelRestBuilder\Auth@setAuth');
            Route::group(['middleware' => [KhanCode\LaravelRestBuilder\Middleware\AuthMiddleware::class]], function () {
                Route::get('KhanCodeLogout', 'KhanCode\LaravelRestBuilder\Auth@logout');
                Route::get('list', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@list');                
                Route::get('create', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@create');
                Route::get('update/{id}', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@update');                
                Route::get('listTable', 'KhanCode\LaravelRestBuilder\TableBuilder@listTable');
                Route::get('createTable', 'KhanCode\LaravelRestBuilder\TableBuilder@createTable');                
                Route::get('updateTable/{id}', 'KhanCode\LaravelRestBuilder\TableBuilder@updateTable');                
                Route::get('project', 'KhanCode\LaravelRestBuilder\ProjectBuilder@get');
                Route::post('project', 'KhanCode\LaravelRestBuilder\ProjectBuilder@create');                
                Route::get('updateProject/{id}', 'KhanCode\LaravelRestBuilder\ProjectBuilder@updateProjects');
                Route::get('createProject', 'KhanCode\LaravelRestBuilder\ProjectBuilder@createProject');
                Route::get('setProject/{id}', 'KhanCode\LaravelRestBuilder\ProjectBuilder@setProject');                
                Route::get('lang/list', 'KhanCode\LaravelRestBuilder\LanguageBuilder@index');
                Route::get('lang/create', 'KhanCode\LaravelRestBuilder\LanguageBuilder@create');
                Route::post('lang', 'KhanCode\LaravelRestBuilder\LanguageBuilder@save');
                Route::get('updateLang', 'KhanCode\LaravelRestBuilder\LanguageBuilder@update');
                Route::get('dropLang', 'KhanCode\LaravelRestBuilder\LanguageBuilder@dropLang');
                Route::get('dokumentasi', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@dokumentasi');
                
                Route::get('user', 'KhanCode\LaravelRestBuilder\UserBuilder@get');
                Route::get('createUser', 'KhanCode\LaravelRestBuilder\UserBuilder@createUser');
                Route::get('updateUser/{id}', 'KhanCode\LaravelRestBuilder\UserBuilder@updateUser');

                Route::get('emails', 'KhanCode\LaravelRestBuilder\EmailBuilder@get');
                Route::get('createEmail', 'KhanCode\LaravelRestBuilder\EmailBuilder@createEmail');
                Route::post('buildEmail', 'KhanCode\LaravelRestBuilder\EmailBuilder@buildEmail');
                Route::get('updateEmail/{id}', 'KhanCode\LaravelRestBuilder\EmailBuilder@updateEmail');
                Route::get('preview/{id}', 'KhanCode\LaravelRestBuilder\EmailBuilder@preview');

                Route::get('events', 'KhanCode\LaravelRestBuilder\EventBuilder@get');
                Route::get('createEvent', 'KhanCode\LaravelRestBuilder\EventBuilder@createEvent');
                Route::post('buildEvent', 'KhanCode\LaravelRestBuilder\EventBuilder@buildEvent');
                Route::get('updateEvent/{id}', 'KhanCode\LaravelRestBuilder\EventBuilder@updateEvent');
                
                
            });                                
        });
    });

    Route::group(['middleware' => [                
                \Illuminate\Session\Middleware\StartSession::class, 
                KhanCode\LaravelRestBuilder\Middleware\SetConfigMiddleware::class,
                KhanCode\LaravelRestBuilder\Middleware\AuthAjaxMiddleware::class,
            ]
    ], function () {
        Route::get('dataList', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@dataList');    
        Route::get('modul/{id}', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@modul');
        Route::delete('delete/modul/{id}', 'KhanCode\LaravelRestBuilder\ModulBuilder@destroy');
        Route::get('tables', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@table');
        Route::get('dropTable/{id}', 'KhanCode\LaravelRestBuilder\TableBuilder@dropTable');
        Route::post('buildMigration', 'KhanCode\LaravelRestBuilder\TableBuilder@buildMigration');
        Route::get('systemTable', 'KhanCode\LaravelRestBuilder\TableBuilder@systemTable');
        Route::post('build', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@build');
        Route::get('middleware', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@middleware');        
        Route::post('callApi', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@callApi');
        Route::post('saveApi', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@saveEndpoint');
        Route::post('updatePositionApi', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@updatePositionApi');
        Route::get('listEndpoint', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@listEndpoint');
        Route::get('listEndpointChildren/{id}', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@listEndpointChildren');
        Route::get('endpoint/{id}', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@endpoint');
        Route::get('getEnv', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@getEnv');
        Route::post('saveEnv', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@saveEnv');
        Route::get('listProject', 'KhanCode\LaravelRestBuilder\ProjectBuilder@projects');
        Route::get('sync', 'KhanCode\LaravelRestBuilder\RepositoryProjectBuilder@sync');
        Route::get('repoStatus', 'KhanCode\LaravelRestBuilder\RepositoryProjectBuilder@status');
        Route::post('push', 'KhanCode\LaravelRestBuilder\RepositoryProjectBuilder@push');
        Route::get('composerUpdate', 'KhanCode\LaravelRestBuilder\ComposerProjectBuilder@composerUpdate');
        Route::get('composerUpdateResult', 'KhanCode\LaravelRestBuilder\ComposerProjectBuilder@composerUpdateResult');
        Route::get('listPackage', 'KhanCode\LaravelRestBuilder\ComposerProjectBuilder@listPackage');
        Route::post('getVersionPackage', 'KhanCode\LaravelRestBuilder\ComposerProjectBuilder@getVersionPackage');
        Route::post('addPackage', 'KhanCode\LaravelRestBuilder\ComposerProjectBuilder@addPackage');
        Route::get('diffFile/{id}', 'KhanCode\LaravelRestBuilder\RepositoryProjectBuilder@diffFile');
        Route::delete('deleteEndpoint/{id}', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@deleteEndpoint');
        Route::put('renameEndpoint/{id}', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@renameEndpoint');
        Route::post('tambahFolder', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@tambahFolder');
        Route::get('modulFile/{id}', 'KhanCode\LaravelRestBuilder\LaravelRestBuilder@modulFile');
        
        Route::get('listUser', 'KhanCode\LaravelRestBuilder\UserBuilder@list');
        Route::post('createUser', 'KhanCode\LaravelRestBuilder\UserBuilder@create');
        
        Route::get('listEmail', 'KhanCode\LaravelRestBuilder\EmailBuilder@list');
        Route::get('listEvent', 'KhanCode\LaravelRestBuilder\EventBuilder@list');
        Route::delete('delete/event/{id}', 'KhanCode\LaravelRestBuilder\EventBuilder@destroy');
        Route::get('dataTable/{table_name}', 'KhanCode\LaravelRestBuilder\TableBuilder@dataTable');
        Route::post('saveData', 'KhanCode\LaravelRestBuilder\TableBuilder@saveData');
        Route::post('deleteData', 'KhanCode\LaravelRestBuilder\TableBuilder@deleteData');
        Route::post('addData', 'KhanCode\LaravelRestBuilder\TableBuilder@addData');
        Route::post('importPostman', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@importPostman');
        Route::post('addEnv', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@addEnv');
        Route::get('getJumlahEndpoint', 'KhanCode\LaravelRestBuilder\DokumentasiBuilder@getJumlahEndpoint');
        
    });
}