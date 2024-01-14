<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Answer;
class RebuildLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild leaderboard';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		foreach(User::all() as $user)
		{
			$user->score=0;
			$user->count=0;
			foreach($user->answers as $answer)
			{
				if($answer->correct)
				{
					$user->score+=100;
				}
				$user->count++;
			}
			$user->save();
		}
    }
}
