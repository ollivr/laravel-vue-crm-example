<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>{{ $t('departments') }}</h1></div>
                        <div class="d-inline-block pull-right float-right text-right">
                            <router-link class="btn btn-primary" :to="{ name: 'department-add' }">{{ $t('add') }}</router-link>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table table-striped" v-if="$store.state.departmentsPaginate.data">
                            <div>
                                <div class="row mr-0 ml-0 pt-3 pb-2" v-for="department in $store.state.departmentsPaginate.data" :key="department.id">
                                    <div class="col-12 col-md-3">
                                        <router-link :to="{ name: 'department-view', params: {id: department.id }}">
                                            <img class="w-100" :src="$root.getImageUrl(department.logo, 'storage/logo')" alt=""/>
                                        </router-link>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <router-link :to="{ name: 'department-view', params: {id: department.id }}">{{ department.name }}</router-link>
                                        <p>{{ department.description }}</p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div v-if="department.users">
                                            <b>{{ $t('users') }}:</b>
                                            <div v-for="user in department.users">
                                                <router-link :to="{ name: 'user-view', params: {id: user.id }}">{{ user.name }}</router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1">
                                        <router-link :to="{ name: 'department-edit', params: {id: department.id }}" class="btn btn-success"><i class="fa fa-pencil"></i></router-link>
                                    </div>
                                    <div class="col-6 col-md-1">
                                        <a href="#" class="btn btn-danger" @click="showDeleteModal($event, department.id)"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-3" v-if="$store.state.departmentsPaginate.data">
                            <pagination :data="$store.state.departmentsPaginate" @pagination-change-page="getResults"></pagination>
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
import DeleteDepartmentModal from './DeleteDepartmentModal';

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
    methods: {
        getResults(page = 1) {
            let pageUrl = '/api/admin/departments?page=' + page;
            axios.get(pageUrl).then(response => {
                this.$store.commit('SET_DEPARTMENTS_PAGINATE', response.data.departments);
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
        showDeleteModal(e, id) {
            e.preventDefault();

            this.$modal.show(DeleteDepartmentModal, {
                    name: "delete-department-modal",
                    class: "vue-dialog",
                    id: id
                },
                {
                    width: 360,
                    height: 'auto',
                }
            );
            return false;
        },
    },
}
</script>