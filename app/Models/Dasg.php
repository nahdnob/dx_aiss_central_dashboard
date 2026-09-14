<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dasg extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail_standard',
        'revision',
        'link',
        'line_id',
    ];

    public function sops()
    {
        return $this->belongsToMany(Sop::class, 'dasg_sop', 'dasg_id', 'sop_id')->withTimestamps();
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
