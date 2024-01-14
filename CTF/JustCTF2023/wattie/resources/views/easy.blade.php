
            @include('include.header')    
<div id="app">


    <section class="section">
        <div class="container">
            <div class="columns is-multiline is-centered">
                <div class="column is-6 is-6-desktop" >
                    <div class="game-container" id="game">
                        <img :src="userImage" :style="{left: userX + 'px', top: userY + 'px'}" class="wattie" />
                        <img v-for="obstacle in obstacles" :src="obstacle.image" :style="{left: obstacle.x + 'px', top: obstacle.y + 'px'}" class="obstacle" />
                    </div>
                </div>
				
				                <div class="column" >
								 <div class="score-container">
<h2 class="subtitle">Rules</h2>
<p> Help <b>Wattie</b> to collect <span class="icon"><i class="fa-solid fa-fish"></i></span>, you have <b>60 seconds</b> for that! Use <b>Arrow Keys</b> to move Wattie</p>
<hr/>

<div class="flex-container">
    <figure class="image is-32x32">
        <img src="https://wattie.justctf.online/tree.svg" alt="Description">
    </figure>
    <span> if you hit, you loose 1 fish.</span>
</div>

<div class="flex-container">
    <figure class="image is-32x32">
        <img src="https://wattie.justctf.online/wolf.svg" alt="Description">
    </figure>
    <span> will bite your for 4 fish.</span>
</div>

<div class="flex-container">
    <figure class="image is-32x32">
        <img src="https://wattie.justctf.online/wolf.svg" alt="Description">
    </figure>
    <span> can jump sometimes!</span>
</div>


<hr/>
</div>

				  <div class="score-container">
				 
					
					<progress id="time-progress" class="progress is-primary" value="60" max="60"></progress>

					</div>
				 <div class="score-container">
				 <hr/>
					<div id="fish-score-container"></div>
					</div>

                </div>
				
				
            </div>
        </div>
    </section>

	
	
