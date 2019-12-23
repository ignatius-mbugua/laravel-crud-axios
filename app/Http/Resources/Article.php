<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return data of all fields
        // return parent::toArray($request);

        //return data of specific fields
        return[
            'id'=> $this->id,
            'title'=> $this->title,
            'body'=> $this->body
        ];
    }

    //return more info with data
    public function with($request)
    {
        return[
            'version'=> '1.0.0'
        ];
    }
}
