<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

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
}
