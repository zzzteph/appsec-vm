<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
class Challenge extends Model
{
    use HasFactory;
	
	
	
	
	function getShortCodeAttribute()
	{
		return  Str::substr($this->content, 0, 32);
	}
	
	public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
	
	public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
	
		
	public function getIsDoneAttribute()
    {
       if($this->answers()->where('user_id',Auth::id())->	where('correct', true)->count()>=1)return TRUE;
	   return FALSE;
    }
		public function getToReviewAnswerAttribute()
    {
		
		 if($this->answers()->	where('user_id',Auth::id())->
		where('reviewed', false)->count()>=1)return TRUE;

	   return FALSE;
    }
	
	public function getLastUserAnswerAttribute()
    {
		if(!$this->is_done)
			return $this->answers()->where('user_id',Auth::id())->orderBy('id','desc')->first();
		else
			return $this->answers()->where('user_id',Auth::id())->where('correct', true)->first();	
		
    }
	
	public function getCountUserAnswersAttribute()
	{
		return $this->answers()->where('user_id',Auth::id())->count();
	}

	
	public function getCountDoneAttribute()
    {
		
		return $this->answers()->	where('correct',TRUE)->count();
    }
	
	
	
	public function getIsAvailableAttribute()
	{
		if($this->available_at<= now())return true;
		return false;
	}
}
