<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'transaction_types';
    protected $primaryKey = 'transaction_type_id';
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_id');
    }
}
