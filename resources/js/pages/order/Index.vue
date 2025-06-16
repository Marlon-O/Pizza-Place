<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, computed } from 'vue'
import { useStore } from 'vuex'
import OrderModal from './components/OrderModal.vue'
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: '/orders',
    },
];

const store = useStore()
const showModal = ref(false)
const selectedOrder = ref(null)

const orders = computed(() => store.state.order.orders)
const meta = computed(() => store.state.order.meta);
const currentPage = computed(() => store.state.order.currentPage);
const sortKey = computed(() => store.state.order.sort)

const changePage = (page: number) => {
    store.dispatch('order/changePage', page);
};

const openModal = (order = null) => {
  selectedOrder.value = order
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedOrder.value = null
}

const deleteOrder = (id: number) => {
  if (confirm('Are you sure you want to delete this order?')) {
    store.dispatch('order/deleteOrder', id)
  }
}

const toggleSort = (field: string) => {
  if (sortKey.value === field) {
    store.dispatch('order/changeSort', `-${field}`) // descending
  } else {
    store.dispatch('order/changeSort', field) // ascending
  }
}

onMounted(() => store.dispatch('order/fetchOrders'))
</script>

<template>
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold dark:text-white">Orders</h2>
                <button
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click="openModal()"
                >
                    + Add Order
                </button>
                </div>

                <table class="w-full table-auto text-sm border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                    <th
                        class="cursor-pointer p-2text-left text-sm font-medium text-gray-500 dark:text-gray-300"
                        @click="toggleSort('order_id')"
                        >
                        Order ID
                        <span v-if="sortKey === 'order_id'">▲</span>
                        <span v-if="sortKey === '-order_id'">▼</span>
                        </th>
                                            <th
                        class="cursor-pointer p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300"
                        @click="toggleSort('date')"
                        >
                        Date
                        <span v-if="sortKey === 'date'">▲</span>
                        <span v-if="sortKey === '-date'">▼</span>
                        </th>
                    <th class="p-2">Time</th>
                    <th class="p-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                    v-for="order in orders"
                    :key="order.order_id"
                    class="border-b dark:border-gray-700"
                    >
                    <td class="p-2 text-blue-500 cursor-pointer hover:underline">
                        <Link :href="route('orders.show', order.order_id)">
                            {{ order.order_id }}
                        </Link>
                    </td>
                    <td class="p-2">{{ order.date }}</td>
                    <td class="p-2">{{ order.time }}</td>
                    <td class="p-2 text-right">
                        <button class="text-blue-600 dark:text-blue-400 mr-2" @click="openModal(order)">Edit</button>
                        <button class="text-red-600 dark:text-red-400" @click="deleteOrder(order.order_id)">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>

                <!-- Pagination -->
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

                <!-- Order Modal -->
                <OrderModal v-if="showModal" :order="selectedOrder" @close="closeModal" />
            </div>
        </div>
    </AppLayout>
</template>
