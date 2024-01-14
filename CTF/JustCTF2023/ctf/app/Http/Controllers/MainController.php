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
use Illuminate\Support\Collection;
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
				
				if(!isset($emailPart[1]) || $emailPart[1]!=="justeattakeaway.com")
					return redirect()->intended('/');
				
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
			

			
		$validated = $request->validate([			'flag' => 'required']);

		$flag=Flag::where('name',$request->input('flag'))->first();
		
		if($flag!==null)
		{
			if($flag->is_done==FALSE)
			{

					$user_flag=new UserFlag;
					$user_flag->user_id=Auth::id();
					$user_flag->flag_id=$flag->id;
					$user_flag->score=100;
					$user_flag->save();
					return redirect()->back()->with('success', 'Flag accepted!');  
			}
		}
        return back()->withErrors(['errors' =>"Flag was incorrect"]);
			
	}
    
    
      	public function track(Request $request,$track)
	{
    
				return view('dashboard',[
				'tasks' => Task::where('enabled',1)->where('track',$track)->where('archived',FALSE)->orderBy('created_at', 'desc')->get(),
				'title'=>$track
				]);
			
	}
	

	
  	public function dashboard(Request $request)
	{

				return view('dashboard',[
				'tasks' => Task::where('enabled',1)->where('track','default')->where('archived',FALSE)->orderBy('created_at', 'desc')->get(),
				'title'=>"Currect tasks"
				]);
			
	}
	
  	public function archived(Request $request)
	{
				return view('dashboard',[
				'tasks' => Task::where('enabled',1)->where('archived',TRUE)->orderBy('created_at', 'desc')->get(),
				'title'=>"Archived tasks"
				]);
	}
	
	function roundToNearest($value) {
    if ($value < 10) {
        return 10;
    }
    return floor($value / 5) * 5;
}
	
	
	
	public function leaderboard(Request $request)
	{
			if($request->input('type')=="awareness-month")
			{
				/*
								$startDate = Carbon::create(2023, 10, 1);
				$endDate = Carbon::create(2023, 10, 31);
				$flags=UserFlag::whereBetween('created_at', [$startDate, $endDate])->get();
				$users=array();
				foreach($flags as $flag)
				{
					if(!isset($users[$flag->user->name]))
					{
						$users[$flag->user->name]=0;
					}
					$users[$flag->user->name]+=$flag->score;
				}
				arsort($users);
				
				$leaderboard=collect();
				foreach($users as $name=>$score)
				{
					$leaderboard->push(['name'=>$name,'score'=>$score]);
				}
				*/
				
				
				
				
				$startDate = Carbon::create(2023, 10, 1);
				$endDate = Carbon::create(2023, 10, 31);
				$flags=UserFlag::whereBetween('flag_id', [9, 18])->get();
				$users=array();
				$flag_weight=array();
				
				foreach($flags as $flag)
				{
					if(!isset($flag_weight[$flag->flag->id]))
					{
						$flag_weight[$flag->flag->id]=0;
					}
					$flag_weight[$flag->flag->id]++;
				}
				
				
				
				foreach($flags as $flag)
				{
					if(!isset($users[$flag->user->name]))
					{
						$users[$flag->user->name]=0;
					}
					$users[$flag->user->name]+=$this->roundToNearest(100-(5*($flag_weight[$flag->flag->id]-1)));
				}
				arsort($users);
				
				$leaderboard=collect();
				foreach($users as $name=>$score)
				{
					$leaderboard->push(['name'=>$name,'score'=>$score]);
				}
				
				return view('leaderboard',[
					'title'=>"Awareness Month Leaderboard",
					'users'=>$leaderboard,
					'menu' => Task::where('enabled',1)->where('archived',FALSE)->orderBy('created_at', 'desc')->get()
				]);
				
				
				
			}

				$flags=UserFlag::get();
				$users=array();
				$flag_weight=array();
				
				foreach($flags as $flag)
				{
					if(!isset($flag_weight[$flag->flag->id]))
					{
						$flag_weight[$flag->flag->id]=0;
					}
					$flag_weight[$flag->flag->id]++;
				}
				
				
				
				foreach($flags as $flag)
				{
					if(!isset($users[$flag->user->name]))
					{
						$users[$flag->user->name]=0;
					}
					$users[$flag->user->name]+=$this->roundToNearest(100-(5*($flag_weight[$flag->flag->id]-1)));
				}
				
				arsort($users);
				
				$leaderboard=collect();
				foreach($users as $name=>$score)
				{
					$leaderboard->push(['name'=>$name,'score'=>$score]);
				}
				
			
			
				return view('leaderboard',[
				'title'=>"Global Leaderboard",
					'users'=>$leaderboard,
					'menu' => Task::where('enabled',1)->where('archived',FALSE)->orderBy('created_at', 'desc')->get()
				]);
			
	}
	
		public function rules()
	{

			
				return view('rules',['menu' => Task::where('enabled',1)->where('archived',FALSE)->orderBy('created_at', 'desc')->get()]);
			
	}
	

	
	  	public function login()
	{

			
				return view('login',['menu' => Task::where('enabled',1)->where('archived',FALSE)->orderBy('created_at', 'desc')->get()]);
			
	}
	

		
		
		

		
	}