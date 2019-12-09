/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
/**
 * Import
 */
import store from './common/store';
import router from './common/router';
import i18n from './common/i18n';
import axios from 'axios';

let access_token = store.getters.getAccessToken;

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

import VModal from 'vue-js-modal';
Vue.use(VModal, { dynamic: true, dialog: true });
import MainBlock from './components/Main';

if (access_token)
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + access_token;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    store,
    i18n,
    router,
    components: {
        MainBlock,
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
        logout() {
            this.$store.commit('CLEAR_TOKENS');
            this.$store.commit('CLEAR_CURRENT_USER');
            this.$router.push({name:'welcome'});
        },
        showButtonSpinner(button) {
            button.setAttribute('disabled', 'disabled');
            button.classList.add('disabled');
            let html = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>' + html;
        },

        hideButtonSpinner(button) {
            button.removeAttribute('disabled');
            button.classList.remove('disabled');

            let submitButtonSpinner;

            for (let i = 0; i < button.childNodes.length; i++) {
                if (button.childNodes[i].classList.contains('spinner-border')) {
                    submitButtonSpinner = button.childNodes[i];
                    break;
                }
            }

            submitButtonSpinner.remove();
        },
        showErrorPopup(message, errors = false, formName = '') {

            let text = '';

            console.log(errors);

            if(errors) {
                this.$root.removeHelpBlocks();

                for(let responseError in errors) {
                    //text += errors[responseError] + '<br/>';
                    for(let i in errors[responseError]) {

                        let errorSpan = '<span class="help-block text-danger">'+errors[responseError][i]+'<br/></span>';

                        //Find field
                        let el;
                        el = $('#' + formName + ' input[name=' + responseError + ']');
                        if(el.length > 0) {
                            el.after(errorSpan);
                        }
                        el = $('#' + formName + ' select[name=' + responseError + ']');
                        if(el.length > 0) {
                            el.after(errorSpan);
                        }
                        el = $('#' + formName + ' textarea[name=' + responseError + ']');
                        if(el.length > 0) {
                            el.after(errorSpan);
                        }
                    }
                }
            } else {
                text = message;

                this.$modal.show({
                        template: `
                    <div class="vue-dialog">
                        <div class="dialog-header p-2 pl-3 pr-2">
                            <div class="dialog-close-button pull-right">
                                <a href="#" @click="$emit('close')" class="text-18 text-red">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </div>
                            <div class="dialog-c-title">` + this.$t('error') + `</div>
                        </div>

                        <div class="dialog-content">
                            <div class="dialog-c-text">
                                <p><span v-html="text"></span></p>
                            </div>
                        </div>
                        <div class="vue-dialog-buttons"><button type="button" class="btn btn-red btn-rounded btn-slim" style="flex: 1 1 100%;" @click="$emit('close')">` + this.$t('close') + `</button></div>
                    </div>
                `,
                        props: ['text']
                    },
                    {
                        text: text
                    },
                    {
                        width: 300,
                        height: 'auto'
                    }, {
                        'before-close': (event) => { console.log('this will be called before the modal closes'); }
                    });

            }
        },
        removeHelpBlocks() {
            let helpBlocks = Array.prototype.slice.call(document.querySelectorAll('.help-block'));

            helpBlocks.forEach(function(helpBlock) {
                helpBlock.parentNode.removeChild(helpBlock);
            });
        },
        getImageUrl(filename, folder) {
            return '/' + folder + '/' + filename;
        }
    }
});
