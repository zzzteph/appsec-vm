<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuestUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
	 
	  
	 
	 
    public function handle(Request $request, Closure $next): Response
    {
		//check if user authed
		if(Auth::check()==false)
		{
				$user = new User;
				$user->name = $this->get_user_name();
				$user->email = $user->name."@justctf.online";
				$user->password=Hash::make(Str::random(40));
				$user->save();	
				$user->markEmailAsVerified();
				Auth::loginUsingId($user->id);
				$request->session()->regenerate();
		}
        return $next($request);
    }
}
