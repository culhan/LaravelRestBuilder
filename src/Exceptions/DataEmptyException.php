<?php 
namespace KhanCode\LaravelRestBuilder\Exceptions;

/**
* 
*/
class DataEmptyException extends \Exception
{	
	public function responseJson()
	{
		if( empty($this->code) && (request('search_column') || request('search')) ) {
			$this->code = 204;
		}
		return \Response::json(
	        [
	            'error' => [
	                'message' => (!empty($this->message)) ? $this->message : trans('admin/error.data_not_found'), 
					'status_code' => 404,
					'error_code' => $this->code,
	                'error' => (!empty($this->message)) ? $this->message : trans('admin/error.data_not_found')
	            ]
	        ], 
	    404);
	}
}