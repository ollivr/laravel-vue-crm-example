<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>{{ $t('users') }}</h1></div>
                        <div class="d-inline-block pull-right float-right text-right">
                            <router-link class="btn btn-primary" :to="{ name: 'user-add' }">{{ $t('add') }}</router-link>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table table-striped" v-if="$store.state.usersPaginate.data">
                            <div>
                                <div class="row mr-0 ml-0 pt-3 pb-2" v-for="user in $store.state.usersPaginate.data" :key="user.id">
                                    <div class="col-12 col-md-3">
                                        <router-link :to="{ name: 'user-view', params: {id: user.id }}">{{ user.name }}</router-link>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        {{ user.email }}
                                    </div>
                                    <div class="col-12 col-md-2">
                                        {{ user.created_at }}
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <router-link :to="{ name: 'user-edit', params: {id: user.id }}" class="btn btn-success"><i class="fa fa-pencil"></i></router-link>
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <a href="#" class="btn btn-danger" @click="showDeleteModal($event, user.id)"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-3" v-if="$store.state.usersPaginate.data">
                            <pagination :data="$store.state.usersPaginate" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <v-dialog/>

        <modals-container />
    </div>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import DeleteUserModal from './DeleteUserModal';

Vue.component('pagination', require('laravel-vue-pagination'));

export default {
    name: 'Users',
    props: {

    },
    data() {
        return {

        }
    },
    mounted() {
        setTimeout(() => {
            this.getResults();
        }, 0);
    },
    watch: {
        '$route':{
            handler: (to, from) => {
                document.title = to.meta.title || 'Your Website'
            },
            immediate: true
        }
    },
    methods: {
        getResults(page = 1) {
            let pageUrl = '/api/admin/users/paginate?page=' + page;
            axios.get(pageUrl).then(response => {
                this.$store.commit('SET_USERS_PAGINATE', response.data.paginator);
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

                            this.$root.showErrorPopup(error.response.data.message, errors);
                        }
                    }
                })
        },
        showDeleteModal(e, id) {
            e.preventDefault();

            this.$modal.show(DeleteUserModal, {
                    name: "delete-user-modal",
                    class: "vue-dialog",
                    id: id
                },
                {
                    width: 360,
                    height: 'auto',
                }
            );
            return false;
        }
    },
}
</script>