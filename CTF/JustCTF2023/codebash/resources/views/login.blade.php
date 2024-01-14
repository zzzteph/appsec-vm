@include('include.header') 
                
      <section class="section is-relative is-clipped"><div class="is-hidden-touch" style="position: absolute; top: 0; left: 0; width: 70%; height: 100%"></div>
        <div class="is-hidden-desktop is-fullwidth" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%"></div>
        <div class="container mx-auto is-relative">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-5-desktop mb-5">
              <div>
                <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">CodeBash</h2>
               <p class="subtitle mb-6">Dive into the intricate world of code and prepare to uncover hidden vulnerabilities! CodeBash 2023 is not just another coding contest - it's a challenge for those with an eagle eye for security flaws. If you have any questions related to codebash join our slack channels #community-ctf or #community-security.</p>
			  <p> <b>Please, use you email to sign-in</b></p>
			  </div>
            </div>
            <div class="column is-6 is-4-desktop mx-auto">
  <h3 class="mt-2 mb-4 is-size-3 has-text-weight-bold" id="countdown" v-if="countdown!=null">The next challenge will be available in @{{countdown}}</h2>
					<br/>
					<br/>
			  <div class="has-text-centered">
                    <form method="POST" action="{{route('oauth-login')}}">
						@csrf
      




                  <div class="field">
					<button class="button  py-2 is-fullwidth is-large is-rounded is-body-color"><b>Start</b></button>
                  </div>
      
                
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
	  

 @include('include.footer')