</div>
                
     
               <script>
    new Vue({
        el: '#app',
        data: {
            userImage: 'https://wattie.justctf.online/user.svg',
            treeImage: 'https://wattie.justctf.online/tree.svg',
            fishImage: 'https://wattie.justctf.online/fish.svg',
			 wolfImage: 'https://wattie.justctf.online/wolf.svg',
			  bearImage: 'https://wattie.justctf.online/bear.svg',
            userX: 320 - 64,
            userY: 336,
			userMovement: 0,
            obstacles: [],
            speedModifier: 10,
            gameInterval: null,
			obstacleInterval: null,
			fishInterval:null,
            timeLeft: 0,
            score: 0
        },
        mounted() {
            document.addEventListener('keydown', this.moveUser);
            this.gameInterval = setInterval(() => {
              
                this.moveObstacles();
                this.checkCollisions();
            }, 100);
            
			            this.obstacleInterval = setInterval(() => {
              this.wolfJump();
                this.addObstacle();
            }, 1000);
            
			 this.fishInterval = setInterval(() => {
              
                this.addFish();
            }, 2000);
			
			
            setInterval(() => {
                this.fetchGameData({{$game->id}}); 
            }, 1000);
        },
        beforeDestroy() {
            document.removeEventListener('keydown', this.moveUser);
            clearInterval(this.gameInterval);
			clearInterval(this.obstacleInterval);
			clearInterval(this.fishInterval);
        },
        methods: {
			
updateScoreDisplay() {
    const fishContainer = document.getElementById('fish-score-container');
    fishContainer.innerHTML = '';


    for (let i = 0; i < this.score; i++) {
        const fishImg = document.createElement('img');
        fishImg.src = 'https://wattie.justctf.online/fish.svg';
        fishContainer.appendChild(fishImg);
    }
},

        postScore(gameId) {
            try {
                fetch(`/api/game/${gameId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ score: this.score })
                });
            } catch (error) {
                console.error( error);
            }
			
        },
  
			
			updateProgressBar() {
    const progressBar = document.getElementById('time-progress');
    progressBar.value = this.timeLeft;

    progressBar.classList.remove('is-success', 'is-warning', 'is-danger');

    if (this.timeLeft > 40) {
        progressBar.classList.add('is-success');
    } else if (this.timeLeft <= 40 && this.timeLeft > 20) {
        progressBar.classList.add('is-warning');
    } else {
        progressBar.classList.add('is-danger');
    }
},
			
						wolfJump() {

                for (let obstacle of this.obstacles) {


					if(Math.floor(Math.random() * 10)>7)
					{
						if(obstacle.image==this.wolfImage)
						{
							if(obstacle.x!=this.userX)
							{
								if(obstacle.x>this.userX)
								{
									if(obstacle.x>0)
									obstacle.x-=64; 
								}
								if(obstacle.x<this.userX)
								{
									if( obstacle.x<320 - 64)
									obstacle.x+=64;
									
								}
							}
							
						}
					}

                }
            },
			
			
            moveUser(event) {
				
				    let gameElement = document.getElementById('game');
					let currentBgPosition = getComputedStyle(gameElement).getPropertyValue('background-position').split(" ")[0].replace('px', '');
					let newBgPosition = parseInt(currentBgPosition) + 5;  
					gameElement.style.backgroundPosition = newBgPosition + "px 0";
				
				
                const stepSize = 5;
                switch (event.key) {
        case 'ArrowLeft':
            this.userX -= 64;
			this.userMovement=0;
            if (this.userX < 0) this.userX = 0;
            break;
        case 'ArrowRight':
            this.userX += 64;
			this.userMovement=0;
			console.log(window.innerWidth);
            if (this.userX > 320 - 64) this.userX = 320- 64; 
            break;
                }
            },
			
			
			            addFish() {
                const obstacleTypes = [
					{ image: this.fishImage, speed: 1 }
                ];
				

				
                const randomObstacleType = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
                var randomX = 64*(Math.floor(Math.random() * 6));
                this.obstacles.push({
                    x: randomX,
                    y: -64,
                    image: randomObstacleType.image,
                    speed: randomObstacleType.speed
                });
            },
			
			
            addObstacle() {
                const obstacleTypes = [
                    { image: this.treeImage, speed: 1 },
                    { image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.treeImage, speed: 1 },
					{ image: this.wolfImage, speed: 1.5 },
					{ image: this.wolfImage, speed: 1.5 },

                ];
				

				
                const randomObstacleType = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
                var randomX = 64*(Math.floor(Math.random() * 6));

				
				if(Math.floor(Math.random() * 10)>7)
				{
					randomX=this.userX;
				}
				if(this.userMovement>30)
				{
					randomX=this.userX;
					this.userMovement=0;
				}

                this.obstacles.push({
                    x: randomX,
                    y: -64,
                    image: randomObstacleType.image,
                    speed: randomObstacleType.speed
                });
            },
            moveObstacles() {
				this.userMovement+=1;
                for (let obstacle of this.obstacles) {
                    obstacle.y += obstacle.speed * this.speedModifier;
                    if (obstacle.y > 400) {
                        this.obstacles.splice(this.obstacles.indexOf(obstacle), 1);
                    }
                }
            },
checkCollisions() {
    for (let obstacle of this.obstacles) {
        if (this.userX < obstacle.x + 64 &&
            this.userX + 64 > obstacle.x &&
            this.userY < obstacle.y + 64 &&
            this.userY + 64 > obstacle.y) {

            if (obstacle.image === this.treeImage) {
				
                this.score -= 1;
			
				
            }
			 else if (obstacle.image === this.wolfImage) {
				
                this.score -= 4;
			
				
            } 
						 else if (obstacle.image === this.bearImage) {
				
                this.score -= 8;
			
				
            } 
			
			else if (obstacle.image === this.fishImage) {
                this.score += 1;
				this.updateScoreDisplay();
            }
			if(this.score<0)this.score=0;
this.updateScoreDisplay();
           
            this.obstacles.splice(this.obstacles.indexOf(obstacle), 1);
        }
    }
},
            fetchGameData(gameId) {
                fetch(`/api/game/${gameId}`)
                    .then(response => response.json())
                    .then(data => {
                        this.timeLeft = data.time_left;
						this.updateProgressBar();
					 if (this.timeLeft <= 0) {
							this.postScore(gameId);
							location.reload();
						}
                    })
                    .catch(error => {
                        console.error( error);
                    });
            }
        }
    });
</script> 

@include('include.footer')