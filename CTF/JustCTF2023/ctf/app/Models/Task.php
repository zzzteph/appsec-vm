<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;
class Task extends Model
{
    use HasFactory;
	
	public function user_flags(): HasManyThrough
    {
          return $this->HasManyThrough(UserFlag::class,Flag::class)->orderBy('created_at','desc');
    }

	public function flags()
    {
        return $this->hasMany(Flag::class);
    }
	
	public function list()
	{
		$users=array();
		
		foreach($this->flags as $flag)
		{
			foreach($flag->user_flags as $user_flag)
			{
				if(!isset($users[$user_flag->user->name]))
				{
					$users[$user_flag->user->name]=0;
				}
				$users[$user_flag->user->name]+=$user_flag->score;
			}
		}
		arsort($users);
		return $users;
		
	}
	
	
	

	public function getDoneAttribute()
	{
		$done=0;
			foreach($this->flags as $flag)
		{
			if($flag->is_done)$done++;
			
		}
		return $done;
	}
	public function getFlagsCountAttribute()
	{
		return $this->flags()->count();
	}
	
	public function getIsDoneAttribute()
	{
		$count=$this->flags()->count();
		$done=0;
		foreach($this->flags as $flag)
		{
			if($flag->is_done)$count--;
			
		}
		if($count<=0)return TRUE;
		return FALSE;
		
	}
	
	
	
	
		public function getToDateAttribute()
	{

return (new Carbon($this->created_at))->addWeeks(1);
		
	}
}
