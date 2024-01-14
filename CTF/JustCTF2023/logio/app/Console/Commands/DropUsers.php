<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class DropUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:drop-users';

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
           
		   
		   if(($user->money<0 || $user->money>=20000) && $user->confirmed==false)
		 {
			   echo $user->name."   ".$user->money.PHP_EOL;
			   $user->delete();
		  }
          
          if($user->confirmed==true && $user->money<1000)
          {
              $wallet=Wallet::where('user_id',$user->id)->where('currency','btc')->first();
              if($wallet->amount<2)
              {
                  $wallet->amount=rand(2,10);
                  $wallet->save();
                  echo "User ".$user->id." wallet BTC was refilled with ".   $wallet->amount.PHP_EOL;
              }
              
              $wallet=Wallet::where('user_id',$user->id)->where('currency','eth')->first();
              if($wallet->amount<2)
              {
                 
                  $wallet->amount=rand(2,10);
                  $wallet->save();
                  echo "User ".$user->id." wallet ETH was refilled with ".   $wallet->amount.PHP_EOL;
              }
              
          }
          
          
	   }
		   
    }
}
