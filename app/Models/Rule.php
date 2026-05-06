<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    protected $fillable = [
        'material_id',
        'parameter',
        'operator',
        'value',
        'result_status',
    ];

    /**
     * Get the material that owns the rule.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
