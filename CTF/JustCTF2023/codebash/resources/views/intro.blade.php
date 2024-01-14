@include('include.header') 


<section class="section">
 
  <div class="container" >
          <h1 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Hello and Welcome to Codebash Challenge Series!</h1>
			<div class="content">
	<p>Explore the guidelines of our Challenge, accompanied by brief videos.</p>
    
    <p>This page also offers settings you can later adjust in your profile.</p>
    
  
  
  <form method="POST" action="{{route('intro_done')}}">
@csrf





<!--
<div class="field ">
	<label class="checkbox">
	  <input type="checkbox">
	 <b>I would like to receive email notifications when my answer is evaluated.</b>
	</label>
</div>
-->		
		
	<div class="field ">
	<label class="checkbox">
	  <input type="checkbox" id="rulesCheckbox">
	  I've read the rules.
	</label>
</div>	
		
		
	<div class="field is-fullwidth">
		<div class="control">
			<button class="button is-link is-large"  id="proceedButton" disabled>Let's CodeBash!</button>
		</div>
	</div>
</form>


  
  

	</div>
 </div>
 </section>

<hr/>

<section class="section">
 
  <div class="container" >
          <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Rules</h2>

        <div class="content">
            <ol>
                <li>A new challenge will be posted daily.</li>
                <li>These challenges can be in any recognized programming language.</li>
                <li>Your task is to spot the vulnerability in the given code snippet.</li>
                <li>Detail your answer in the message box.</li>
                <li>Accurate answers earn you 100 points each.</li>
                <li>Please note, reviews of your answers might not be instant.</li>
            </ol>
        </div>
        
        <h2 class="subtitle">Example:</h2>
        <div class="content">
            <b>Code Snippet:</b>
            <pre><code>String query = "SELECT secret FROM Users WHERE (username = '" + username + "' AND NOT role = 'admin')";</code></pre>
            <b>Acceptable Answer:</b>
            <p>SQL injection</p>
            <b>Outstanding Answer:</b>
            <p>SQL injection because the 'username' input is directly included into the SQL query without any safety checks or sanitization.</p>
            <b>Incorrect Answer:</b>
            <p>Injection</p>
        </div>
 </div>
 </section>

<hr/>
<section class="section">
 
  <div class="container" >
  
   <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Video example</h2>
  
<div class="box">
    <video controls>
        <source src="/CodeBash.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
  </div>
  
  
 </section> 



<script>
    document.getElementById('rulesCheckbox').addEventListener('change', function() {
        const proceedButton = document.getElementById('proceedButton');
        proceedButton.disabled = !this.checked;
    });
</script>
	  @include('include.footer')