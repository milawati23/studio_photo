<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'services';
    protected $primaryKey = 'service_id'; // Kunci primary custom
   
    protected $primarykey = 'category_id';

    public $incrementing = true;

    // Kolom-kolom yang boleh diisi melalui form (Mass Assignment)
    protected $fillable = [
        'service_name',
        'category_id',
        'price',
        'description',
    ];

    public function category(): BelongsTo
    {
        // Parameter ke-2 adalah foreign_key di tabel ini
        // Parameter ke-3 adalah owner_key (primary key) di tabel Category
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}