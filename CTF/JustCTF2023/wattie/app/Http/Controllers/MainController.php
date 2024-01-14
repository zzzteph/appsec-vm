<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{



     public function start()
    {
		$user=Auth::user();
		$game=Game::where('user_id',$user->id)->where('status','done')->orderBy('score','desc')->limit(10)->get();
		return view('start',['game'=>$game]);
    }
        public function main()
        {
                return view('welcome');
        }

        public function leaderboard()
        {

				$game=Game::where('status','done')->orderBy('score','desc')->limit(50)->get();

			
                return view('leaderboard',['game'=>$game]);
        }


        public function new_game(Request $request)
    {
		       $validated = $request->validate(['difficulty' => 'required']);
			   if($request->input('difficulty')!='easy' && $request->input('difficulty')!='hard')
			   return back()->withErrors(['errors' =>"Please, select correct difficulty"]);
			   $game=new Game;
			   $game->temp_score=0;
			   $game->score=0;
			   $game->status='started';
			   $game->difficulty=$request->input('difficulty');
			   $game->started_at=Carbon::now();
			   $game->finished_at=Carbon::now();
			   $game->time_left=120;
			   $game->user_id=Auth::user()->id;
			   $game->save();
			    return redirect()->route('play',['id'=> $game->id]);
	}


    public function game($id)
    {
		$user=Auth::user();
		if($user==null)
		{
			return redirect()->route('start')->withErrors(['errors' =>"Please, start game first_GAME"]);
		}
		$game=Game::where('user_id',$user->id)->where('id',$id)->firstOrFail();
		if($game->status!='done')
		{
			return redirect()->route('start')->withErrors(['errors' =>"Please, start game first_2222"]);
		}
		 return view('game',['game'=>$game]);
    }



    public function play($id,Request $request)
    {
		$user=Auth::user();
		if($user==null)
		{
			return redirect()->route('start')->withErrors(['errors' =>"Please, start game first!!!"]);
		}
		$game=Game::where('user_id',$user->id)->where('id',$id)->firstOrFail();
		if($game->status=='done')
		{
			 return redirect()->route('game',['id'=> $game->id]);
		}
		if($game->status=='running')
		{
			return back()->withErrors(['errors' =>"The game has ended or is already running - start it again"]);
		}

		$game->status='running';
		$game->started_at=Carbon::now();
		$game->finished_at=Carbon::now()->addSeconds(60);
		$game->time_left=60;
		$game->save();
		
		if($game->difficulty=='easy')
		 return view('easy',['game'=>$game]);
		if($game->difficulty=='hard')
		 return view('hard',['game'=>$game]);
    }


        public function api_get_game($id)
        {
			$game=Game::where('id',$id)->firstOrFail();
			if($game==null)
					return response()->json(['message' => 'Not Found!'], 404);
				$finished_at=new Carbon($game->finished_at);
				$time_left=Carbon::now()->diffInSeconds($finished_at,false);
				if($time_left<0)
				{
						$time_left=0;
				}
                return response()->json(
                        [
                                'id' => $game->id,
                                'time_left' => $time_left,
								'score' =>$game->temp_score,
								'status'=>$game->status
                        ]);


        }

        public function api_post_score($id,Request $request)
        {
			$user=Auth::user();
			if($user==null)
			{
					return response()->json(['message' => 'Not Found!'], 500);
			}
			$game=Game::where('user_id',$user->id)->where('id',$id)->firstOrFail();
			if($game==null)
			{
				return response()->json(['message' => 'Not Found!'], 500);
			}
			if($game->status!='running')
			{
				return response()->json(['message' => 'Game is not running'], 500);
			}
			$game->status="done";
			$game->save();
			
			
			if($game->difficulty=="easy")
			{
				$game->score=$request->input('score');
				$game->save();
			}
			if($game->difficulty=="hard")
			{
				$delta=0;
				if($game->temp_score>$request->input('score'))
				{
					$delta=intval($game->temp_score)-intval($request->input('score'));
				}
				if($game->temp_score<$request->input('score'))
				{
					$delta=intval($request->input('score'))-intval($game->temp_score);
				}
				if($delta>3)
				{
					$game->score=-1;
				}
				else
				{
					$game->score=$request->input('score');
				}
				$game->save();
			}
		
		
        }



        public function api_update_score($id,Request $request)
        {
			$user=Auth::user();
			if($user==null)
			{
					return response()->json(['message' => 'Not Found!'], 500);
			}
			$game=Game::where('user_id',$user->id)->where('id',$id)->firstOrFail();
			if($game==null)
			{
				return response()->json(['message' => 'Not Found!'], 500);
			}
			if($game->status!='running')
			{
				return response()->json(['message' => 'Game is not running'], 500);
			}
			$value=intval($request->input('score'));
			
			if($value!==1 && $value!==-1 && $value!==-4 && $value!==-8)
			{
				return response()->json(['message' => 'Strange score'], 500);
			}
			$game->temp_score+=$value;
			if($game->temp_score<0)$game->temp_score=0;
			
			$game->save();
		
        }



        }