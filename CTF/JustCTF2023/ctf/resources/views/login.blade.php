
				
				<!DOCTYPE html>
<html lang="en">
<head>
    <title>JUST CTF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono:400&amp;subset=latin">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="/bulma.min.css">

    <script src="/main.js"></script>
</head>
<body>
    <div class="">
                
      <div class="columns is-multiline">
        
        <div class="column is-4-desktop">
      
      </div>
        
      </div>
                
      <section class="section is-relative is-clipped"><div class="is-hidden-touch" style="position: absolute; top: 0; left: 0; width: 70%; height: 100%"></div>
        <div class="is-hidden-desktop is-fullwidth" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%"></div>
        <div class="container mx-auto is-relative">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-5-desktop mb-5">
              <div>
                <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">JUST CTF</h2>
               <p class="subtitle mb-6">Welcome to our Continiuos CTF! The goal is to solve tasks related to information security. There is no pre-registration for a quest. If you have any questions related to security  join our #community-security or #community-ctf slack-channels.</p>
			  <p> <strong>Please, use you email to sign-in</strong></p>
			  </div>
            </div>
            <div class="column is-6 is-4-desktop mx-auto">
              <div class="box has-text-centered">
                    <form method="POST" action="{{route('oauth-login')}}">
						@csrf
      

                  <div class="field">
                    <div class="control">
                      <img class="image is-fullwidth" src="MOSHED-2022-9-18-15-55-52.gif" alt="">
      </div>
                  </div>
      
                  <button class="button is-primary py-2 is-fullwidth is-large">Sign in!</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
                    </div>
</body>
</html>
