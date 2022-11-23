<!DOCTYPE html>
<html lang="en">
<head>
    <title>FoodDelivery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="/bulma.min.css">
    <script src="/main.js"></script>
</head>
<body>
    <div class="">
                 
      <section class="section pt-0">
        <nav class="navbar py-4">
          <div class="navbar-brand">
            
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          
        </nav>
        <div class="container pt-5">
          <div class="mb-5 is-vcentered columns is-multiline">
            <div class="column is-12 is-5-desktop mb-5 mr-auto">
              <h2 class="mb-6 is-size-1 is-size-3-mobile has-text-weight-bold">Food is good.</h2>
              <p class="subtitle has-text-grey mb-6">Best menu, best restaurants, better than ever!</p>
              <div class="buttons">
      <a class="button is-primary" href="#">Join now</a>
      </div>
            </div>
            <div class="column is-12 is-6-desktop">
              <img class="image is-fullwidth" src="400528-B2B-Sodexo-Partner-Blog-1200x900-c21157-original-1630320620.png" alt="">
            </div>
          </div>
          <div class="is-block-desktop is-hidden-touch has-text-centered">
            <button class="button p-0 is-rounded" style="width: 56px;height: 56px border-radius: 50% !important;">
              <svg class="has-text-grey-dark mx-auto" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
          </div>
        </div>
      </section>
               	@if ($errors->any() || Session::has('success'))

	 <div class="container is-size-5">
@if ($errors->any())
							<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>
  </div>
  <div class="message-body has-text-left">
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  </div>
</article>
<br/>
@endif
@if (Session::has('success'))

							<article class="message is-success">
  <div class="message-header">

  </div>
  <div class="message-body has-text-left">
   <ul>
<li>{{ Session::get('success') }}</li>
        </ul>
  </div>
</article>



@endif


 </div>

@endif 
      <section class="section is-relative is-clipped">
        <div class="is-hidden-touch has-background-primary" style="position: absolute; top: 0; left: 0; width: 70%; height: 100%"></div>
        <div class="is-hidden-desktop has-background-primary is-fullwidth" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%"></div>
        <div class="container mx-auto is-relative">
          <div class="is-vcentered columns is-multiline">
            <div class="column is-6 is-5-desktop mb-5">
              <div>
                <h2 class="has-text-white mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Are you ready to order some food?</h2>
                <p class="has-text-white mb-0">Don't wait, it's a HAMBURGER time! We have a lot of great restautrants with TERRIFIC food.</p>
              </div>
            </div>
            <div class="column is-6 is-4-desktop mx-auto">
              <div class="box has-background-light has-text-centered">
                 <form method="POST" action="{{route('authentificate')}}">
						@csrf
                  
                  <h3 class="mb-5 is-size-4 has-text-weight-bold">Register and login here!</h3>
                  <div class="field">
                    <div class="control">
                      <input class="input" type="text" name="name" placeholder="Login">
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <input class="input" type="password" name="password" placeholder="Password">
                    </div>
                  </div>
                  <button class="button is-primary mb-4 is-fullwidth">Get Started</button>
                  <a class="mb-4 is-inline-block" href="#"></a>
                  
                  
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
</body>
</html>
