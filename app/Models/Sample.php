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
        'status',
    ];

    /**
     * Get the details for the sample.
     */
    public function details()
    {
        return $this->hasMany(SampleDetail::class);
    }

    /**
     * Get the material that owns the sample.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
