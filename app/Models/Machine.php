<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sop;
use App\Models\Line;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_no',
        'asset_name',
        'acquisition_date',
        'image_path',
        'manufacturer',
        'model',
        'line_id',
    ];

    protected function casts(): array {
        
        return [
            'acquisition_date' => 'date',
        ];
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function sops()
    {
        return $this->belongsToMany(Sop::class, 'machine_sop', 'machine_id', 'sop_id')->withTimestamps();
    }
}
