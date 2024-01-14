@include('include.header')


 <section class="section">
        <div class="container" id="app">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 is-6-desktop" id="app">
              <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">Hello, @{{ username }}!</h2>
			  
			  
			  @if(Auth::user()->money>10000 && Auth::user()->confirmed==false)
			   <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">JUSTCTF{CR1PT0_N0T_CR1Pt0}</h2>
			  
			  @endif
             
			  <div class="box">
				<p class="subtitle mb-5">Your total assets:@{{ money }} USD</p>
				
				
			  </div>
			 
			 
			 
			  <div class="box">
				<p class="subtitle mb-5">BTC Account:@{{ btcAccount }}</p>
				<p class="subtitle mb-3">BTC Balance:@{{ btcBalance }}</p>
				
				
			  </div>
			  
			  			  
			  <div class="box">
				<p class="subtitle mb-3">ETH Account:@{{ ethAccount }}</p>
				<p class="subtitle mb-3">ETH Balance:@{{ ethBalance }}</p>
				

			  </div>
			  
			  

			  
			  
			  
			  
  
			  
			  
			  
            </div>
          </div>
        </div>
</section>
       
 <section class="section">
        <div class="container">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 is-6-desktop" id="wallet-operations">
              <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">Transfer and exchange</h2>
             <h2 class="mb-5 is-size-4 ">You can exchange your funds between your accounts or send your funds to another wallets</h2>


			   <div v-if="transferSuccessMessage!== ''" class="notification is-success">@{{ transferSuccessMessage }}</div>
			   <div v-if="exchangeSuccessMessage!== ''" class="notification is-success">@{{ exchangeSuccessMessage }}</div>
			  
			  
			    <div >
					<button class="button is-primary" @click="resetForm();showExchange = true; showTransfer = false">Exchange</button>
					<button class="button is-info" @click="resetForm();showTransfer = true; showExchange = false">Transfer</button>

					<div v-if="showExchange">
					 
					  <div class="box">
					   <h2 class="mb-5 is-size-4 ">Exchange</h2>
					  <div class="field">
  <label class="label">From Wallet</label>
  <div class="control">
					 <div class="select">
					 <select v-model="exchange.walletFrom" @change="calculateExchangeRate">
						<option v-for="wallet in wallets" :key="wallet" :value="wallet">@{{ wallet }}</option>
					  </select>
					  </div>
					  </div>
					  </div>
					  
					          <div v-if="exchangeWalletFrom">
            <p>Current Amount: @{{ exchangeWalletFrom.amount }}</p>
            <p>Currency: @{{ exchangeWalletFrom.currency }}</p>
        </div>
					  
					  
					  
					  
					  
					  					  <div class="field">
  <label class="label">To Wallet</label>
  <div class="control">
					  <div class="select">
					  <select v-model="exchange.walletTo" @change="calculateExchangeRate">
						<option v-for="wallet in wallets" :key="wallet" :value="wallet">@{{ wallet }}</option>
					  </select>
					  </div>
					 				  </div>
					  </div>
					  
					  					          <div v-if="exchangeWalletTo">
            <p>Current Amount: @{{ exchangeWalletTo.amount }}</p>
            <p>Currency: @{{ exchangeWalletTo.currency }}</p>
        </div>
					  
					  
					  					  					  <div class="field">
  <label class="label">Amount</label>
  <div class="control">
					  <input  class="input" v-model="exchange.amount" type="number" @input="calculateExchangeRate" placeholder="Amount"/>
					 					 				  </div>
					  </div> 
					  
					  
					  		  <div class="field">
  <label class="label">BTC to ETH: 1 to 10</label>
  </div>
									  		  <div class="field">
  <label class="label">Exchange Rate: @{{ exchangeRate }}</label>
  </div>

					   <div class="field">
					  <button class="button is-success" :disabled="transactionInProgress" @click="performExchange">Exchange</button>
					  </div>
					 
					 					   <div v-if="errorMessage"class="notification is-danger">
 
				@{{ errorMessage }}
				</div>
					  </div>
					</div>
					
					
					

					<div v-if="showTransfer">
					<div class="box">
					   <h2 class="mb-5 is-size-4 ">Transfer</h2>
					  
					  
					  					  <div class="field">
  <label class="label">From Wallet</label>
  <div class="control">
					 <div class="select">
					  <select v-model="transfer.walletFrom"  @change="getTransferWalletInfo">
						<option v-for="wallet in wallets" :key="wallet" :value="wallet">@{{ wallet }}</option>
					  </select>
					  
									  </div>
					 				  </div>	  
					   </div>
					   
					   					  					          <div v-if="TransferWalletFrom">
            <p>Current Amount: @{{ TransferWalletFrom.amount }}</p>
            <p>Currency: @{{ TransferWalletFrom.currency }}</p>
        </div>
					 
					   
					   
					   
					  				  					  <div class="field">
  <label class="label">To Wallet (address)</label>
					  
					  <input class="input" v-model="transfer.walletTo" @blur="validateWallet" placeholder="To Wallet"/>
					  
					   </div>
					  
					  
					<div class="field">
					<label class="label">How much?</label>
					  <input class="input" v-if="validWallet" v-model="transfer.amount" type="number" placeholder="Amount"/>
					   </div>
					  <div class="field">
					  <button class="button is-success" v-if="validWallet" :disabled="transactionInProgress" @click="showPasswordPrompt = true">Transfer</button>
