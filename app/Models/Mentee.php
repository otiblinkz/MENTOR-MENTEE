<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id','mentor_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function mentorlist(): HasMany
    {
        return $this->hasMany(User::class,'id','mentor_id');
    }
    public function menteelist(): HasMany
    {
        return $this->hasMany(User::class,'id','user_id');
    }
}
