<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block"><h1>{{ $t('addDepartment') }}</h1></div>
                    </div>
                    <div class="card-body">
                        <form id="add-department-form">
                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('picture') }}:
                                    <div class="">
                                        <div class="">
                                            <div class="position-relative" v-if="logo">
                                                <a class="" href="#">
                                                    <img :src="$root.getImageUrl(logo, 'storage/logo')" width="200" alt=""/>
                                                </a>
                                                <a href="#" class="position-absolute font-weight-bold" @click="showLogoUploader($event)" style="right: 9px; top: 7px; font-size: 24px; color: #000;"><i class="fa fa-pencil-square"></i></a>
                                            </div>
                                            <div class="position-relative" v-else>
                                                <a class="" href="#" @click="showLogoUploader($event)">
                                                    <span class="d-block font-weight-bold text-black-50" style="font-size: 150px;"><i class="fa fa-picture-o"></i></span>
                                                </a>
                                                <a href="#" class="position-absolute font-weight-bold" @click="showLogoUploader($event)" style="right: 9px; top: 7px; font-size: 24px; color: #000;"><i class="fa fa-pencil-square"></i></a>
                                            </div>
                                            <input type="hidden" name="logo"/>
                                        </div>
                                    </div>
                                    <image-upload-crop id="logo-image-uploader" field="image"
                                                       @crop-success="cropLogoSuccess"
                                                       @crop-upload-success="uploadLogoSuccess"
                                                       @crop-upload-fail="uploadLogoFail"
                                                       v-model="logoImageCrop.show"
                                                       url="/admin/upload/images?entity=App\Models\Department"
                                                       :headers="logoImageCrop.headers"
                                                       img-format="png"
                                                       :noCircle="true"
                                                       langType="en"
                                    ></image-upload-crop>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('title') }}:
                                    <input name="name" class="form-control" v-model="name">
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('description') }}:
                                    <textarea name="description" class="form-control" v-model="description" rows="5"></textarea>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="h6 font-weight-bold">{{ $t('users') }}:
                                    <multiselect v-model="usersIds" name="users" :options="usersList" label="name" :multiple="true" :preserve-search="true" placeholder="Select users" :close-on-select="false" track-by="id"></multiselect>
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
import ImageUploadCrop from 'vue-image-crop-upload';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';

export default {
    name: 'DepartmentAdd',
    props: {

    },
    components: {
        ImageUploadCrop,
        Multiselect
    },
    data() {
        return {
            logo: '',
            name: '',
            description: '',
            usersIds: [],
            usersList: Array,
            department: '',
            ratio: '',
            logoImageCrop: {
                show: false,
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },
            },
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            let pageUrl = '/api/admin/users';
            axios.get(pageUrl).then(response => {
                let usersList = [];
                for(let user in response.data.users) {
                    usersList[response.data.users[user].id] = {
                        id: response.data.users[user].id,
                        name: response.data.users[user].name,
                    };
                }
                this.usersList = usersList;
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
        save(e) {
            e.preventDefault();

            let submitButton = e.target;

            //Check submit action
            if(submitButton.classList.contains('disabled')) {
                return false;
            }

            this.$root.showButtonSpinner(submitButton);

            console.log('Save department');

            let pageUrl = '/api/admin/departments';
            axios.post(pageUrl, {
                name: this.name,
                logo: this.logo,
                description: this.description,
                users: this.usersIds
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

                            this.$root.showErrorPopup(error.response.data.message, errors, 'add-department-form');
                        }
                    }
                })
        },
        // Logo Uploader
        showLogoUploader(e) {
            e.preventDefault();
            this.logoImageCrop.show = true;
        },
        cropLogoSuccess(imgDataUrl, field){
            console.log('-------- crop success --------');
        },
        /**
         * upload success
         *
         * [param] jsonData  server api return data, already json encode
         * [param] field
         */
        uploadLogoSuccess(jsonData, field){
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);

            if(jsonData.filename) {
                this.logo = jsonData.filename;
            }

            //this.imageCrop.show = !this.imageCrop.show;
            let buttonClicks = document.getElementsByClassName('vicp-close');

            for(let i = 0; i < buttonClicks.length; i++){
                buttonClicks[i].click();
            }
        },
        /**
         * upload fail
         *
         * [param] status    server api return error status, like 500
         * [param] field
         */
        uploadLogoFail(status, field){
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        },
    },
}
</script>