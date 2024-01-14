<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Flag extends Model
{
    use HasFactory;
	
	
	
		public function getIsDoneAttribute()
    {
        if($this->hasMany(UserFlag::class)->where('user_id',Auth::id())->count()>0)return TRUE;
		return FALSE;
    }
		public function task()
    {
        return $this->belongsTo(Task::class);
    }
		public function user_flags()
    {
        return $this->hasMany(UserFlag::class);
    }
	
}
