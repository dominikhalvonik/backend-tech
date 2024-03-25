<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'phone';

    protected $fillable = ["prefix", "phone_number", "user_id"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
