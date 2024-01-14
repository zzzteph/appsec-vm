@include('include.header') 

          <section class="section">
        <div class="container">
          <div class="mb-6 columns is-multiline is-centered">
            <div class="column is-8 has-text-centered">
              
              <h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Codebash Challenge</h2>
              <p class="subtitle">Embark on a journey through lines of code, and discover the unseen threats that await!</p>
			  
			  <p class="subtitle" id="countdown" v-if="countdown!=null">The next challenge will be available in <b>@{{countdown}}</b></p>
            </div>
          </div>

  <div class="mb-5 columns is-multiline" id="challenges">
    <div 
      v-for="challenge in challenges" 
      :key="challenge.id" 
      class="column is-6 is-4-desktop mb-4"
    >
      <a :href="challenge.is_available ? `/challenges/${challenge.id}` : '#'" @click="challenge.is_available ? '' : showAvailabilityMessage(challenge)">
        <div 
          :class="[
            'box', 'p-5', 
            challenge.is_done ? 'has-background-success' :
            challenge.is_review ? 'has-background-info' :
            !challenge.is_available ? 'has-background-dark' : 'has-background-light'
          ]"
        >
          <div class="mb-4 is-relative">
            <span 
              :class="challenge.is_done ? 'has-text-gray' : 'has-text-primary'"
            >
			
	
              <b v-if="!challenge.is_available">@{{ challenge.available_at }} <i>(@{{challenge.countdown}})</i></b>
			  <b v-else>@{{ challenge.available_at }}</b>
			  
            </span>
            <span 
              v-if="!challenge.is_done && challenge.count_answers > 0 && !challenge.is_review"
              class="icon has-text-danger" 
              style="position: absolute; top: 0; right: 0; z-index: 1;"
            >
              <i class="fa-solid fa-xmark"></i>
            </span>
            <span 
              v-if="!challenge.is_done && challenge.is_review"
              class="icon" 
              style="position: absolute; top: 0; right: 0; z-index: 1;"
            >
              <i class="fa-regular fa-circle-question"></i>
            </span>
            <span 
              v-if="challenge.is_done"
              class="icon has-text-black" 
              style="position: absolute; top: 0; right: 0; z-index: 1;"
            >
              <i class="fa-regular fa-square-check"></i>
            </span>
          </div>
          <h2 
            class="mt-2 mb-4 is-size-3 is-size-3-mobile has-text-weight-bold"
            :class="challenge.is_done ? '' : 'has-text-primary'"
          >
            @{{ challenge.title }}
          </h2>
        </div>
      </a>
    </div>
  </div>
        

        </div>
      </section>
	  
	  
	  
	  @include('include.footer')