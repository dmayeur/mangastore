/**
 * [cart module]
 * cart store the items and quantity in localstorage, price is checked only through API calls
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
        state.price = price;
    },
    nbItems: (state, nbItems) => {
        state.nbItems = nbItems;
    },
    changeQuantity: (state, item) => {
        state.items[item.id].quantity = parseInt(item.quantity);
    },
    deleteItem:  (state, item) => {
        delete state.items[item.id];
    },
    deleteAllItems: (state) => {
        state.items = {};
    }
};

const actions = {
    addCart({ commit, dispatch }, item ) {
        commit('addCart', item);
        let jsonData = JSON.stringify(state.items);
        window.localStorage.setItem('cart', jsonData);
        dispatch('getTotalPrice');
    },
    async getTotalPrice({ commit }) {
        let mangas = new MangasBroker();

        let totalPrice = 0;
        let nbItems = 0;

        //if the cart isn't empty
        if(Object.keys(state.items).length){

            //building the url with all the ids
            let url="?id=";
            url+=Object.keys(state.items).join('&id=');
            let response = await mangas.getAll(url);

            //calculating the price
            for(let manga of Object.values(response.data)) {
                totalPrice+=parseFloat(manga.price)*state.items[manga.id].quantity;
                nbItems+=state.items[manga.id].quantity;
            }

        }

        //updating the price
        commit('totalPrice',totalPrice.toFixed(2));
        commit('nbItems',nbItems);
    },
    changeQuantity({ commit, dispatch }, item) {
        if(item.quantity <= 0) {
            commit('deleteItem', item);
        } else {
            commit('changeQuantity', item);
        }

        let jsonData = JSON.stringify(state.items);
        window.localStorage.setItem('cart', jsonData);
        dispatch('getTotalPrice');
    },
    deleteAllItems({commit, dispatch}) {
        commit('deleteAllItems');
        window.localStorage.removeItem('cart');
        dispatch('getTotalPrice');
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
