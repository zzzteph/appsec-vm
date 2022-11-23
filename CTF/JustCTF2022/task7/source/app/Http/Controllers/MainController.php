<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Jobs\LaunchAdmin;
class MainController extends Controller
{
	
	
		public function admin()
	{

           Auth::loginUsingId(1);
           return redirect()->route('main'); 

	}
	
	
	
	
	public function authentificate(Request $request)
	{

        $credentials = $request->validate([
            'name' => 'required|max:60',
            'password' => 'required',
        ]);
       	$user = User::where('name', $request->input('name'))->first();
			if(is_null($user)){	

				$user = new User;
				$user->name =$request->input('name') ;
				$user->email = Str::random(10).'@google.com';
				$user->password=Hash::make($request->input('password'));
				$user->save();		



			}	
			if (!Hash::check($request->input('password'), $user->password)) {
    				return back()->withErrors([
						'message' => 'User or password wrong',
					]);
			}
			
           Auth::loginUsingId($user->id);
           return redirect()->route('main'); 

	}
	
	
		public function post(Request $request)
	{
		
        $credentials = $request->validate([
            'message' => 'required'
        ]);
		$user=Auth::user();
		$message=new Message;
		$message->from=$user->name;
		$message->user_id=$user->id;
		$message->message=$request->input('message');
		$message->save();
		LaunchAdmin::dispatch($message->id);
		 return back();
		
		
	}	
	
	public function change(Request $request)
	{
        $credentials = $request->validate([
            'new_password' => 'required',
			'old_password' => 'required'
        ]);
		if($request->input('new_password')!=$request->input('old_password'))
		{
			return back()->withErrors(['errors' =>"passwords mismatch"]);
		}
		$user=Auth::user();
	$user->password=Hash::make($request->input('password'));
				$user->save();		
		
		 return back()->with(['success' =>"Passwords changed"]);	
	}	
	
	
				public function flag(Request $request)
	{
		
		$user=Auth::user();
		if($user->id==1)
		{
			echo "Flag is:".env("FLAG");
			if($request->ajax())
				{
					echo "THIS IS NOT A FLAG. You need to navigate it without AJAX";
				}	
		}

		
		
	}	

			public function view($message_id)
	{
		
		$user=Auth::user();
		if($user->id!==1)
		{
			$message=Message::where('user_id', $user->id)->where('id',$message_id)->first();
		}
		else
		{
			$message=Message::where('id',$message_id)->first();
		}
		
		
			return view('view',['message' => $message]);
		
		
	}	
	public function settings()
	{
		return view('settings');
	}	
	

	public function list()
	{
		$messages=Message::where('user_id',Auth::id())->orderBy('id', 'desc')->paginate(50);
		return view('list',['messages' => $messages]);
	}	


  	public function login()
	{
		if(!Auth::check())
		{
			return view('welcome');	
		}
		else	
			return redirect()->route('main');
	}


	
  	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('welcome');
	}
	

	
	

		
		
		

		
	}