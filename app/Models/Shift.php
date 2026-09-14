<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\WorkHour;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'time_start',
        'time_end',
        'description',
        'line_id',
    ];

    public function workHours()
    {
        return $this->hasMany(WorkHour::class);
    }
}
