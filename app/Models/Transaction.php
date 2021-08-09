<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $guarded = [];

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
