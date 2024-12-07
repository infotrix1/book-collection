<script setup lang="ts">
import type { BookStatus } from '../types/book';

const props = defineProps<{
  selectedStatus: BookStatus | 'all';
}>();

const emit = defineEmits<{
  (e: 'update:selectedStatus', status: BookStatus | 'all'): void;
}>();

const statuses: { value: BookStatus | 'all'; label: string }[] = [
  { value: 'all', label: 'All Books' },
  { value: 'available', label: 'Available' },
  { value: 'borrowed', label: 'Borrowed' },
  { value: 'reserved', label: 'Reserved' },
];
</script>

<template>
  <div class="flex gap-2">
    <button
      v-for="status in statuses"
      :key="status.value"
      @click="emit('update:selectedStatus', status.value)"
      :class="[
        'px-4 py-2 rounded-md transition',
        props.selectedStatus === status.value
          ? 'bg-blue-500 text-white'
          : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
      ]"
    >
      {{ status.label }}
    </button>
  </div>
</template>