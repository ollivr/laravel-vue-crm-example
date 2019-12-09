<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>{{ $t('login')}}</h1></div>
                    </div>
                    <div class="card-body">
                        <form id="login-form">
                            <div class="text-left form-group">
                                <label class="font-weight-bold">{{ $t('email')}}:
                                    <input type="text" name="email" class="form-control" style="max-width: 240px; margin: 0 auto;" v-model="user.email"/>
                                </label>
                            </div>

                            <div class="text-left form-group">
                                <label class="font-weight-bold">{{ $t('password')}}:
                                    <input type="password" name="password" class="form-control" style="max-width: 240px; margin: 0 auto;" v-model="user.password"/>
                                </label>
                            </div>
                            <div>
                                <a id="login-submit-button" href="#" class="btn btn-primary" @click="login($event)">{{ $t('login')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <modals-container />
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    props: {

    },
    data() {
        return {
            user: {
                email: null,
                password: null,
            },
        }
    },
    mounted () {
    },
    methods: {
        login: function(e) {
            e.preventDefault();

            let submitButton = e.target;

            //Check submit action
            if(submitButton.classList.contains('disabled')) {
                return false;
            }

            this.$root.showButtonSpinner(submitButton);

            this.$store.dispatch('login', this.user)
            .then(response => {
                this.$store.dispatch('getCurrentUser')
                    .then(response => {
                        this.$root.hideButtonSpinner(submitButton);
                        this.$router.push('/')
                    })
                    .catch(error => {
                    })
            })
            .catch(error => {

                this.$root.hideButtonSpinner(submitButton);

                console.log(error);

                if(error) {
                    if(error.response) {
                        console.log(error.response.data);

                        let errors;

                        if(error.response.data.errors) {
                            errors = error.response.data.errors;
                        } else {
                            errors = false;
                        }

                        this.$root.showErrorPopup(error.response.data.message, errors, 'login-form');
                    }
                }
            });
        },
    },
}
</script>