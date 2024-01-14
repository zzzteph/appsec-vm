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
use App\Jobs\AskBob;
use Laravolt\Avatar\Avatar;
use Intervention\Image\Facades\Image as ResizeImage;
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
				
				//if(!isset($emailPart[1]) || $emailPart[1]!=="justeattakeaway.com")
				//	return redirect()->intended('/');
				
				$user->name = $emailPart[0].Str::random(5);
				$user->email = $socialUser->getEmail();
				$user->score = 0;
				$user->password=Hash::make(Str::random(40));
				$user->save();	
				
				$name=str_replace("."," ",$user->name);
				$link=md5($user->id.$user->password);
				
				$avatar = new Avatar;
				$avatar->create($name)->setTheme('colorful')->save(storage_path('app/public/').$link.'.png');
				$user->avatar=$link.".png";	
				$user->save();
			}	

			$user->markEmailAsVerified();
			Auth::loginUsingId($user->id);
			$request->session()->regenerate();
			return redirect()->route('challenges');
			
    }


  	public function challenges()
	{
			
		
		$challenges=Challenge::where('enabled',TRUE)->orderBy('available_at','asc')->get();	
		return view('dashboard',['challenges'=>$challenges]);


	}
	

	public function update_profile(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|max:32|min:3',
			'avatar' => 'mimes:jpeg,jpg,png|max:20000',
		]);
		$user=Auth::user();
		$user->name=$request->input('name');

		if($request->has('avatar'))
		{
			$temp_link=md5(Str::random(40));
			$filename=storage_path('app/public/').$temp_link.'.'.$request->file('avatar')->getClientOriginalExtension();
			ResizeImage::make($request->file('avatar'))->fit(128)->save($filename);
			if(Storage::exists('public/'.$temp_link.'.'.$request->file('avatar')->getClientOriginalExtension()))
			{
				Storage::delete('public/'.$user->avatar);
				$user->avatar=$temp_link.'.'.$request->file('avatar')->getClientOriginalExtension();
				$user->save();
			}
		}


		$user->save();
		return redirect()->route('profile');


	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
	

	  	public function profile()
	{
			


		return view('profile',['user'=>Auth::user()]);


	}
		  	public function rules()
	{
			


		return view('rules');


	}
	
	public function leaderboard()
	{
		$users=User::orderBy('score','desc')->orderBy('score','desc')->paginate(25);
		$rank = $users->firstItem();
		return view('leaderboard',['users'=>$users,'rank'=>$rank]);
	}

	  	public function view($id)
	{
			
		$challenge=Challenge::where('enabled',TRUE)->where('id',$id)->first();	

		if($challenge==null || !$challenge->is_available)
			return back()->withErrors(['errors' =>"Sorry, but this challenge is not available"]);
		return view('view',['challenge'=>$challenge]);


	}
	
	public function answer(Request $request,$id)
	{

		$validated = $request->validate([
		'answer' => 'required'
		
		]);

		$challenge=Challenge::where('enabled',TRUE)->where('available_at', '<=', now())->where('id',$id)->firstOrFail();	
		
		if($challenge->to_review_answer!==FALSE)
		{
				return back()->withErrors(['errors' =>"We need to review your last answer"]);
		}
		if($challenge->is_done)
		{
			return back()->withErrors(['errors' =>"You already answered"]);
		}
		$answer=new Answer;
		$answer->user_id=Auth::id();
		$answer->challenge_id=$challenge->id;
		$answer->content=$request->input('answer');
		$answer->save();
		
		//ASK B0B only in first 3 times
		$count=Answer::where('challenge_id',$challenge->id)->where('user_id',Auth::id())->count();
		//if($count<5)
			AskBob::dispatch($answer);
		return redirect()->back()->with('success', 'Answer was submited!');   

	}
	public function intro_done(Request $request)
	{
		$user=Auth::user();
		$user->intro=true;
		$user->save();
		return redirect()->route('challenges');
	}
	

		
		
		

		
	}