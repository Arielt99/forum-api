<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get all of the threads of a channel.
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
