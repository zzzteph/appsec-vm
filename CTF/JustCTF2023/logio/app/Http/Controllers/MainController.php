<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
class MainController extends Controller
{
	
	
	function generateID()
	{
		$randomNumber = '';
		for($i = 0; $i < 16; $i++){
			$randomNumber .= random_int(0, 9);
		}
		return $randomNumber;
	}
	
	
	public function main()
	{
		return view('main');

	}
	
	public function login(Request $request)
    {
		return view('login');
    }
		public function register(Request $request)
    {
		return view('register');
    }
	
		public function create_account(Request $request)
    {
       $validated = $request->validate([
			'login' => 'required|max:32|min:5',
			'password' => 'required',
		]);
			
		$user=User::where('name',$request->input('login'))->first();
		if($user!=null)
		{
			return back()->withErrors(['errors' =>"Login was already taken"]);
		}
			
		$contents = Storage::get('kek42.txt');
		$kek42=collect();
		$contents=explode(PHP_EOL,$contents);
		foreach($contents as $content)
		{
			$kek42->push($content);
		}
		

		  $user = new User;
          $user->name = $request->input('login');
          $user->email = Str::random(34)."@crptio.io";
          $user->confirmed = false;
		  $user->password=Hash::make($request->input('password'));
		  $user->save();
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
		$walletBTC->amount=0;
		$walletBTC->user_id=$user->id;
		$walletBTC->save();
		$walletETH=new Wallet;
		$walletETH->phrase=$ETHphrase;
		$walletETH->account=$this->generateID();
		$walletETH->currency="eth";
		$walletETH->amount=0;
		$walletETH->user_id=$user->id;
		$walletETH->save();
		
		Auth::loginUsingId($user->id);
        Log::notice('User {id} autorized ', ['id' => $user->id]);    
        $request->session()->regenerate();

		return redirect()->route('dashboard');
    }
	

	
	public function auth(Request $request)
    {
       $validated = $request->validate([
			'login' => 'required',
			'password' => 'required',
		]);
			
		$user=User::where('name',$request->input('login'))->first();
		if($user==null)
		{
            Log::alert('Authentification failed - {login} was not found',['login'=>$request->input('login')]);    
			return redirect()->route('login',['message'=>"No such login"])->withErrors(['errors' =>"No such login"]);
		}
		
		if($user->attempts>10)
		{
            
            Log::emergency('Bruteforce attempt registered: {login} attempts {attempts}. Account locked',['login'=>$request->input('login'),'attempts'=>$user->attempts]);    
			return redirect()->route('login',['message'=>"WAF detected malicious activity. Account was locked for a minute."])->withErrors(['errors' =>"WAF detected malicious activity. Account was locked for a minute."]);
		}
		
		
		if (!Hash::check($request->input('password'), $user->password)) {
			$user->attempts=$user->attempts+1;
			$user->save();
				return redirect()->route('login',['message'=>"Password is incorrect"])->withErrors(['errors' =>"Password is incorrect"]);
			}
            
            
            Log::info('Authentification successful for {id}',['id'=>$user->id]);  
			 Auth::loginUsingId($user->id);
             $request->session()->regenerate();
return redirect()->route('dashboard');
    }





  	public function confirm()
	{
			
		if(Auth::user()->agreed==TRUE)
		{
			return redirect()->route('dashboard');
		}
		else
			
		return view('confirm');


	}
	

