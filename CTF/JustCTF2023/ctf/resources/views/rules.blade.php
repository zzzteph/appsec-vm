@include('include.header') 


<section class="section">
 
  <div class="container" >
          <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Rules</h2>

        <!-- Scoring System -->
        <div class="box">
            <h2 class="subtitle is-3">Scoring System</h2>

            <ul>
                <li class="mb-3"><strong>First Submission:</strong> 100 points</li>
                <li class="mb-3"><strong>Second Submission:</strong> 75 points</li>
                <li class="mb-3"><strong>Third Submission:</strong> 50 points</li>
                <li class="mb-3"><strong>Fourth Submission:</strong> 25 points</li>
                <li class="mb-3"><strong>All Subsequent Submissions:</strong> 10 points</li>
				 <li class="mb-3"><strong>Points for Archived Tasks:</strong> No points will be awarded for tasks that are archived or no longer active. You still can complete them, but your score will not be increased</li>
            </ul>
            
        </div>

        <!-- Gameplay -->
        <div class="box">
            <h2 class="subtitle is-3">Gameplay</h2>
            
            <h3 class="subtitle is-4">Objective</h3>
            <p class="mb-6">Participants are required to find and exploit vulnerabilities in the provided tasks. The goal is to uncover the flag, which is a unique secret string. If not specified in the task, flags may be located in the filesystem(<code>/var/www/flag.txt</code>,<code>/flag.txt</code>) or admin panel.</p>

            <h3 class="subtitle is-4">Flag Submission</h3>
            <p class="mb-6">Once a flag is found, participants should submit it using the form.</p>

            <h3 class="subtitle is-4">Prohibitions</h3>
            <ul>
                <li><strong>Sharing:</strong> Distributing flags with other participants is strictly prohibited unless task is archived.</li>
               
            </ul>
        </div>

        <!-- Communication & Support -->
        <div class="box">
            <h2 class="subtitle is-3">Communication & Support</h2>
            
            <h3 class="subtitle is-4">Community & Questions</h3>
            <p class="mb-6">For questions, discussions, or community engagement, join our <code>#community-security</code> or <code>#community-ctf</code> channel on Slack.</p>

            <h3 class="subtitle is-4">Trainings & Workshops</h3>
            <p class="mb-6">Interested in honing your skills? We offer regular CTF trainings and workshops. Stay updated on our <code>#community-security</code> Slack channel.</p>

            <h3 class="subtitle is-4">Reporting Issues</h3>
            <p class="mb-6">If you come across a task that appears to be malfunctioning or broken, please notify us promptly via the <code>#community-ctf</code> channel on Slack.</p>
        </div>
 </div>
 </section>

                

	  @include('include.footer')