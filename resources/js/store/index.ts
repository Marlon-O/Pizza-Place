import { createStore } from 'vuex';
import pizza from './modules/pizza';
import pizzaTypes from './modules/pizzaTypes';

export default createStore({
  modules: {
    pizza,
    pizzaTypes
  },
});
