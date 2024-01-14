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
	<link href="{{ asset('fontawesome/css/all.css')}}" rel="stylesheet">
	<script src="{{ asset('assets/js/vue.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/axios.min.js')}}" type="text/javascript"></script>
	
	
</head>
<body>
    <div class="" id="app">
                
      <section class="section">
        <div class="container">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 has-text-centered">
              <span class="has-text-grey-dark">The future is here</span>
              <h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">CrptIO</h2>
              <p class="subtitle has-text-grey mb-5">The place to manage all crypto assets. 
      Say goodbye to fiat old world.</p>
              <div class="buttons is-centered">
      <a class="button is-primary is-large" href="{{route('login')}}">Access the Wallet</a>
      </div>
            </div>
          </div>
        </div>
      </section>
                
      <section class="section"><div class="container">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-6-desktop mb-5 has-text-centered">
              <h3 class="is-size-1 is-size-3-mobile has-text-weight-bold" contenteditable="false">@{{users}}</h3>
              <p class="" contenteditable="false">Users</p>
            </div>
            <div class="column is-6 is-6-desktop mb-5 has-text-centered">
              <h3 class="is-size-1 is-size-3-mobile has-text-weight-bold" contenteditable="false">@{{assets}} USD</h3>
              <p class="" contenteditable="false">Assets</p>
            </div>
          </div>
        </div>
      </section>
                
      <section class="section">
        <div class="container">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-5-desktop mr-auto">
              <img class="mx-auto image is-fullwidth" src="images/8-f325mBu2V1uk83o.png" alt="">
            </div>
            <div class="column is-6">
              <div>
                <img class="mb-3 is-block image is-fullwidth" style="height: 64px; width: 64px;" src="bulma-plain-assets/images/quote.svg" alt="">
                <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">CrptIO is the pinacle of crypto wallets</h2>
                <p class="mb-6">My life was a miserable, until I decided to develop CrtpIO. With  all it's functionality and features, and new connections... Change your life now!</p>
                <h4 class="is-size-5 has-text-weight-bold">Bob Stephanson</h4>
                <p class="">CEO &amp; Founder</p>
              </div>
            </div>
          </div>
        </div>
      </section>
	  
	  
	        <section class="section">
        <div class="container">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 has-text-centered">
   
    
              <div class="buttons is-centered">
					<a class="button is-primary is-large" href="/kek42.pdf">Download our research paper.</a>
			</div>
            </div>
          </div>
        </div>
      </section>
                
	  	        <section class="section">
        <div class="container">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 has-text-centered">
 
    
              <div class="buttons is-centered">
					<a class="button is-primary is-large" href="/kek42.txt">Generate your own phrase with KEK42 Security </a>
			</div>
            </div>
          </div>
        </div>
      </section>
                
	  
    </div>
</body>


<script>

new Vue({
  el: '#app',
  data: {
    users: '',
    assets: '',
  },
  created() {

    this.fetchStatsData();
         this.interval = setInterval(this.fetchStatsData, 5000); // 10000 ms = 10 seconds
    },
    beforeDestroy() {
        // It's a good practice to clear the interval when the component is destroyed
        clearInterval(this.interval);
    },
  methods: {
    async fetchStatsData() {
      try {
        const statsResponse = await axios.get('/api/stats');
        this.users = statsResponse.data.users;
        this.assets = statsResponse.data.assets;

      } catch (error) {
        console.error('There was an error fetching the wallet data:', error);
      }
    }
  }
});
</script>



</html>
