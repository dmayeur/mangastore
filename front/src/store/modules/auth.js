/**
 * [auth module for the store]
 * handles everything for the authentication
 */

import {Cookie} from '@/js/Cookie.js';
import  {UsersBroker} from '@/js/UsersBroker.js';

const state = {
    token: Cookie.getCookie('user-token') || '',
    status: "",
    role: Cookie.getCookie('role') || ''
};

const mutations = {
    authRequest: state => {
        state.status = "loading";
    },
    authSuccess: (state, response) => {
        state.status = "success";
        state.token = response.token;
        state.role = response.role;
    },
    authError: state => {
        state.status = "error";
    },
    authLogout: state => {
        state.token = "";
    }
};

const actions = {
    /**
     * [authRequest log in function, set cookies in case of success]
     * @param  {[object]} user   [containing login and password info]
     * @return {[promise]}
     */
    authRequest({ commit }, user){
        commit('authRequest');
        let usersBroker = new UsersBroker();
        return new Promise((resolve, reject) => {
            Promise.resolve(usersBroker.login(user))
            .then( (response) => {
                commit('authSuccess',response.data);
                Cookie.setCookie('user-token',response.data.token,1);
                Cookie.setCookie('role',response.data.role,1);
                resolve(response);
            })
            .catch ((e) => {
                commit('authError');
                Cookie.eraseCookie('user-token');
                Cookie.eraseCookie('role');
                reject(e);
            });
        });
    },
    /**
     * [authLogout logout function which delete the cookies in case of log out]
     * @return {[promise]}
     */
    authLogout({ commit }){
          return new Promise(resolve => {
              commit('authLogout');
              Cookie.eraseCookie('user-token');
              Cookie.eraseCookie('role');
              resolve();
          });
    },
    isAdmin(){
        let token = Cookie.getCookie('user-token');
        let usersBroker = new UsersBroker();
        return new Promise((resolve, reject) => {
            Promise.resolve(usersBroker.isAdmin({token: token}))
            .then( (response) => {
                resolve(response);
            })
            .catch ((e) => {
                reject(e);
            });
        })
    },
    /**
     * [getUser get the user from the server using the user-token cookie]
     * @return {[promise]}
     */
    getUser() {
        let token = Cookie.getCookie('user-token');
        let usersBroker = new UsersBroker();
        return new Promise((resolve, reject) => {
            Promise.resolve(usersBroker.get(token))
            .then( (response) => {
                resolve(response);
            })
            .catch ((e) => {
                reject(e);
            });
        });
    }
};

//getters for easier use throughout the app
const getters = {
    isAuthenticated: state => !!state.token,
    authStatus: state => state.status,
    token: state => state.token,
    isAdmin: state => state.role == "admin"
};


export default {
    state,
    getters,
    actions,
    mutations
};
