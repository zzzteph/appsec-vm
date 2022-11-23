<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\UserFlag;
use App\Models\Flag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Package;
class MainController extends Controller
{
	
	public function update_tasks()
	{
		foreach( Task::where('enabled',1)->get() as $task)
		{
			 if($task->created_at->diffInDays(Carbon::now())>=14)
			 {
				 $task->enabled=0;
				 $task->save();
			 }
		}
	}
	
	
	public function social_login(Request $request)
    {
           $socialUser = Socialite::driver('google')->user();
			$user = User::where('email', $socialUser->getEmail())->first();
			if(is_null($user)){	
				$user = new User;
				$emailPart = explode("@", $socialUser->getEmail());
				$user->name = $emailPart[0].Str::random(5);
				$user->email = $socialUser->getEmail();
				$user->score = 0;
				$user->password=Hash::make(Str::random(40));
				$user->save();	
			}	
			$user->markEmailAsVerified();
			Auth::loginUsingId($user->id);
			$request->session()->regenerate();
			return redirect()->intended('/');
			
    }

  	public function submit(Request $request)
	{
			
		if (Auth::check()) {
			
					$validated = $request->validate([			'flag' => 'required']);

					$flag=Flag::where('name',$request->input('flag'))->first();
					
					if($flag!==null)
					{
						if($flag->is_done==FALSE)
						{
							if($flag->task->enabled==TRUE)
							{
								$user_flags=UserFlag::where('flag_id',$flag->id)->get();
								$score=100;
								foreach($user_flags as $user_flag)
								{
									$score-=25;
								}
								if($score<=0)$score=10;
								
								$user_flag=new UserFlag;
								$user_flag->user_id=Auth::id();
								$user_flag->flag_id=$flag->id;
								$user_flag->score=$score;
								$user_flag->save();
								$user=Auth::user();
								$user->score+=$score;
								$user->save();
								
							}
						}
					}

		}
		return redirect()->intended('/');
			
	}
	
  	public function dashboard(Request $request)
	{
			
		if (Auth::check()) {
			
				return view('dashboard',[
				'tasks' => Task::where('enabled',1)->orderBy('created_at', 'asc')->get(),
				'users'=>User::where('score','>',0)->orderBy('score', 'desc')->get()
				]);
		}
		else
			return view('login');
			
	}
	

	

	
	

		
		
		

		
	}