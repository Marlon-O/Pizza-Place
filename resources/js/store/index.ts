import { createStore } from 'vuex';
import pizza from './modules/pizza';
import pizzaTypes from './modules/pizzaTypes';
import order from './modules/order';

export default createStore({
  modules: {
    pizza,
    pizzaTypes,
    order
  },
});
