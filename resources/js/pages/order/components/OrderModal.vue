<template>
  <div class="fixed inset-0 bg-black/50 bg-opacity-40 flex justify-center items-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4 dark:text-white">
        {{ order?.order_id ? 'Edit Order' : 'Create Order' }}
      </h2>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-sm dark:text-white">Date</label>
          <input v-model="form.date" type="date" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" step="1" required />
        </div>
        
        <div class="mb-4">
          <label class="block text-sm dark:text-white">Time</label>
          <input v-model="form.time" type="time" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" step="1" required />
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" @click="$emit('close')" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
            {{ order?.order_id ? 'Update' : 'Create' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useStore } from 'vuex'

const props = defineProps<{ order?: any }>()
const emit = defineEmits(['close'])

const store = useStore()
const form = ref({
  date: '',
  time: ''
})

watch(
  () => props.order,
  (newVal) => {
    form.value = newVal
      ? { date: newVal.date, time: newVal.time }
      : { date: '', time: '' }
  },
  { immediate: true }
)

const submit = async () => {
  if (props.order?.order_id) {
    await store.dispatch('order/updateOrder', { order_id: props.order.order_id, payload: form.value })
  } else {
    await store.dispatch('order/createOrder', form.value)
  }
  emit('close')
}
</script>
