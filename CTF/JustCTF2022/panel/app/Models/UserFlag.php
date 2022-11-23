<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFlag extends Model
{
    use HasFactory;
	
	
	    public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	    public function flag()
    {
        return $this->belongsTo(Flag::class);
    }
}
