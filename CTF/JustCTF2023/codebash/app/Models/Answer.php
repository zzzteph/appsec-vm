<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Answer extends Model
{
    use HasFactory;
	
	
	
	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
	
	public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }
	
	
	public function getIsReviewedAttribute()
	{
		if($this->reviewed==true)return true;//Bob marked as correct
		if($this->user_review==true)return true;//Human sure
		
		return false;//no bob
		
	}

		public function getGetInfoAttribute()
	{
		if($this->is_reviewed)
		{
			if($this->correct)
			{
				if(intval($this->correctness)==1000)return "Perfect answer! Grade S!";
				elseif(intval($this->correctness)<1000 && intval($this->correctness)>=950)return "Perfect answer! Grade A++";
				elseif(intval($this->correctness)<950 && intval($this->correctness)>=950)return "Perfect answer! Grade A+";
				elseif(intval($this->correctness)<900 && intval($this->correctness)>=950)return "Perfect answer! Grade A";
				elseif(intval($this->correctness)<850 && intval($this->correctness)>=750)return "Perfect answer! Grade A-";
				else return "";
			}
			else
			{

				if(intval($this->correctness)<850 && intval($this->correctness)>=700)
				{
					return "Seems your answer was almost fine, but some additional input is needed";
				}
				if(intval($this->correctness)<700 && intval($this->correctness)>=600)
				{
					return "You were on the right way - (".round($this->correctness/10)."%)";
				}
				if(intval($this->correctness)<500)
				{
					return "Your answer is incorrect - (".round($this->correctness/10)."%)";
				}
			}
		}
		
		
		return "We need some time to review your answer. Please wait...";
		
	}

}
