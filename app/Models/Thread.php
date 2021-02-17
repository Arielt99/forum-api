<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'channel_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * Get the user that owns the thread.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the channel that owns the thread.
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Get all the reply of a thread.
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Making an unique slug.
     */
    public function sluging()
    {
        $slug = Str::slug($this->title.$this->id);

        $this->slug = $slug;
    }
}