</div>
					  <div v-if="showPasswordPrompt" class="box">
					   <h2 class="mb-5 is-size-4 ">Confirm your transaction</h2>
					   <div class="field">
						<textarea class="textarea" v-model="transfer.password" placeholder="Your password"></textarea>
						</div>
						<div class="field">
						<button class="button is-danger" :disabled="transactionInProgress" @click="performTransfer">Sign</button>
						</div>
					  </div>
					 
					
					   
					   <div v-if="errorMessage"class="notification is-danger">
 
				@{{ errorMessage }}
				</div>
									   
					   
					   
					</div>
					</div>
				  </div>

			  
			  
			  
			  
  
			  
			  
			  
            </div>
          </div>
        </div>
</section>
         
<script>
new Vue({
  el: '#app',
  data: {
    username: '',
    btcAccount: '',
	money:'',
    ethAccount: '',
    btcBalance: '',
	 ethBalance: '',
  },
  created() {
    this.fetchUserData();
    this.fetchWalletData();
         this.interval = setInterval(this.fetchWalletData, 5000); // 10000 ms = 10 seconds
    },
    beforeDestroy() {
        // It's a good practice to clear the interval when the component is destroyed
        clearInterval(this.interval);
    },
  methods: {
    async fetchUserData() {
      try {
        // Replace 'userId' with the actual user ID
        const userId = {{Auth::user()->id}}; 
        const response = await axios.get(`/api/users/${userId}`);
        this.username = response.data.name;
      } catch (error) {
        console.error('There was an error fetching the user data:', error);
      }
    },
    async fetchWalletData() {
      try {
		  
		        const moneyResponse = await axios.get('/api/money');
        this.money = moneyResponse.data.money;

		  
		  
        const walletResponse = await axios.get('/api/wallets');
        this.btcAccount = walletResponse.data.btc_address;
        this.ethAccount = walletResponse.data.eth_address;

        // Fetch BTC balance
        const btcBalanceResponse = await axios.get(`/api/wallets/${this.btcAccount}`);
        this.btcBalance = btcBalanceResponse.data.amount;
		        const ethBalanceResponse = await axios.get(`/api/wallets/${this.ethAccount}`);
        this.ethBalance = ethBalanceResponse.data.amount;
      } catch (error) {
        console.error('There was an error fetching the wallet data:', error);
      }
    }
  }
})

           new Vue({
        el: '#wallet-operations',
        data: {
      wallets: [], // assuming wallets are strings like 'wallet1', 'wallet2' etc.
      showExchange: false,
      showTransfer: false,
      exchange: {
        walletFrom: '',
        walletTo: '',
        amount: 0
      },
	  
		exchangeWalletFrom: {
        amount: 0,
        currency: '',
       
      },
	  		exchangeWalletTo: {
        amount: 0,
        currency: '',
       
      },
	  		TransferWalletFrom: {
        amount: 0,
        currency: '',
       
      },
      transfer: {
        walletFrom: '',
        walletTo: '',
        amount: 0,
        password: ''
      },
      validWallet: false,
      showPasswordPrompt: false,
      exchangeRate: 0,
      exchangeSuccessMessage: '',
      transferSuccessMessage: '',
	  transferErrorMessage:'',
	  transactionInProgress: false,
	  errorMessage:''
  },
  methods: {
	  
	  
	              resetForm() {
                // Reset the form to its initial state
                this.showExchange = false;
                this.showTransfer = false;
				 this.transactionInProgress = false; 
				  this.showPasswordPrompt = false;
				  this.transferSuccessMessage='';
				  this.exchangeSuccessMessage='';
				  this.errorMessage='';
                // Reset other relevant data properties...
            },
	  
    async loadWallets() {
      try {
        const response = await axios.get('/api/wallets');
        this.wallets = response.data; // Update according to the actual response structure
      } catch (error) {
        console.error('There was an error fetching the wallets:', error);
      }
    },
	
	async getTransferWalletInfo() {
				try {
         response = await axios.get(`/api/wallets/${this.transfer.walletFrom}`);
        this.TransferWalletFrom.amount = response.data.amount; // Update according to the actual response structure
		this.TransferWalletFrom.currency = response.data.currency;
      } catch (error) {
        console.error('There was an error calculating the exchange rate:', error);
      }
	},
	
	
    async calculateExchangeRate() {
		
		try {
         response = await axios.get(`/api/wallets/${this.exchange.walletFrom}`);
        this.exchangeWalletFrom.amount = response.data.amount; // Update according to the actual response structure
		this.exchangeWalletFrom.currency = response.data.currency;
      } catch (error) {
        console.error('There was an error calculating the exchange rate:', error);
      }
		
				try {
         response = await axios.get(`/api/wallets/${this.exchange.walletTo}`);
        this.exchangeWalletTo.amount = response.data.amount; // Update according to the actual response structure
		this.exchangeWalletTo.currency = response.data.currency;
      } catch (error) {
       
	   
	   

	   
	   
	   

      }
		
		
		
		
      try {
        const response = await axios.post('/api/exchange/calculate', {
          walletFrom: this.exchange.walletFrom,
		  walletTo: this.exchange.walletTo,
          amount: this.exchange.amount
        });
        this.exchangeRate = response.data.amount; // Update according to the actual response structure
      } catch (error) {

		
      }
    },
    async performExchange() {
		  this.transactionInProgress = true; 
      try {
        const response=await axios.post('/api/exchange', {
          wallet_from: this.exchange.walletFrom,
          wallet_to: this.exchange.walletTo,
          amount: this.exchange.amount
        });
        this.exchangeSuccessMessage = response.data.message;
		
		setTimeout(() => {
                        this.transactionMessage = '';
                        this.resetForm();
                    }, 5000);
		
		
		
		
      } catch (error) {
                   if (error.response.data) {

                this.errorMessage = error.response.data.message;
				setTimeout(() => {                        this.errorMessage = '';                    }, 5000);
            }
		 this.transactionInProgress = false; 
		// this.transferErrorMessage=
      }
	  
    },
    async validateWallet() {
      try {
        response=await axios.get(`/api/wallets/${this.transfer.walletTo}`);
		if(response.data.currency)
        this.validWallet = true;
      } catch (error) {
        if (error.response && error.response.status === 404) {
          this.validWallet = false;
        } else {
                   if (error.response.data) {

                this.errorMessage = error.response.data.message;
				setTimeout(() => {                        this.errorMessage = '';                    }, 5000);
            }
        }
      }
    },
    async performTransfer() {
		this.transactionInProgress = true; 
      try {
        const signResponse = await axios.post(`/api/sign`, {
          from_wallet: this.transfer.walletFrom,
          to_wallet: this.transfer.walletTo,
          amount: this.transfer.amount,
          password: this.transfer.password
        });

        if (signResponse.data.signature) {
          this.showPasswordPrompt = false;
		   try {
          const transferResponse=await axios.post('/api/transfer', {
            from_wallet: this.transfer.walletFrom,
            to_wallet: this.transfer.walletTo,
            amount: this.transfer.amount,
            signature: signResponse.data.signature
          });
          this.transferSuccessMessage = 'Transaction created';
		  
		  		setTimeout(() => {
                        this.transferSuccessMessage = '';
                        this.resetForm();
                    }, 5000);
		  
		  
		    } catch (error) {
		  this.transactionInProgress = false; 
                  if (error.response.data) {

                this.errorMessage = error.response.data.message;
				setTimeout(() => {                        this.errorMessage = '';                    }, 5000);
            }
      }

		  
        }
      } catch (error) {
		  this.transactionInProgress = false; 
                  if (error.response.data) {

                this.errorMessage = error.response.data.message;
				setTimeout(() => {                        this.errorMessage = '';                    }, 5000);
            }
      }
    }
  },
  created() {
    this.loadWallets();
  }
});
</script>
         

@include('include.footer')