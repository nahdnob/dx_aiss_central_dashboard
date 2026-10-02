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
    protected $fillable = ['line_id', 'month', 'year', 'target', 'actual'];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }
}
