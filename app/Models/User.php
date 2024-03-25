<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    protected $fillable = ["meno", "email"];

    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class);
    }

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
