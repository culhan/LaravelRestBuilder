<?php 
namespace KhanCode\LaravelRestBuilder\Exceptions;

/**
* 
*/
class AuthenticationException extends \Exception
{	
	public function responseJson()
	{		
		return \Response::json(
	        [
	            'error' => [
	                'message' => (!empty($this->message)) ? $this->message : trans('admin/error.data_not_found'),
					'status_code' => 401,
					'error_code' => $this->code,
	                'error' => 'Not Authorized'
	            ]
	        ], 
	    401);
	}
}