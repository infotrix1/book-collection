<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import BookImg from '@/Assets/book.jpg';

const props = defineProps({
  book: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits<{
  (event: 'edit', book: any): void;
}>();

const statusColors = {
  available: { bg: 'bg-green-100', text: 'text-green-800' },
  borrowed: { bg: 'bg-yellow-100', text: 'text-yellow-800' },
  reserved: { bg: 'bg-purple-100', text: 'text-purple-800' },
};

const handleDelete = (id: string) => {
  if (confirm('Are you sure you want to delete this book?')) {
    Inertia.delete(route('books.destroy', id));
  }
};

const handleEdit = (book: any) => {
  emit('edit', book);  
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
    <img :src="BookImg" :alt="book.title" class="w-full h-48 object-cover" />
    <div class="p-4">
      <div class="flex justify-between items-start mb-2">
        <h3 class="text-xl font-semibold text-gray-800">{{ book.title }}</h3>
        <span
          :class="[
            'px-2 py-1 rounded-full text-sm font-medium',
            statusColors[book.status].bg,
            statusColors[book.status].text
          ]"
        >
          {{ book.status.charAt(0).toUpperCase() + book.status.slice(1) }}
        </span>
      </div>
      <p class="text-gray-600">{{ book.author }}</p>
      <p class="text-sm text-gray-500 mt-2">{{ book.description }}</p>
      <p class="text-sm text-gray-500 mt-1">Published: {{ book.published_year }}</p>
      <div class="mt-4 flex justify-end space-x-2">
        <button
          @click="handleEdit(book)"
          class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
        >
          Edit
        </button>
        <button
          @click="handleDelete(book.id)"
          class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>
