<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'supplierId' => $this->supplier_id,
            'supplier' => $this->supplier,
            'address' => $this->address,
            'createdAt' => date("d-m-Y", strtotime($this->cretaed_at)),
            'updatedAt' => date('d-m-Y', strtotime($this->updated_at)),
        ];
    }
}
