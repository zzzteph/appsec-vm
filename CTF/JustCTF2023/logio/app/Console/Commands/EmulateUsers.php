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
use Illuminate\Support\Facades\Log;
class EmulateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:emulate-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    function emulatePasswordMistype($password) {
        $mistypes = [];

  $length = mb_strlen($password);

    // QWERTY Adjacent Key Mapping
$adjacentKeys = [
    'q' => 'wa',
    'w' => 'qase',
    'e' => 'wsdr',
    'r' => 'edft',
    't' => 'rfgy',
    'y' => 'tghu',
    'u' => 'yhji',
    'i' => 'ujko',
    'o' => 'iklp',
    'p' => 'ol',
    'a' => 'qwsz',
    's' => 'qweadzxc',
    'd' => 'wersfxcv',
    'f' => 'ertdgcvb',
    'g' => 'rtyfhvbn',
    'h' => 'tyugjbnm',
    'j' => 'yuihknm',
    'k' => 'uiojlm',
    'l' => 'iopk',
    'z' => 'asx',
    'x' => 'zsdc',
    'c' => 'xdfv',
    'v' => 'cfgb',
    'b' => 'vghn',
    'n' => 'bhjm',
    'm' => 'njk'
];



        // 1. Caps Lock error (invert case)
        $mistypes[] = mb_convert_case($password, MB_CASE_UPPER_SIMPLE);
        
        // 2. Shift key error (replace numbers with their shift counterparts)
        $shiftReplacements = ['1' => '!', '2' => '@', '3' => '#', '4' => '$', '5' => '%', 
                              '6' => '^', '7' => '&', '8' => '*', '9' => '(', '0' => ')'];
        $shiftError = strtr($password, array_flip($shiftReplacements));
        $mistypes[] = $shiftError;


        // 2. Shift key error (replace numbers with their shift counterparts)
        $shiftReplacements = ['!' => '1', '@' => '2', '#' => '3', '$' => '4', '%' => '5', 
                              '^' => '6', '*' => '7', '*' => '8', '(' => '9', ')' => '0'];
        $shiftError = strtr($password, array_flip($shiftReplacements));
        $mistypes[] = $shiftError;

        // 3. Extra character at the end or beginning (duplicate of last character)
        if (mb_strlen($password) > 0) {
            $lastChar = mb_substr($password, -1);
            $mistypes[] = $password . $lastChar;
            $mistypes[] = $lastChar . $password;
        }

        // 4. Missing the last character
        if (mb_strlen($password) > 1) {
            $mistypes[] = mb_substr($password, 0, -1);
        }

    // 5. Invert case for each character individually
    $invertedCasePassword = '';
    for ($i = 0; $i < mb_strlen($password); $i++) {
        $char = mb_substr($password, $i, 1);
        $invertedCasePassword .= ctype_lower($char) ? mb_strtoupper($char) : mb_strtolower($char);
    }
    $mistypes[] = $invertedCasePassword;


    // 6. Adjacent Key Mistype
    if ($length > 0) {
        $pos = rand(0, $length - 1);
        $char = mb_substr($password, $pos, 1);
        $lowerChar = mb_strtolower($char);
        if (array_key_exists($lowerChar, $adjacentKeys)) {
            $randomAdjacentKey = $adjacentKeys[$lowerChar][rand(0, mb_strlen($adjacentKeys[$lowerChar]) - 1)];
            $mistypes[] = mb_substr($password, 0, $pos) . $randomAdjacentKey . mb_substr($password, $pos + 1);
        }
    }

    // 7. Repeated Characters
    if ($length > 0) {
        $pos = rand(0, $length - 1);
        $char = mb_substr($password, $pos, 1);
        $mistypes[] = mb_substr($password, 0, $pos) . $char . $char . mb_substr($password, $pos + 1);
    }

    // 8. Skipped Characters
    if ($length > 1) {
        $pos = rand(0, $length - 1);
        $mistypes[] = mb_substr($password, 0, $pos) . mb_substr($password, $pos + 1);
    }


