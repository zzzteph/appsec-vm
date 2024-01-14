@include('include.header') 


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

                

	  @include('include.footer')