<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    protected static function booted()
    {
        static::creating(function(self $model) {
            $model->updated_at = null;
        });
    }
}