        return $mistypes[array_rand($mistypes)];
}
 

        public function wrong_phrase($phrase)
        {
            		$contents = Storage::get('kek42.txt');
                    $kek42=collect();
                    $contents=explode(PHP_EOL,$contents);
                    foreach($contents as $content)
                    {
                        $kek42->push($content);
                   }
                	$words=explode(" ",$phrase);
                    
                    for($i=0;$i<6;$i++)
                    {
                        if(rand(1,5)==2)
                        {
                            $words[$i]=$kek42->random();
                        }
                    }
           echo $phrase;
           return $words[0]." ".$words[1]." ".$words[2]." ".$words[3]." ".$words[4]." ".$words[5];
        }
 
    
    	public function sign_emulation($wallet_from,$wallet_to,$password)
	{
            
			$password=explode(" ",$password);
			$valid_password=explode(" ",$wallet_from->phrase);
			$valid_password = array_filter(array_map('trim',$valid_password));
			$password = array_filter(array_map('trim', $password));
			
			if(count($valid_password)!==count($password) || count($valid_password)!=6)
			{
                 Log::error('Sign error: Password error {wallet_from}',['wallet_from'=>$wallet_from->account]); 
				return response()->json(['message' => 'Your wallet password   contains 6 words (kek42 specification)'], 500);
			}
			
			if(trim($valid_password[0])==trim($password[0]))
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                 Log::notice('Passphrase word match {account} on position 0 {account}',['account'=>$wallet_to->account,'obj'=>$obj]); 
    
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 0 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				return;
			}
			
			if(trim($valid_password[1])==trim($password[1]))
			{
                $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                  Log::notice('Passphrase word match {account} on position 1 {account}',['account'=>$wallet_to->account,'$obj'=>$obj]); 

			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                 Log::error('Sign error: Password-phrase error, Mis-match {account} on position 1 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
			return;
			}
			
			
						if(trim($valid_password[2])==trim($password[2]))
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                  Log::notice('Passphrase word match {account} on position 2 {account}',['account'=>$wallet_to->account,'obj'=>$obj]); 

			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 2 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				return;
			}
			
			
						if(trim($valid_password[3])==trim($password[3]))
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                  Log::notice('Passphrase word match {account} on position 3 {account}',['account'=>$wallet_to->account,'obj'=>$obj]); 

			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 3 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				return;
			}
			
			
						if(trim($valid_password[4])==trim($password[4]))
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                  Log::notice('Passphrase word match {account} on position 4 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 4 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
			return;
			}
			
			
			if(trim($valid_password[5])==trim($password[5]))
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::notice('Passphrase word match {account} on position 5 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$wallet_from->account,'to_wallet'=>$wallet_to->account,'phrase'=>$password));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 5 {obj}',['account'=>$wallet_to->account,'obj'=>$obj]); 
				return;
			}

	}
    
    
    public function random_user()
    {
        $users=User::where('confirmed',TRUE)->get();
		$emulated_users=collect();
		foreach($users as $user)
		{
            
			$emulated_users->push($user);
		}
        return $emulated_users->random();
    }



    public function handle()
    {
        $count=User::where('confirmed',TRUE)->count();
        $count=rand(1,intval($count/10)+2);
        
        $users=User::where('confirmed',TRUE)->get();
		$emulated_users=collect();
		foreach($users as $user)
		{
            
			$emulated_users->push($user->id);
		}
        $emulated_users=$emulated_users->random($count);
        foreach( $emulated_users as $entry)
        {
  
            $user=User::where('id',$entry)->first();
            if($user!==null)
            {
                $tmp=$this->emulatePasswordMistype($user->opass);
                if($tmp!==$user->opass)
                {
                    $req=json_encode(array('name'=>$user->name,'password'=>$tmp));
                    Log::alert('Authentification {id} failed {object}',['id'=>$user->id,'object'=> $req]);    
                    sleep(1);
                    Log::info('Authentification successful for {id}',['id'=>$user->id]);    
                

                
                }
             if(rand(1,3)==2)
             {
                 
                 $this->sign_emulation($user->btc_wallet,$this->random_user()->btc_wallet,$this->wrong_phrase($user->btc_wallet->phrase));
             }
                
                
            }
        }

     
    }
}
