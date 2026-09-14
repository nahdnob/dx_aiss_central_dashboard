<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ncd extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['date', 'claim', 'action', 'line_id'];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }
}
