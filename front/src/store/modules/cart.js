/**
 * [cart module]
 * cart store the items and quantity in localstorage
 */

import  {MangasBroker} from '@/js/MangasBroker.js';

const state = {
    items: JSON.parse(localStorage.getItem("cart")) || {},
    price: 0,
    nbItems: 0
};

const mutations = {
    addCart : (state, item) => {
        if( state.items[item.id]  != null){
              state.items[item.id].quantity += item.quantity;
        } else {
            state.items[item.id] = item;
        }
    },
    totalPrice: (state, price) => {
        state.price = price
    },
    nbItems: (state, nbItems) => {
        state.nbItems = nbItems
    }
};

const actions = {
    addCart({ commit, dispatch }, item){
        commit('addCart', item);
        let jsonData = JSON.stringify(state.items);
        window.localStorage.setItem('cart', jsonData);
        dispatch('getTotalPrice');
    },
    async getTotalPrice({ commit }) {
        let items = JSON.parse(localStorage.getItem("cart")) || {};
        let mangas = new MangasBroker();
        if(items){
            let url="?id=";
            url+=Object.keys(items).join('&id=');
            let response = await mangas.getAll(url)
            let totalPrice = 0;
            let nbItems = 0;
            for(let manga of Object.values(response.data)) {
                totalPrice+=parseFloat(manga.price)*items[manga.id].quantity;
                nbItems+=items[manga.id].quantity
            }
            commit('totalPrice',totalPrice.toFixed(2));
            commit('nbItems',nbItems);
        }
    }

};

const getters = {
    items : state => state.items,
    cartPrice:  state => state.price,
    cartNbItems: state => state.nbItems
};


export default {
    state,
    getters,
    actions,
    mutations
};
