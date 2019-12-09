<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block">
                            <h1 v-if="$route.params.id">{{ $t('editUser') }}</h1>
                            <h1 v-else="$route.params.id">{{ $t('addUser') }}</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="user-form">
                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('name') }}:
                                    <input name="name" class="form-control" v-model="name">
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('email') }}:
                                    <input name="email" class="form-control" v-model="email">
                                </label>
                            </div>

                            <div v-if="$store.state.currentUser.id === $route.params.id" class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('currentPassword') }}
                                    <input class="form-control" type="password" name="current_password" v-model="currentPassword">
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('newPassword') }}:
                                    <input class="form-control" type="password" name="password" v-model="password">
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('passwordConfirmation') }}:
                                    <input class="form-control" type="password" name="password_confirmation" v-model="passwordConfirmation">
                                </label>
                            </div>
                        </form>
                        <a href="#" class="btn btn-danger mr-3" @click="$router.back()">{{ $t('cancel') }}</a>
                        <a href="#" class="btn btn-success" @click="save($event)">{{ $t('save') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'User',
        props: {

        },
        data() {
            return {
                name: '',
                email: '',
                currentPassword: '',
                password: '',
                passwordConfirmation: '',
                user: '',
            }
        },
        mounted() {

        },
        watch: {
            // call again the method if the route changes
            '$route': 'fetchData'
        },
        created () {
            // fetch the data when the view is created and the data is
            // already being observed
            if(this.$route.params.id) {
                this.fetchData();
            }
        },
        methods: {
            fetchData() {
                axios.get('/api/admin/users/' + this.$route.params.id).then(response => {
                    this.name  = response.data.user.name;
                    this.email  = response.data.user.email;
                    this.user  = response.data.user;
                })
                    .catch(error => {

                        if(error) {

                            if(error.response) {

                                console.log(error.response.data);

                                let errors;

                                if(error.response.data.errors) {
                                    errors = error.response.data.errors;
                                } else {
                                    errors = false;
                                }

                                this.$root.showErrorPopup(error.response.data.message, errors, 'user-form');
                            }
                        }
                    })
            },
            save(e) {
                e.preventDefault();

                let submitButton = e.target;

                //Check submit action
                if(submitButton.classList.contains('disabled')) {
                    return false;
                }

                this.$root.showButtonSpinner(submitButton);

                console.log('Save user');

                let pageUrl;
                if(this.$route.params.id) {
                    pageUrl = '/api/admin/users/' + this.user.id;
                } else {
                    pageUrl = '/api/admin/users';
                }
                axios.post(pageUrl, {
                    _method: this.$route.params.id ? 'put': 'post',
                    name: this.name,
                    email: this.email,
                    current_password: this.currentPassword,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation
                }).then(response => {
                    this.$router.back();
                })
                    .catch(error => {

                        this.$root.hideButtonSpinner(submitButton);

                        if(error) {

                            if(error.response) {

                                console.log(error.response.data);

                                let errors;

                                if(error.response.data.errors) {
                                    errors = error.response.data.errors;
                                } else {
                                    errors = false;
                                }

                                this.$root.showErrorPopup(error.response.data.message, errors, 'user-form');
                            }
                        }
                    })
            },
        },
    }
</script>