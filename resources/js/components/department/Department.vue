<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>{{ $t('department') }}</h1></div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <div>
                                    <p class="h6 font-weight-bold">
                                        {{ $t('title') }}:
                                    </p>
                                    <p>
                                        {{ department.name }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div>
                                    <p class="h6 font-weight-bold">
                                        {{ $t('description') }}:
                                    </p>
                                    <p>
                                        {{ department.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-light" @click="$router.back(-1)">{{ $t('back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Department',
        props: {

        },
        data() {
            return {
                department: '',
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
                axios.get('/api' + this.$route.path).then(response => {
                    this.department  = response.data.department;
                })
                    .catch(error => {

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

                                this.$root.showErrorPopup(error.response.data.message, errors);
                            }
                        }
                    })
            },
        },
    }
</script>