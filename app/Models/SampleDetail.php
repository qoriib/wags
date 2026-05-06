<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleDetail extends Model
{
    protected $fillable = [
        'sample_id',
        'material_id',
        'value',
    ];

    /**
     * Get the sample that owns the detail.
     */
    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    /**
     * Get the material (parameter) associated with the detail.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
