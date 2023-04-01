<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mapi\Easyapi\Models\ApiModel;

class Article extends ApiModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'user_id'
    ];

    protected $allowedFilters = [
        'id'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
