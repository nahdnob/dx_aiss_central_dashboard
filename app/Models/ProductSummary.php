<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_id',
        'part_number',
        'first_id',
        'last_id',
        'qty_in',
        'qty_out',
    ];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }

    public function firstProductIn()
    {
        return $this->belongsTo(ProductIn::class, 'first_id', 'id');
    }

    public function lastProductIn()
    {
        return $this->belongsTo(ProductIn::class, 'last_id', 'id');
    }
}
