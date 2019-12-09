<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>User</h1></div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <div>
                                    <p class="h6 font-weight-bold">
                                        Name:
                                    </p>
                                    <p>
                                        {{ user.name }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div>
                                    <p class="h6 font-weight-bold">
                                        Email:
                                    </p>
                                    <p>
                                        {{ user.email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-light" @click="$router.back(-1)">Back</a>
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
            'id': ''
        },
        data() {
            return {
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
            this.fetchData()
        },
        methods: {
            fetchData() {
                axios.get('/api/admin/users/' + this.$route.params.id).then(response => {
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

                                this.$root.showErrorPopup(error.response.data.message, errors, 'terms_2');
                            }
                        }
                    })
            },
        },
    }
</script>