<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    // Nama tabel di database
    protected $table = 'payments';

    // Menggunakan default primary key 'id' sesuai dengan property $payment->id di Livewire kamu
    protected $primaryKey = 'id';

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'transaction_id',
        'payment_method',
        'amount_paid',
        'payment_status',
    ];

    // Casting tipe data agar otomatis dikonversi oleh Eloquent
    protected $casts = [
        'amount_paid' => 'decimal:2',
    ];

    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Global Scope untuk otomatis mengurutkan data dari yang terbaru.
     * Menggunakan table prefix (payments.id) agar aman saat query JOIN.
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('payments.id', 'desc'); 
        });
    }

    /**
     * Relasi ke model Transaction
     * Satu pembayaran terikat pada satu transaksi
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
}