	public function confirmed(Request $request)
	{

		$user=Auth::user();
		$user->agreed=TRUE;
		$user->save();
		return redirect()->route('dashboard');


	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
	

	public function dashboard()
	{
		return view('dashboard');
	}
	
	
			public function api_get_money()
	{
		$user=Auth::user();
		if($user==null)
		{
			return response()->json(['message' => 'Not Found!'], 404);
		}


		return response()->json(
			[
				'money' => $user->money
			]);


	}
	
	
	
		public function api_get_stats()
	{
		

		
		$amount = Cache::remember('amount', 60, function () {
		$btc_amount = DB::table('wallets')->where('currency','btc')->sum('amount');
		$eth_amount = DB::table('wallets')->where('currency','eth')->sum('amount');

  return round($btc_amount*268+$eth_amount*14);

});
		
		



		return response()->json(
			[
				'users' => User::count(),
				'assets' => $amount,
			]);


	}
	
	
	
	
	public function api_log(Request $request)
    {
         if ($request->has(['message', 'severity'])) {

             switch($request->input('severity'))
             {
                 case 'emergency': Log::emergency($request->input('message')); break;
                 case 'alert': Log::alert($request->input('message')); break;
                 case 'critical': Log::critical($request->input('message')); break;
                 case 'error': Log::error($request->input('message')); break;
                 case 'warning': Log::warning($request->input('message')); break;
                 case 'notice': Log::notice($request->input('message')); break;
                 case 'info': Log::info($request->input('message')); break;
                 case 'debug': Log::debug($request->input('message')); break;
                 
             }
                
         }
    }
	
	//API CALLS
	public function api_get_me()
	{


		return response()->json(['name' => Auth::user()->name,'id' => Auth::user()->id]);


	}
	
	
		public function api_get_users()
	{
		
	$user=User::count();
		return response()->json(['count' => $user]);


	}
	
	
	public function api_get_wallets()
	{
		
		$user=Auth::user();
		if($user==null)
		{
			return response()->json(['message' => 'Not Found!'], 404);
		}
		return response()->json(
			[
				'btc_address' => $user->btc_wallet->account,
				'eth_address' => $user->eth_wallet->account,
			]);


	}
	
		public function api_get_wallet($id)
	{
		
		$wallet=Wallet::where('account',$id)->first();
			if($wallet!==null)
		return response()->json(
			[
				'address' => $wallet->account,
				'amount' => $wallet->amount,
				'currency' => $wallet->currency,
			]);

return response()->json(['message' => 'Not Found!'], 404);
	}
	

	
	public function api_sign(Request $request)
	{
$user=Auth::user();
		$wallet_from=Wallet::where('account',$request->input('from_wallet'))->where('user_id',$user->id)->first();
		$wallet_to=Wallet::where('account',$request->input('to_wallet'))->first();
		if($wallet_from!==null && $wallet_to!==null)
		{
			$password=$request->input('password');
			$password=explode(" ",$password);
			
			$valid_password=explode(" ",$wallet_from->phrase);
			$valid_password = array_filter(array_map('trim',$valid_password));
			$password = array_filter(array_map('trim', $password));
			
			$amount=$request->input('amount');
			if($amount<=0)
			{
                Log::error('Sign error: Not enough funds on {wallet_from}',['wallet_from'=>$wallet_from->account]); 
				return response()->json(['message' => 'Not enough funds!'],500);
			}
			
			if(count($valid_password)!==count($password) || count($valid_password)!=6)
			{
                 Log::error('Sign error: Password error {wallet_from}',['wallet_from'=>$wallet_from->account]); 
				return response()->json(['message' => 'Your wallet password   contains 6 words (kek42 specification)'], 500);
			}
			
			if(trim($valid_password[0])==trim($password[0]))
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                 Log::notice('Passphrase word match {account} on position 0 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 0 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			if(trim($valid_password[1])==trim($password[1]))
			{
                $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                  Log::notice('Passphrase word match {account} on position 1 {obj}',['account'=>$wallet_from->account,'$obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                 Log::error('Sign error: Password-phrase error, Mis-match {account} on position 1 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			
						if(trim($valid_password[2])==trim($password[2]))
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                  Log::notice('Passphrase word match {account} on position 2 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 2 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			
						if(trim($valid_password[3])==trim($password[3]))
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                  Log::notice('Passphrase word match {account} on position 3 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 3 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			
						if(trim($valid_password[4])==trim($password[4]))
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                  Log::notice('Passphrase word match {account} on position 4 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 4 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			
			if(trim($valid_password[5])==trim($password[5]))
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::notice('Passphrase word match {account} on position 5 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				usleep(500000);
			}
			else
			{
                     $obj=json_encode(array('from_wallet'=>$request->input('from_wallet'),'to_wallet'=>$request->input('to_wallet'),'phrase'=>$request->input('password')));
                Log::error('Sign error: Password-phrase error, Mis-match {account} on position 5 {obj}',['account'=>$wallet_from->account,'obj'=>$obj]); 
				return response()->json(['message' => 'Password is incorrect'], 500);
			}
			
			$signature=md5($wallet_from->phrase.$request->input('from_wallet').$request->input('to_wallet').$request->input('amount'));
			return response()->json(['signature' => $signature]);
			
		}
		return response()->json(['message' => 'Not Found!'], 404);
	}
	
	public function api_transfer(Request $request)
	{
        $user=Auth::user();
		$wallet_from=Wallet::where('account',$request->input('from_wallet'))->where('user_id',$user->id)->first();
		$wallet_to=Wallet::where('account',$request->input('to_wallet'))->first();
		$amount=$request->input('amount');
		if($wallet_from==null || $wallet_to==null)
		{
            return response()->json(['message' => 'Not Found!'], 404);
        }
		if($amount<0)
		{
            Log::error('Sign error: Not enough funds on {wallet_from}',['wallet_from'=>$wallet_from->account]); 
			return response()->json(['message' => 'Not enough funds!'],500);
		}
			
		
		$user_signature=$request->input('signature');
		$signature=md5($wallet_from->phrase.$request->input('from_wallet').$request->input('to_wallet').$request->input('amount'));
		if($user_signature==$signature)
		{
			
			if($wallet_from->currency==$wallet_to->currency)
			{
				if($wallet_from->amount>=$amount)
				{
					$wallet_from=Wallet::where('account',$request->input('from_wallet'))->first();
					$wallet_from->amount=$wallet_from->amount-$amount;
					$wallet_from->save();
					$wallet_to=Wallet::where('account',$request->input('to_wallet'))->first();
					$wallet_to->amount=$wallet_to->amount+$amount;
					$wallet_to->save();
				}
			}

			if($wallet_from->currency!=$wallet_to->currency)
			{
				if($wallet_from->amount>=$amount)
				{
					$wallet_from->amount=$wallet_from->amount-$amount;
					$wallet_from->save();
					if($wallet_from->currency=="btc" && $wallet_to->currency=="eth")
					{
						$wallet_to->amount=$wallet_to->amount+$amount*10;
						$wallet_to->save();
					}
					if($wallet_from->currency=="eth" && $wallet_to->currency=="btc")
					{
						$wallet_to->amount=$wallet_to->amount+$amount*0.1;
						$wallet_to->save();
					}
				}
			}
            Log::notice('Transfer between {wallet_from} and {wallet_to} done',['wallet_from'=>$wallet_from->account,'wallet_to'=>$wallet_to->account]); 
			return response()->json(['message' => 'success']);
		}
		return response()->json(['message' => 'Signature Failed'], 500);
	}
	


	


		
		

		
	}