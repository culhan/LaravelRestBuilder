<?php
namespace App\Http\Services;

use Request;
use App\Http\Models\{{Name}};
use App\Exceptions\DataEmptyException;
use App\Http\Repositories\{{Name}}Repository;
// use KhanCode\LaravelBaseRest\BaseService;

/**
 * code for system logic
 */
class {{Name}}Service extends BaseService
{

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->model = new {{Name}};
        $this->repository = new {{Name}}Repository;
    }

    // start list function
    
    // end list function    

}