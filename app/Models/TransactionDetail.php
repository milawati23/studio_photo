<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    // PERBAIKAN UTAMA: Ubah dari transaction_detail_id menjadi transactiondetail_id (tanpa _ di kata detail)
    protected $primaryKey = 'transactiondetail_id';

    protected $fillable = [
        'transaction_id',
        'service_id',
        'quantity',
        'subtotal',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}