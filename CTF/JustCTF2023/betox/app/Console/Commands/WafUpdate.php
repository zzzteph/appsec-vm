<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class WafUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:waf-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(User::all() as $user)
		{
			$user->attempts=0;
			$user->save();
			
		}
    }
}
