<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Challenge;
use App\Models\Answer;

use Illuminate\Support\Collection;
class ApiController extends Controller
{
	
	public function challenges()
	{
		$collection = collect();
		$challenges=Challenge::where('enabled',TRUE)->orderBy('available_at','asc')->get();	
		
		foreach($challenges as $challenge)
		{
			 $diff = now()->diff($challenge->available_at);
			 $formated_diff="";
			 
			 if($diff->days>0)
				 $formated_diff.=$diff->days." days";
			 if($diff->days<=0)
			 {
				 if($diff->h>0)
				 {
					  $formated_diff.=$diff->h." hours";
				 }
				 else
				 {
					  $formated_diff=$diff->i.":".$diff->s."";
				 }
				
			 }
			 
			$collection->push(
			array(
			'id'=>$challenge->id,
			'title'=>$challenge->title,
			'available_at'=>$challenge->available_at,
			'countdown'=>$formated_diff,
			'is_available'=>$challenge->is_available,
			'is_done'=>$challenge->is_done,
			'count_answers'=>$challenge->count_user_answers,
			'is_review'=>$challenge->to_review_answer
			)
			);
		}
		
		
		
		return  response()->json($collection);
	}
	
	

	public function countdown()
	{
		$challenge=Challenge::where('enabled',TRUE)->where('available_at', '>=', now())->orderBy('available_at','asc')->first();	
		
		if($challenge!==null)
		{
			 $diff = now()->diff($challenge->available_at);
				$formated_diff="";
			 
			 if($diff->days>0)
				 $formated_diff.=$diff->days." days";
			 if($diff->days<=0)
			 {
				 if($diff->h>0)
				 {
					  $formated_diff.=$diff->h." hours";
				 }
				 else
				 {
					  $formated_diff=$diff->i.":".$diff->s."";
				 }
				
			 }
			
			
			return  response()->json($formated_diff);
		}
		abort(404);

	}
	

	
	
		public function answers()
	{
		if(Auth::user()->role==='admin')
			return response()->json( DB::table('answers')->select('id','correct','reviewed','correctness')->get());
		else  
		return abort(500);

	}

		
		
		

		
	}