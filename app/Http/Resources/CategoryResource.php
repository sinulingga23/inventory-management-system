<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'categoryId' => $this->category_id,
            'code' => $this->code,
            'category' => $this->category,
            'createdAt' => date('d-m-Y', strtotime($this->created_at)),
            'updatedAt' => $this->updated_at != null ? date('d-m-Y', strtotime($this->updated_at)) : null,
        ];
    }
}
