<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 bg-opacity-90" @click="closeModal"></div>

    <!-- Modal -->
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-lg p-6 z-50">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
        {{ isEdit ? 'Edit Pizza' : 'Add Pizza' }}
      </h2>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Pizza ID</label>
          <input v-model="form.pizza_id" :disabled="isEdit"
            class="w-full px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Pizza Type</label>
          <select v-model="form.pizza_type_id"
            class="w-full px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option disabled value="">Select Pizza Type</option>
            <option v-for="type in pizzaTypes" :key="type.pizza_type_id" :value="type.pizza_type_id">
              {{ type.name }} ({{ type.pizza_type_id }})
            </option>
          </select>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Size</label>
          <select v-model="form.size"
            class="w-full px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="S">Small</option>
            <option value="M">Medium</option>
            <option value="L">Large</option>
          </select>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Price</label>
          <input v-model.number="form.price" type="number" step="0.01"
            class="w-full px-4 py-2 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
        </div>

        <div class="flex justify-end space-x-2 mt-4">
          <button type="button" @click="closeModal"
            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ isEdit ? 'Update'
            : 'Create' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { computed, reactive, watch, onMounted } from 'vue';
import { useStore } from 'vuex';

interface Props {
  isOpen: boolean;
  initialData?: any;
}
const props = defineProps<Props>();
const emit = defineEmits(['close', 'refresh']);

const store = useStore();

const isEdit = computed(() => !!props.initialData);

const pizzaTypes = computed(() => store.state.pizzaTypes.items || []);

const form = reactive({
  pizza_id: '',
  pizza_type_id: '',
  size: 'M',
  price: 0,
});

// Fill form if editing
watch(
  () => props.initialData,
  (newData) => {
    if (newData) {
      Object.assign(form, {
        pizza_id: newData.pizza_id,
        pizza_type_id: newData.pizza_type_id,
        size: newData.size,
        price: newData.price,
      });
    } else {
      Object.assign(form, {
        pizza_id: '',
        pizza_type_id: '',
        size: 'M',
        price: 0,
      });
    }
  },
  { immediate: true }
);

const handleSubmit = async () => {
  try {
    if (isEdit.value) {
      await store.dispatch('pizza/updatePizza', {
        pizza_id: form.pizza_id,
        payload: { ...form },
      });
    } else {
      await store.dispatch('pizza/createPizza', { ...form });
    }
    emit('refresh');
    closeModal();
  } catch (error) {
    console.error('Submission failed', error);
  }
};

const closeModal = () => {
  emit('close');
};

onMounted(() => {
  if (!pizzaTypes.value.length) {
    store.dispatch('pizzaTypes/fetchPizzaTypes');
  }
});
</script>
