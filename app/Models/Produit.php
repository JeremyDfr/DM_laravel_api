<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produit extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'course_id',
        'status'
    ];

    /**
     * @return void
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
