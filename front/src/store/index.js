import { createStore } from 'vuex'
// import  {UsersBroker} from '@/js/UsersBroker.js';

import auth from "./modules/auth.js";
import cart from "./modules/cart.js";

export default createStore({
  state: {

  },
  mutations: {
  },
  actions: {

  },
  modules: {
      auth,
      cart
  }
})
