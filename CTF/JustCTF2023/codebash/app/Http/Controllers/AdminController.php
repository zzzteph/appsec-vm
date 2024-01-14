<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Answer;
use Carbon\Carbon;
use Laravolt\Avatar\Avatar;
class AdminController extends Controller
{
	
	public function list_challenges()
	{
		return view
		(	'admin.challenges.list',
			[
				'challenges' => Challenge::orderBy('available_at','DESC')->get()
			]
		);
	}
	
	public function new_challenge()
	{
			return view	('admin.challenges.insert');
	}
	public function insert_challenge(Request $request)
	{
		$validated = $request->validate([
		'title' => 'required',
					'content' => 'required',
					'answer'=>'required',
					'available_at'=>'required|date'
		
		]);

		$challenge=new Challenge;
		$challenge->title=$request->input('title');
		$challenge->content=$request->input('content');
		$challenge->answer=$request->input('answer');
		$challenge->available_at=$request->input('available_at');
		if($request->has('enabled'))
		{
			$challenge->enabled=TRUE;
		}
		$challenge->save();
		return redirect()->route('edit_challenge', ['id' => $challenge->id]);
	}
	
	public function edit_challenge($id)
	{

		return view
		(	
		'admin.challenges.update',
			[
				'challenge' =>Challenge::findOrFail($id)
			]
		);
	}
	
		public function update_challenge(Request $request,$id)
	{

		$validated = $request->validate([
					'title' => 'required',
					'content' => 'required',
					'answer'=>'required',
					'available_at'=>'required|date'
		
		]);

		
		$challenge=Challenge::findOrFail($id);
		$challenge->title=$request->input('title');
		$challenge->content=$request->input('content');
		$challenge->answer=$request->input('answer');
		$challenge->available_at=$request->input('available_at');
		if($request->has('enabled'))
		{
			$challenge->enabled=TRUE;
		}
		else
		{
			$challenge->enabled=FALSE;;
		}

		$challenge->save();
		return redirect()->route('edit_challenge', ['id' => $challenge->id]);
	}
	
	
	
	public function view_challenge($id)
	{
		return view
		(	
		'admin.challenges.view',
			[
				'challenge' =>Challenge::findOrFail($id)
			]
		);
	}
	



	
  	public function answers(Request $request)
	{

		if($request->query('type')==="review")
		{
			$answers=Answer::where('reviewed',false)->orderBy('created_at','desc')->paginate(50);
			$title="Answers to review";
		}
		else 
		{
		$answers=Answer::orderBy('created_at','desc')->paginate(50);
		$title="All user answers";
		}
			
		return view('admin.answers.list',['answers'=>$answers,'title'=>$title]);


	}
	

	
	public function view_answer($id)
	{
			
		$answer=Answer::findOrFail($id);
		return view('admin.answers.view',['answer'=>$answer]);
	}
	
	public function correct_answer($id)
	{
			
		$answer=Answer::findOrFail($id);
		$answer->user_review=true;
		$answer->reviewed=true;
		$answer->correct=true;
		$answer->save();
		
		
		$challenge=$answer->challenge;
		$user=$answer->user;
		
		$answers=Answer::where('reviewed',false)->where('user_id',$user->id)->where('challenge_id',$challenge->id)->get();
		foreach($answers as $answer)
		{
			$answer->delete();
		}
		
		
		return redirect()->route('answers');
	}
	

	public function wrong_answer($id)
	{
			
		$answer=Answer::findOrFail($id);
		$answer->user_review=true;
		$answer->reviewed=true;
		$answer->correct=false;
		$answer->save();
		return redirect()->route('answers');
		
	}
		
		
		

	public function delete_answer($id)
	{
			
		$answer=Answer::findOrFail($id);
		$answer->delete();
		return redirect()->route('answers');
	}
		
		
	}