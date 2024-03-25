<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'address';

    protected $fillable = ["street", "street_number", "city", "type", "user_id"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
