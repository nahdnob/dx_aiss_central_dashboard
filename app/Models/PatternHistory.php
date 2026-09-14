<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternHistory extends Model
{
    protected $fillable = ['pattern_id', 'line_id'];

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
