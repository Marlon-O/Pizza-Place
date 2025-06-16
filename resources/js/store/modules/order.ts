import api from '@/plugins/axios';
import { Module } from 'vuex';

interface Order {
    order_id: number;
    date: string;
    time: string;
}

interface Filters {
    date?: string;
    time?: string;
}

interface OrderState {
    orders: Order[];
    meta: any;
    currentPage: number;
    filters: Filters;
    sort: string; // e.g., 'date' or '-date' (descending)
}

const orders: Module<OrderState, any> = {
    namespaced: true,

    state: () => ({
        orders: [],
        meta: {},
        currentPage: 1,
        filters: {},
        sort: 'date',
    }),

    mutations: {
        setOrders(state, { data, meta }) {
            state.orders = data;
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
        setSort(state, sort: string) {
            state.sort = sort;
            state.currentPage = 1;
        },
    },

    actions: {
        async fetchOrders({ commit, state }) {
            const query = new URLSearchParams();
            query.append('page', state.currentPage.toString());

            if (state.sort) {
                query.append('sort', state.sort); // Spatie supports this
            }

            for (const [key, value] of Object.entries(state.filters)) {
                if (value) query.append(`filter[${key}]`, value);
            }

            const res = await api.get(`/orders?${query.toString()}`);
            commit('setOrders', { data: res.data.data, meta: res.data.meta });
        },

        async updateOrder({ dispatch }, { order_id, payload }) {
            await api.put(`/orders/${order_id}`, payload);
            dispatch('fetchOrders');
        },

        async deleteOrder({ dispatch }, order_id: number) {
            await api.delete(`/orders/${order_id}`);
            dispatch('fetchOrders');
        },

        async createOrder(_, payload) {
            await api.post('/orders', payload);
        },

        changePage({ commit, dispatch }, page: number) {
            commit('setCurrentPage', page);
            dispatch('fetchOrders');
        },

        updateFilters({ commit, dispatch }, filters: Filters) {
            commit('setFilters', filters);
            dispatch('fetchOrders');
        },

        resetFilters({ commit, dispatch }) {
            commit('clearFilters');
            dispatch('fetchOrders');
        },

        changeSort({ commit, dispatch }, sort: string) {
            commit('setSort', sort);
            dispatch('fetchOrders');
        },
    },
};

export default orders;
