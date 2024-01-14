<!DOCTYPE html>
<html lang="en">
<head>
    <title>CryIO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains+Mono:400&amp;subset=latin">
    <link rel="stylesheet" href="{{ asset('assets/css/inter.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bulma.min.css')}}">
    <script src="{{ asset('assets/js/main.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/vue.js')}}" type="text/javascript"></script>
</head>
<body>
    <div class="">
                

 <section class="section">
        <div class="container" id="app">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 is-6-desktop">
              <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">Hello, {{Auth::user()->name}}!</h2>
              <p class="subtitle mb-5">We are using <a href="/kek42.txt">kek42</a> to generate below password phrases for your wallets. </p>
			  <p class="subtitle mb-5">Please, download all your phrases, cause without them, you will loose access to your wallets </p>
			  
             <p class="subtitle mb-5">We added little amount of funds to each of your wallets =)  </p>
			  
			  
			  
			  <div class="box">
				<p class="subtitle mb-5">BTC Account:{{Auth::user()->btc_wallet->account}}</p>
				<div class="field">
				  <label class="label">Password phrase</label>
				  <div class="control">
				   <textarea class="textarea is-primary">{{Auth::user()->btc_wallet->phrase}}</textarea>
				  </div>
				</div>
				
				
				
				
			  </div>
			  
			  			  
			  <div class="box">
				<p class="subtitle mb-5">ETH Account:{{Auth::user()->eth_wallet->account}}</p>
				<div class="field">
				  <label class="label">Password phrase</label>
				  <div class="control">
				   <textarea class="textarea is-primary">{{Auth::user()->eth_wallet->phrase}}</textarea>
				  </div>
				</div>
			  </div>
			  
			  
			  
			  <div class="field">
			  <div class="control">
				<label class="checkbox">
				  <input type="checkbox"  id="checkbox1" v-model="checkbox1">
				  I agree that Password phrases could not be recovered.
				</label>
			  </div>
			</div>
			
			<div class="field">
			  <div class="control">
				<label class="checkbox">
				  <input type="checkbox" v-model="checkbox2" :disabled="!checkbox1">
				I downloaded my Password phrases to my wallets
				</label>
			  </div>
			</div>
			



			          <form method="POST" action="{{route('confirm')}}">
		  @csrf
			 @method('PUT')
			  <button :disabled="!checkbox1 || !checkbox2" class="button is-primary mb-4 is-fullwidth">Go to the dashboard</button>
			  
			  </form>
			  
			  
			  
			  
			  
  
			  
			  
			  
            </div>
          </div>
        </div>
</section>
                
      <section class="section">
        <div class="container">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6">
              <a class="is-inline-block" href="#">
                
              </a>
              <div class="py-4 is-hidden-mobile"></div>
              <p class="is-hidden-mobile">All rights reserved © CrptIO Corporation 2023</p>
            </div>
            <div class="column is-6">
              
            </div>
          </div>
          <p class="is-hidden-tablet mt-4 has-text-center">All rights reserved © CrptIO Corporation 2023</p>
        </div>
      </section>
    </div>
</body>


<script>
new Vue({
  el: '#app',
  data: {
    checkbox1: false,
    checkbox2: false
  }
})
</script>
			

</html>
