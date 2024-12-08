<script setup lang="ts">
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps<{
  show: boolean;
  editingBook: {
    id?: string;
    title: string;
    author: string;
    description: string;
    published_year: number;
    status: 'available' | 'borrowed' | 'reserved';
  } | null;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'save', book: { id?: string; title: string; author: string; description: string; published_year: number; status: 'available' | 'borrowed' | 'reserved' }): void;
}>();

const formData = ref({
  title: '',
  author: '',
  description: '',
  published_year: new Date().getFullYear(), 
  status: 'available' as 'available' | 'borrowed' | 'reserved',
});

const statuses: ('available' | 'borrowed' | 'reserved')[] = ['available', 'borrowed', 'reserved'];

watch(() => props.editingBook, (newBook) => {
  if (newBook) {
    formData.value = { ...newBook };
  } else {
    formData.value = {
      title: '',
      author: '',
      description: '',
      published_year: new Date().getFullYear(), 
      status: 'available',
    };
  }
}, { immediate: true });

const handleSubmit = () => {
  const method = props.editingBook ? 'put' : 'post';  
  const url = props.editingBook
    ? route('books.update', props.editingBook.id)
    : route('books.store');  

  Inertia[method](url, formData.value);  

  emit('close');
};
</script>

<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
      <h2 class="text-2xl font-semibold mb-4">
        {{ editingBook ? 'Edit Book' : 'Add New Book' }}
      </h2>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Title</label>
          <input
            v-model="formData.title"
            type="text"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Author</label>
          <input
            v-model="formData.author"
            type="text"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea
            v-model="formData.description"
            required
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          ></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Published Year</label>
          <input
            v-model="formData.published_year"
            type="number"
            required
            min="1800"
            :max="new Date().getFullYear()"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Status</label>
          <select
            v-model="formData.status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          >
            <option v-for="status in statuses" :key="status" :value="status">
              {{ status.charAt(0).toUpperCase() + status.slice(1) }}
            </option>
          </select>
        </div>
        <div class="flex justify-end space-x-2 mt-6">
          <button
            type="button"
            @click="emit('close')"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
          >
            {{ editingBook ? 'Update' : 'Add' }} Book
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
