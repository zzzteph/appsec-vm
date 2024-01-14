if (document.getElementById("code") !== null) {
    hljs.highlightAll();
    new Vue({
        el: '#code',
        methods: {
            handleCopy(event) {
                const message = 'Copy action is detected! This is the copied message.';

                event.clipboardData.setData('text/plain', message);
                event.preventDefault();
            },
            handleCut(event) {
                const message = 'Cut action is detected! This is the copied message.';

                event.clipboardData.setData('text/plain', message);
                event.preventDefault();
            }
        }
    });
}
if (document.getElementById("countdown") !== null) {
    new Vue({
        el: "#countdown",
        data: {
            countdown: null,

            interval: null,

        },
        methods: {

            getCountdown: function(event) {
                axios.get('/api/countdown').then((response) => {
                    this.countdown = response.data;

                }).catch(error => {

                    this.countdown = null;

                });

            }

        },


        mounted: function() {
            this.getCountdown();
            var self = this;
            this.interval = setInterval(function() {
                self.getCountdown();
            }, 5000);
        }

    });
}
if (document.getElementById("challenges") !== null) {
    new Vue({
        el: "#challenges",
        data: {
            challenges: null,

            interval: null,

        },
        methods: {

            getChallenges: function(event) {
                axios.get('/api/challenges').then((response) => {
                    this.challenges = response.data;

                }).catch(error => {

                    this.challenges = null;

                });

            },
            showAvailabilityMessage: function(challenge) {
                alert(`This challenge will be available on ${challenge.available_at}`);
            }

        },


        mounted: function() {
            this.getChallenges();
            var self = this;
            this.interval = setInterval(function() {
                self.getChallenges();
            }, 5000);
        }

    });
}

if (document.getElementById("menu") !== null) {
    new Vue({
        el: "#menu",
        data: {
            answers: null,
            to_review: 0,

            interval: null,

        },
        methods: {

            getAnswers: function(event) {
                axios.get('/api/answers').then((response) => {
                    this.answers = response.data;

                }).catch(error => {

                    this.answers = null;

                });

            }

        },
        computed: {
            numberOfToReviewAnswers() {
                if (this.answers !== null)
                    return this.answers.filter(answer => answer.reviewed == false).length;
                return 0;
            },




        },


        mounted: function() {
            this.getAnswers();
            var self = this;
            this.interval = setInterval(function() {
                self.getAnswers();
            }, 5000);
        }

    });
}