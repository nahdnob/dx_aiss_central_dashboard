<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinePerformance extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['month', 'year', 'target', 'actual', 'line_id'];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }
}
