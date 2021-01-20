<?php

namespace KhanCode\LaravelRestBuilder;

use Request;
use Session;
use Illuminate\Support\Facades\Hash;
use \KhanCode\LaravelRestBuilder\Models\Users;
use \KhanCode\LaravelRestBuilder\Models\Projects;

class Auth
{
    /**
     * Undocumented function
     */
    public function __construct() {
        self::setProvider();
    }

    /**
     * Undocumented function
     */
    static function setProvider() {        
        config([
            'auth.guards.laravelrestbuilder_auth'   =>  [
                'driver' => 'session',
                'provider' => 'laravelrestbuilder_auth',
            ]
        ]); 

        config([
            'auth.providers.laravelrestbuilder_auth'   =>  [
                'driver' => 'eloquent',
                'model' => Users::class,
            ]
        ]);        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function login()
    {
        if (auth()->guard('laravelrestbuilder_auth')->check()) {
            return redirect('/list');
        }
        
        return view('khancode::login', ['data'=>[]]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function setAuth()
    {        
        $user = Users::getAll()
                ->where(function ($query) {
                    $query->orWhere('name', '=', Request::get('username'))
                        ->orWhere('email', '=', Request::get('username'));
                })->first();
        
        if( $user == null ){
            Session::flash('flash_message', 'No Data Found!');            
            return $this->login();
        }

        if ( !Hash::check(Request::get('password'), $user->password)) {
            Session::flash('flash_message', 'No Data Match!');            
            return $this->login();
        }
        
        if( empty($user->projects[0]) ) {
            return redirect('/createProject');
        }

        $first_project = Projects::where('id', $user->projects[0])->first();

        auth()->guard('laravelrestbuilder_auth')->login($user);
        
        if( empty($first_project) ) {
            return redirect('/createProject');
        }

        session(['project' => $first_project->toArray()]);        
        
        return redirect('/list');
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function logout()
    {
        auth()->guard('laravelrestbuilder_auth')->logout();

        session()->flush();

        return redirect('/KhanCodeLogout');
    }
}
