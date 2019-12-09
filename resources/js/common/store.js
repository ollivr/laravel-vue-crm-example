import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'
import axios from "axios";

Vue.use(Vuex);

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
        tokens: {
            access_token: null,
            expires_in: null,
            refresh_token: null,
            token_type: null,
        },
        currentUser: {
            id: null,
            name: null,
            email: null,
        },
        usersPaginate: {
            data: Array
        },
        departmentsPaginate: {
            data: Array
        },
    },
    actions: {
        login(context, user) {
            return new Promise((resolve, reject) => {
                let data = {
                    client_id: Laravel.oauth.clientId,
                    client_secret: Laravel.oauth.clientSecret,
                    grant_type: 'password',
                    username: user.email,
                    password: user.password,
                };

                axios.post('/oauth/token', data)
                    .then(response => {
                        let responseData = response.data;
                        let now = Date.now();

                        responseData.expires_in = responseData.expires_in + now;

                        context.commit('UPDATE_TOKENS', responseData);

                        axios.defaults.headers.common['Authorization'] = 'Bearer ' +responseData.access_token;

                        resolve(response)
                    })
                    .catch(response => {
                        reject(response)
                    })
            })
        },
        getCurrentUser(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/user')
                    .then(response => {
                        let responseData = response.data;

                        context.commit('UPDATE_CURRENT_USER', responseData.user);

                        resolve(response)
                    })
                    .catch(response => {
                        reject(response)
                    })
            })
        },
    },
    mutations: {
        UPDATE_TOKENS(state, tokens) {
            state.tokens = tokens
        },
        UPDATE_CURRENT_USER(state, currentUser) {
            state.currentUser = currentUser
        },
        CLEAR_TOKENS(state) {
            state.tokens = {
                access_token: null,
                expires_in: null,
                refresh_token: null,
                token_type: null,
            }
        },
        CLEAR_CURRENT_USER(state) {
            state.currentUser = {
                id: null,
                name: null,
                email: null,
            };
        },
        SET_USERS_PAGINATE: (state, arr) => {
            state.usersPaginate = arr
        },
        SET_DEPARTMENTS_PAGINATE: (state, arr) => {
            state.departmentsPaginate = arr
        },
    },
    getters: {
        getAccessToken(state) {
            return state.tokens.access_token
        },
        getCurrentUser(state) {
            return state.currentUser
        },
    },
});

export default store;