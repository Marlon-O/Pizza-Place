<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import api from '@/plugins/axios'

defineProps<{ order: any }>()

const goBack = () => {
  router.get('/orders')
}

const page = usePage()
const order = page.props.order as any
const pizzas = page.props.pizzas as any[]

const showAddDetailModal = ref(false)

const newDetail = ref({
  pizza_id: '',
  quantity: 1,
})

const addOrderDetail = async () => {
  try {
    await api.post(`/orders/${order.data.order_id}/details`, newDetail.value)
    location.reload() // or refetch the page via Inertia
  } catch (error) {
    console.error(error)
    // show toast or validation error
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto mt-10">
    <!-- Back Button -->
    <button
      @click="goBack"
      class="mb-4 inline-flex items-center text-sm font-medium text-blue-600 hover:underline dark:text-blue-400"
    >
      ← Back to Orders
    </button>

    <div class="p-6 bg-white dark:bg-gray-900 shadow rounded-xl">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
        Order #{{ order.data.order_id }}
      </h1>

      <p class="text-gray-700 dark:text-gray-300">Date: {{ order.data.date }}</p>
      <p class="text-gray-700 dark:text-gray-300">Time: {{ order.data.time }}</p>

      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
          Order Details
        </h2>

        <button
          @click="showAddDetailModal = true"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          + Add Order Detail
        </button>
      </div>


      <table class="w-full mt-3 text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
          <tr>
            <th class="px-4 py-2">Pizza</th>
            <th class="px-4 py-2">Size</th>
            <th class="px-4 py-2">Price</th>
            <th class="px-4 py-2">Quantity</th>
            <th class="px-4 py-2">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="detail in order.data.details"
            :key="detail.order_details_id"
            class="bg-white dark:bg-gray-800 border-b dark:border-gray-700"
          >
            <td class="px-4 py-2">{{ detail.pizza.pizza_type.name }}</td>
            <td class="px-4 py-2">{{ detail.pizza.size }}</td>
            <td class="px-4 py-2">
              {{ detail.pizza.price }}
            </td>
            <td class="px-4 py-2">{{ detail.quantity }}</td>
            <td class="px-4 py-2">
              {{ (detail.quantity * detail.pizza.price).toFixed(2) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" v-if="showAddDetailModal">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Add Order Detail</h2>

      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Pizza</label>
        <select
          v-model="newDetail.pizza_id"
          class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
        >
          <option disabled value="">Select Pizza</option>
          <option v-for="pizza in pizzas.data" :key="pizza.pizza_id" :value="pizza.pizza_id">
            {{ pizza.pizza_type.name }} - {{ pizza.size }}
          </option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
        <input
          v-model.number="newDetail.quantity"
          type="number"
          class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
          min="1"
        />
      </div>

      <div class="flex justify-end space-x-2">
        <button @click="showAddDetailModal = false" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
        <button @click="addOrderDetail" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add</button>
      </div>
    </div>
  </div>
</template>
