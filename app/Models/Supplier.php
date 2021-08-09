<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $tabl = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_id');
    }
}
