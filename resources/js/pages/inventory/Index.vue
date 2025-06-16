<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import PizzaModal from './components/PizzaModal.vue';
import debounce from 'lodash.debounce'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pizza Inventory',
        href: '/inventory',
    },
];

interface PizzaType {
    pizza_type_id: string;
    name: string;
    category: string;
    ingredients: string;
}

interface Pizza {
    id?: number;
    pizza_id: string;
    pizza_type_id: string;
    size: string;
    price: number;
    pizza_type?: PizzaType;
}

const store = useStore();

const pizzas = computed(() => store.state.pizza.pizzas);
const meta = computed(() => store.state.pizza.meta);
const currentPage = computed(() => store.state.pizza.currentPage);
const search = ref('');
const showModal = ref(false);
const selectedPizza = ref<Pizza | null>(null);

const changePage = (page: number) => {
    store.dispatch('pizza/changePage', page);
};

const refreshList = async () => {
    store.dispatch('pizza/fetchPizzas');
    closeModal();
};

const confirmDelete = async (id: number) => {
    if (confirm('Delete this pizza?')) {
        await axios.delete(`/api/pizzas/${id}`);
        store.dispatch('pizza/fetchPizzas');
    }
};

const openAddModal = () => {
    selectedPizza.value = null;
    showModal.value = true;
};

const openEditModal = (pizza: Pizza) => {
    selectedPizza.value = { ...pizza };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const fetchResults = debounce((search: string) => {
    store.dispatch('pizza/updateFilters', { pizza_id: search });
}, 500)

watch(search, async (value: string) => {
    fetchResults(value)
})

onMounted(() => {
    store.dispatch('pizza/fetchPizzas');
});
</script>

<template>

    <Head title="Inventory" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="p-6">
                <div class="flex justify-between mb-4">
                    <input v-model="search" type="text" placeholder="Search pizzas..."
                        class="border px-4 py-2 rounded w-1/3" />
                    <button @click="openAddModal"
                        class="bg-blue-600 hover:bg-blue-700 text-white dark:text-white px-4 py-2 rounded-md shadow-md transition">
                        + Add Pizza
                    </button>
                </div>

                <table class="w-full table-auto text-sm border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="p-2">Pizza ID</th>
                            <th class="p-2">Type</th>
                            <th class="p-2">Size</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Category</th>
                            <th class="p-2">Ingredients</th>
                            <th class="p-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pizza in pizzas" :key="pizza.pizza_id"
                            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="p-2">{{ pizza.pizza_id }}</td>
                            <td class="p-2">{{ pizza.pizza_type?.name }}</td>
                            <td class="p-2">{{ pizza.size }}</td>
                            <td class="p-2">${{ pizza.price }}</td>
                            <td class="p-2">{{ pizza.pizza_type?.category }}</td>
                            <td class="p-2">{{ pizza.pizza_type?.ingredients }}</td>
                            <td class="p-2 text-right">
                                <button @click="openEditModal(pizza)"
                                    class="text-blue-600 dark:text-blue-400 mr-2">Edit</button>
                                <button @click="confirmDelete(pizza.pizza_id)"
                                    class="text-red-600 dark:text-red-400">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class="flex justify-center items-center mt-4 space-x-2">
                    <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                        class="px-3 py-1 rounded-md border bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50">
                        Prev
                    </button>
                    <span class="text-gray-700 dark:text-gray-300">{{ currentPage }} / {{ meta.last_page }}</span>
                    <button @click="changePage(currentPage + 1)" :disabled="currentPage === meta.last_page"
                        class="px-3 py-1 rounded-md border bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50">
                        Next
                    </button>
                </div>


                <!-- Modal -->
                <PizzaModal :isOpen="showModal" :initialData="selectedPizza" @close="showModal = false"
                    @refresh="refreshList" />

            </div>
        </div>
    </AppLayout>
</template>
