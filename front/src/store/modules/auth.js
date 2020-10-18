
// import { USER_REQUEST } from "../actions/user";
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
    authRequest({ commit }, user){
        commit('authRequest');
        let usersBroker = new UsersBroker();
        return new Promise((resolve, reject) => {
            Promise.resolve(usersBroker.login(user))
            .then( (response) => {
                commit('authSuccess',response.data);
                console.log(response.data);
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
    authLogout({ commit }){
          return new Promise(resolve => {
              commit('authLogout');
              Cookie.eraseCookie('user-token');
              Cookie.eraseCookie('role');
              resolve();
          });
    },
    isAdmin({commit}){
        return new Promise(resolve => {
            commit('authCheck');
            resolve();
        })
    }
};
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
