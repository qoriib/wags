<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sample extends Model
{
    protected $fillable = [
        'material_id',
        'sample_no',
        'test_date',
        'operator',
        'fe2o3',
        'cao',
        'sio2',
        'al2o3',
        'caco3',
        'loi',
        'status',
    ];

    /**
     * Get the material that owns the sample.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
