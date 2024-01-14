@include('include.header')


 <section class="section">
        <div class="container" id="app">
          <div class="columns is-multiline is-centered">
            <div class="column is-8 is-6-desktop" id="app">
              <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">Hello, @{{ username }}!</h2>
			  
			  
			  @if(Auth::user()->money>20000 && Auth::user()->confirmed==false)
			   <h2 class="mb-5 is-size-1 is-size-3-mobile has-text-weight-bold">JUSTCTF{TRI_T0_l0g_2}</h2>
			  
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
			  
			  
			    <div >


					
					
					

					<div>
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
         
<script src="{{ asset('assets/js/logio.js')}}" type="text/javascript"></script>

@include('include.footer')