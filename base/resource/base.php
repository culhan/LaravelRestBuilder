<?php

namespace App\Http\Resources;

use App;
use Illuminate\Http\Resources\Json\Resource;

class {{Name}}Resource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {           
        return [
            // start list column
            // end list column

            // start list relation
            // end list relation
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status'    => 200,
            'error'     => 0
        ];
    }
}
