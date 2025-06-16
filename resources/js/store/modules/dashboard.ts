import { Module } from 'vuex';
import api from '@/plugins/axios';

interface DashboardStats {
  total_pizzas: number;
  total_orders: number;
  total_revenue: number;
}

interface DashboardState {
  stats: DashboardStats;
}

const dashboard: Module<DashboardState, any> = {
  namespaced: true,

  state: () => ({
    stats: {
      total_pizzas: 0,
      total_orders: 0,
      total_revenue: 0,
    },
  }),

  mutations: {
    setStats(state, stats: DashboardStats) {
      state.stats = stats;
    },
  },

  actions: {
    async fetchStats({ commit }) {
      const res = await api.get('/dashboard/stats');
      commit('setStats', res.data);
    },
  },
};

export default dashboard;
