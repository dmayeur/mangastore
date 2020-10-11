/**
 * [cart module]
 * cart store the items and quantity in localstorage
 */

const state = {
    items: JSON.parse(localStorage.getItem("cart")) || {}
};

const mutations = {
    addCart : (state, item) => {
        if( state.items[item.id]  != null){
              state.items[item.id].quantity += item.quantity;
        } else {
            state.items[item.id] = item;
        }
    }
};

const actions = {
    addCart({ commit }, item){
        commit('addCart', item);
        let jsonData = JSON.stringify(state.items);
        window.localStorage.setItem('cart', jsonData);
    }
};

const getters = {
    items : state => state.items
};


export default {
    state,
    getters,
    actions,
    mutations
};
