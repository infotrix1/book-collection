<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BookCard from '@/Components/BookCard.vue';
import BookModal from '@/Components/BookModal.vue';
import StatusFilter from '@/Components/StatusFilter.vue';
import { useBooks } from '@/Central/useBooks';

export default {
    components: {
        BookCard,
        BookModal,
        StatusFilter,
        // AuthenticatedLayout
    },
    props: {
        books: Object,  // books contain paginated data and links
    },
    setup() {
        const {
            filteredBooks,
            isModalOpen,
            editingBook,
            selectedStatus,
            addBook,
            updateBook,
            deleteBook,
            openModal,
            closeModal
        } = useBooks();

        // Function to open the modal for editing a book
        const openModalHandler = (book) => {
            // Set the editingBook to the book passed from BookCard
            editingBook.value = book;
            isModalOpen.value = true; // Open the modal
        };

        const handleSave = (bookData) => {
            if (bookData.id) {
                updateBook(bookData);
            } else {
                addBook(bookData);
            }
        };

        return {
            filteredBooks,
            isModalOpen,
            editingBook,
            selectedStatus,
            addBook,
            updateBook,
            deleteBook,
            openModal: openModalHandler, // Bind the openModal function to the new handler
            closeModal,
            handleSave
        };
    }
};
</script>
<template>
    <Head title="Dashboard" />

    <!-- <AuthenticatedLayout> -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <!-- Header with Title and Add New Book Button -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">My Book Collection</h1>
                    <button
                        @click="openModal()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                    >
                        Add New Book
                    </button>
                </div>

                <!-- Status Filter -->
                <div class="mb-6">
                    <StatusFilter v-model:selectedStatus="selectedStatus" />
                </div>

                <!-- Book Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <BookCard
                        v-for="book in filteredBooks"
                        :key="book"
                        :book="book"
                        @edit="openModal"
                        @delete="deleteBook"
                    />
                </div>

                <!-- Book Modal -->
                <BookModal
                    :show="isModalOpen"
                    :editing-book="editingBook"
                    @close="closeModal"
                    @save="handleSave"
                />
            </div>
        </div>
    <!-- </AuthenticatedLayout> -->
</template>
