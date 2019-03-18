<?php

namespace App\Http\Controllers\Api;

use App;
use Request;
use App\Http\Services\{{name}}Service;
use App\Http\Controllers\Controller;

class {{name}}Controller extends Controller
{    

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->service = new {{name}}Service;
    }

    // start list function
    
    // end list function

}