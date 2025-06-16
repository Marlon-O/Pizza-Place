import api from '@/plugins/axios';

const pizzaTypes  = {
  namespaced: true,
  state: () => ({
    items: [],
  }),
  mutations: {
    setPizzaTypes(state, types) {
      state.items = types;
    },
  },
  actions: {
    async fetchPizzaTypes({ commit }) {
      const res = await api.get('/pizza-types');
      commit('setPizzaTypes', res.data.data);
    },
  },
};

export default pizzaTypes
