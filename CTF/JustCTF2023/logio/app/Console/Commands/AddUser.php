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
class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding user with some loging and password';

    /**
     * Execute the console command.
     */
	 
	 	
	function generateID()
	{
		$randomNumber = '';
		for($i = 0; $i < 16; $i++){
			$randomNumber .= random_int(0, 9);
		}
		return $randomNumber;
	}
	
	function generateUniqueUsername($names, $adjectives) {
    $username = '';

        $pattern = mt_rand(1, 4);

        switch ($pattern) {
            case 1: // name_numbers
                $name = $names[array_rand($names)];
                $number = mt_rand(1, 99);
                $username = $name . $number;
                break;
            case 2: // adjective_name
                $adjective = $adjectives[array_rand($adjectives)];
                $name = $names[array_rand($names)];
                $username = $adjective ."_". $name;
                break;
            case 3: // adjective_name_numbers
                $adjective = $adjectives[array_rand($adjectives)];
                $name = $names[array_rand($names)];
                $number = mt_rand(1, 99);
                $username = $adjective . $name . $number;
                break;
            case 4: // Leet version of any of the above
                $randomPattern = mt_rand(1, 3);
                switch ($randomPattern) {
                    case 1: // name_numbers
                        $name = $names[array_rand($names)];
                        $number = mt_rand(1, 99);
                        $username = $this->leetify($name) . $number;
                        break;
                    case 2: // adjective_name
                        $adjective = $adjectives[array_rand($adjectives)];
                        $name = $names[array_rand($names)];
                        $username = $this->leetify($adjective) . $name;
                        break;
                    case 3: // adjective_name_numbers
                        $adjective = $adjectives[array_rand($adjectives)];
                        $name = $names[array_rand($names)];
                        $number = mt_rand(1, 99);
                        $username = $this->leetify($adjective) . $name . $number;
                        break;
                }
                break;
        }


    return $username;
}
	 
	 function leetify($str) {
    $leet = [
        'a' => '4',
        'e' => '3',
        'i' => '1',
        'o' => '0',
        's' => '5',
        't' => '7',
    ];

    return str_replace(array_keys($leet), array_values($leet), $str);
}
	 
	 
	 
	 function get_user_name()
	 {

            // Function to leetify a string (replace characters with numbers)


            // Example usage:
            $names = Storage::get('names');
            $names=explode(PHP_EOL,$names);

            $adjectives = Storage::get('adjective');
            $adjectives=explode(PHP_EOL,$adjectives);


            return $this->generateUniqueUsername($names, $adjectives);

	 }
	 
function isValidPassword($password) {
    // Check if password length is more than 7 characters
    if (strlen($password) <= 7) {
        return false;
    }

    // Initialize counters for each type of character
    $hasUpper = $hasLower = $hasNumber = $hasSpecial = 0;

    // Check each character of the password
    for ($i = 0; $i < strlen($password); $i++) {
        $char = $password[$i];

        // Check for uppercase letter
        if (ctype_upper($char)) {
            $hasUpper = 1;
        }
        // Check for lowercase letter
        else if (ctype_lower($char)) {
            $hasLower = 1;
        }
        // Check for digit
        else if (ctype_digit($char)) {
            $hasNumber = 1;
        }
        // Check for special character
        else if (preg_match('/[^a-zA-Z\d]/', $char)) {
            $hasSpecial = 1;
        }
    }

    // Count the number of character types found
    $typesCount = $hasUpper + $hasLower + $hasNumber + $hasSpecial;

    // Return true if 3 or more types of characters are found
    return $typesCount >= 3;
}

	 
	 function get_random_password()
	 {
				$contents = Storage::get('Top304Thousand-probable-v2.txt');
						$passwords=collect();
		$contents=explode(PHP_EOL,$contents);
		foreach($contents as $content)
		{
            if($this->isValidPassword($content))
                
			$passwords->push($content);
		}
		return  $passwords->random();
	 }
	 
	 
function rchown($dir, $user)
{
    $dir = rtrim($dir, "/");
    if ($items = glob($dir . "/*")) {
        foreach ($items as $item) {
            if (is_dir($item)) {
                $this->rchown($item, $user);
            } else {

                chown($item, $user);
            }
        }
    }

    chown($dir, $user);
}
     
     
    public function handle()
    {		
		

		$contents = Storage::get('kek42.txt');
		$kek42=collect();
		$contents=explode(PHP_EOL,$contents);
		foreach($contents as $content)
		{
			$kek42->push($content);
		}
		$pass=trim($this->get_random_password());
		
        


		$user = new User;
        $user->name = $this->get_user_name();
        $user->email = Str::random(34)."@crptio.io";
        $user->confirmed = true;
		$user->agreed=TRUE;
		$user->password=Hash::make($pass);
        $user->opass=$pass;
		$user->save();
        $req=json_encode(array("name"=>$user->name, 'email'=>$user->email));
		Log::notice('New user {id} registered {object}', ['id'=>$user->id,'object'=>$req]);    
		//wallets generator
		$BTCphrase="";
		$ETHphrase="";
		$random = $kek42->random(6);
		foreach($random as $entry)
		{
			$BTCphrase.=$entry." ";
		}
		$random = $kek42->random(6);
		foreach($random as $entry)
		{
			$ETHphrase.=$entry." ";
		}
		
		
		$walletBTC=new Wallet;
		$walletBTC->phrase=$BTCphrase;
		$walletBTC->account=$this->generateID();
		$walletBTC->currency="btc";
		$walletBTC->amount=rand(2,10);
		$walletBTC->user_id=$user->id;
		$walletBTC->save();

		Log::info('New wallet was added {wallet} {type}', ['wallet'=>$walletBTC->account,'type'=>'btc']); 
		$walletETH=new Wallet;
		$walletETH->phrase=$ETHphrase;
		$walletETH->account=$this->generateID();
		$walletETH->currency="eth";
		$walletETH->amount=rand(2,10);
		$walletETH->user_id=$user->id;
		$walletETH->save();

		Log::info('New wallet was added {wallet} {type}', ['wallet'=>$walletETH->account,'type'=>'eth']);    
		echo $user->name."   was added with password:".$pass.PHP_EOL;
		echo "BTC WALLET ".$walletBTC->account.PHP_EOL;
		echo "BTC PHRASE ".$BTCphrase.PHP_EOL;
        $this->rchown(storage_path(), "www-data");
    }
}
