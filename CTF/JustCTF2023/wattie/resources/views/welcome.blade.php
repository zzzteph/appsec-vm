
            @include('include.header')    
  
      <section class="section">
        <div class="container">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-5">
              <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Wattie the Penguin</h2>
              <p class="subtitle has-text-grey mb-5">Dive into a frosty adventure with Wattie the Penguin as you slide down icy slopes, gobble up delicious fish, and dodge towering trees!</p>
			  
			    
			    <a href="{{route('start')}}" class="button is-block is-primary is-large is-fullwidth">Start new game <i class="fas fa-sign-in-alt"></i></a>
			 
              
			  
            </div>
            <div class="column is-6 ml-auto">
              <img class="image is-fullwidth" src="/Wattie.png" alt="">
            </div>
          </div>
        </div>
      </section>
                
      <section class="section">
        <div class="container">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-5-desktop mb-5">
              <img class="image is-fullwidth" src="/hard.gif" alt="">
            </div>
            <div class="column is-6 ml-auto">
              <div>
                <h2 class="mb-6 is-size-1 is-size-3-mobile has-text-weight-bold">Game of the Year '23</h2>
                <div class="columns is-multiline">
                  <div class="column is-6 mb-5">
                    <span class="has-text-white mb-2 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 48px;height: 48px; border-radius: 50% !important;">1</span>
                    <p class="subtitle has-text-grey mt-3 mb-0">Get ready to chill with Wattie! Speed down snowy hills, feast on fishy treats, and navigate through wintry obstacles in this exhilarating web game.</p>
                  </div>
                  <div class="column is-6 mb-5">
                    <span class="has-text-white mb-2 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 48px;height: 48px; border-radius: 50% !important;">2</span>
                    <p class="subtitle has-text-grey mt-3 mb-0">Wattie's on a mission! Join him in a frost-filled escapade as he races down slippery terrains, collecting fish and evading treacherous trees.</p>
                  </div>
                  <div class="column is-6 mb-5">
                    <span class="has-text-white mb-2 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 48px;height: 48px; border-radius: 50% !important;">3</span>
                    <p class="subtitle has-text-grey mt-3 mb-0">Slide into fun with Wattie the Penguin! Can you master the icy challenges and help him become the ultimate fish collector?</p>
                  </div>
                  <div class="column is-6 mb-5">
                    <span class="has-text-white mb-2 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 48px;height: 48px; border-radius: 50% !important;">4</span>
                    <p class="subtitle has-text-grey mt-3 mb-0">Catch the wave (and the fish!) with Wattie as you embark on a slippery sprint down wintery hillsides, avoiding nature's obstacles along the way.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
                

@include('include.footer')