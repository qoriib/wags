<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleDetail extends Model
{
    protected $fillable = [
        'sample_id',
        'parameter_id',
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
     * Get the parameter associated with the detail.
     */
    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }
}
