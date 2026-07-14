<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    // Tentukan nama tabel jika tidak mengikuti konvensi jamak standar Laravel
    protected $table = 'payments';

    // Tentukan primary key jika bukan 'id'
    protected $primaryKey = 'payment_id';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'transaction_id',
        'payment_date',
        'payment_method',
        'amount',
    ];

    // Casting tipe data untuk kolom tertentu
    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public $incrementing = true;
    protected $keyType = 'int';

    // Jika di dalam model, cek apakah ada:
    protected static function booted()
    {
        static::addGlobalScope('order', function ($builder) {
            // UBAH INI dari payment_id menjadi id
            $builder->orderBy('payment_id', 'desc'); 
        });
    }

    /**
     * Relasi ke model Transaction
     * Satu pembayaran milik satu transaksi
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
}