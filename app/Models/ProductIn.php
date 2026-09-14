<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_out_id',
        'part_id',
        'part_number',
        'time_in',
        'quantity',
        'is_processed',
        'line_id',
    ];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }

    public function productOut()
    {
        return $this->belongsTo(ProductOut::class, 'product_out_id', 'id');
    } 
}
