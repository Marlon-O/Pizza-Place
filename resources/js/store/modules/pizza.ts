import { Module } from 'vuex';
import api from '@/plugins/axios';

interface Pizza {
  pizza_id: string;
  size: string;
  price: number;
  pizza_type: {
    pizza_type_id: string;
    name: string;
    category: string;
  };
}

interface Filters {
  pizza_id?: string;
  pizza_type_id?: string;
  size?: string;
  name?: string;
  category?: string;
}

interface PizzaState {
  pizzas: Pizza[];
  meta: any;
  currentPage: number;
  filters: Filters;
}

const pizzas: Module<PizzaState, any> = {
  namespaced: true,

  state: () => ({
    pizzas: [],
    meta: {},
    currentPage: 1,
    filters: {},
  }),

  mutations: {
    setPizzas(state, { data, meta }) {
      state.pizzas = data;
      state.meta = meta;
    },
    setCurrentPage(state, page: number) {
      state.currentPage = page;
    },
    setFilters(state, filters: Filters) {
      state.filters = { ...state.filters, ...filters };
      state.currentPage = 1;
    },
    clearFilters(state) {
      state.filters = {};
      state.currentPage = 1;
    },
  },

  actions: {
    async fetchPizzas({ commit, state }) {
      const query = new URLSearchParams();
      query.append('page', state.currentPage.toString());

      for (const [key, value] of Object.entries(state.filters)) {
        if (value) query.append(`filter[${key}]`, value);
      }

      const res = await api.get(`/pizzas?${query.toString()}`);
      commit('setPizzas', { data: res.data.data, meta: res.data.meta });
    },

    async updatePizza(_, { pizza_id, payload }) {
      await api.put(`/pizzas/${pizza_id}`, payload);
    },

    async deletePizza(_, pizza_id: string) {
      await api.delete(`/pizzas/${pizza_id}`);
    },

    async createPizza(_, payload) {
      await api.post('/pizzas', payload);
    },

    changePage({ commit, dispatch }, page: number) {
      commit('setCurrentPage', page);
      dispatch('fetchPizzas');
    },

    updateFilters({ commit, dispatch }, filters: Filters) {
      commit('setFilters', filters);
      dispatch('fetchPizzas');
    },

    resetFilters({ commit, dispatch }) {
      commit('clearFilters');
      dispatch('fetchPizzas');
    },
  },
};

export default pizzas