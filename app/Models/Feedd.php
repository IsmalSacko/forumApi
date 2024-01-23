<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feedd extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content',    
    ];
    
    protected $appends = ['liked'];
    

    // Function to get the user of a post/Feedd
    public function user() : BelongsTo{
        return $this->belongsTo((User::class));
    }
    // Function to get the likes of a post/Feedd
    public function likes() : HasMany{
        return $this->hasMany(Like::class);
    }

    public function getLikedAttribute() : bool
    {
        return (bool) $this->likes()->where('feedd_id', $this->id)->where('user_id', auth()->id())->exists();
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
