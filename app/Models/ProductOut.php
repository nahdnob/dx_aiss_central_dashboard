<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_id',
        'part_number',
        'time_out',
        'quantity',
        'line_id',
    ];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }

    public function productIns()
    {
        return $this->hasMany(ProductIn::class, 'product_out_id', 'id');
    }
}
