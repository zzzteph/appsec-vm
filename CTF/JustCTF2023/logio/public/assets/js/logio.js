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
        
                async logMessage(message,severity)
        {
                        try {
            await axios.post(`https://logio-kibana.justctf.online/api/log`, {            message: message,severity:severity         });
            } catch (error) {
              console.error('There was an error fetching the wallets:', error);
            }
        },
         
        
      async fetchUserData() {
        try {
          // Replace 'userId' with the actual user ID
          this.logMessage("Loading user info","info");
          const response = await axios.get(`/api/me`);
          this.username = response.data.name;
          this.logMessage(`Loaded use ${ this.username}`,"info");
        } catch (error) {
            this.logMessage(error,"error");
       
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
          this.logMessage(error,"error");
        }
      }
    }
  });
  
             new Vue({
          el: '#wallet-operations',
          data: {
        wallets: [], // assuming wallets are strings like 'wallet1', 'wallet2' etc.
  
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
  
        transferSuccessMessage: '',
        transferErrorMessage:'',
        transactionInProgress: false,
        errorMessage:''
    },
    methods: {
        
        
                    resetForm() {
                  // Reset the form to its initial state
                   this.transactionInProgress = false; 
                    this.showPasswordPrompt = false;
                    this.transferSuccessMessage='';
                    this.errorMessage='';
                  // Reset other relevant data properties...
              },
                async logMessage(message,severity)
        {
                        try {
            await axios.post(`https://logio-kibana.justctf.online/api/log`, {            message: message,severity:severity         });
            } catch (error) {
              console.error('There was an error fetching the wallets:', error);
            }
        },
      async loadWallets() {
        try {
            this.logMessage("Loading wallets","info");
          const response = await axios.get('/api/wallets');
          this.wallets = response.data; // Update according to the actual response structure
        } catch (error) {
          this.logMessage(error,"error");
        }
      },
      
      async getTransferWalletInfo() {
                  try {
                       this.logMessage(`Loading wallet ${this.transfer.walletFrom}`,"info");
           response = await axios.get(`/api/wallets/${this.transfer.walletFrom}`);
          this.TransferWalletFrom.amount = response.data.amount; // Update according to the actual response structure
          this.TransferWalletFrom.currency = response.data.currency;
        } catch (error) {
          this.logMessage(error,"error");
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