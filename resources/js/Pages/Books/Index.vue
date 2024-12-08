<script>
import { ref, computed, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import BookCard from '@/Components/BookCard.vue';
import BookModal from '@/Components/BookModal.vue';
import StatusFilter from '@/Components/StatusFilter.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useBooks } from '@/Central/useBooks';

export default {
    components: {
        BookCard,
        BookModal,
        StatusFilter,
        AuthenticatedLayout,
    },
    props: {
        books: Object, 
    },
    setup() {
        const {
            filteredBooks,
            isModalOpen,
            editingBook,
            addBook,
            updateBook,
            deleteBook,
            openModal,
            closeModal
        } = useBooks();

        const books = ref([]);
        // Initialize pagination with default values
        const pagination = ref({
            currentPage: 1,
            lastPage: 1,
            nextPageUrl: null,
            prevPageUrl: null,
        });
        
        const selectedYear = ref(null); 
        const selectedStatus = ref(null); 
        
        const fetchBooks = async (page = 1) => {
            try {
                const { data } = await axios.get(`/list?page=${page}`);
                books.value = data.books.data;
                // Update pagination object with data from API
                pagination.value = {
                    currentPage: data.books.current_page,
                    lastPage: data.books.last_page,
                    nextPageUrl: data.books.next_page_url,
                    prevPageUrl: data.books.prev_page_url,
                };
            } catch (error) {
                console.error('Error fetching books:', error);
            }
        };

        onMounted(() => {
            fetchBooks(); // Initial fetch
        });

        const openModalHandler = (book) => {
            editingBook.value = book;
            isModalOpen.value = true; 
        };

        const handleSave = (bookData) => {
            if (bookData.id) {
                updateBook(bookData);
            } else {
                addBook(bookData);
            }
        };

        const filteredBooksList = computed(() => {
            return books.value.filter(book => {
                let statusMatch = selectedStatus.value ? book.status === selectedStatus.value : true;
                let yearMatch = selectedYear.value ? book.published_year === selectedYear.value : true;
                return statusMatch && yearMatch;
            });
        });

        const years = computed(() => {
            const uniqueYears = new Set(books.value.map(book => book.published_year));
            return [...uniqueYears].sort((a, b) => b - a); 
        });

        const handlePagination = (url) => {
            if (url) {
                const page = new URL(url).searchParams.get('page');
                fetchBooks(page);
            }
        };

        return {
            filteredBooks: filteredBooksList,
            books,
            isModalOpen,
            editingBook,
            selectedStatus,
            selectedYear,
            addBook,
            updateBook,
            deleteBook,
            openModal: openModalHandler,
            closeModal,
            handleSave,
            years,
            pagination,
            handlePagination,
        };
    }
};
</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Book Collection</h1>
                <button
                    @click="openModal()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                >
                    Add New Book
                </button>
            </div>

            <div class="flex gap-4 mb-6">
                <div class="relative">
                    <select
                        v-model="selectedStatus"
                        class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                        <option value="reserved">Reserved</option>
                    </select>
                </div>

                <div class="relative">
                    <select
                        v-model="selectedYear"
                        class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">All Years</option>
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <BookCard
                    v-for="book in filteredBooks"
                    :key="book.id"
                    :book="book"
                    @edit="openModal(book)"
                    @delete="deleteBook"
                />
            </div>

            <!-- Pagination Controls -->
            <div class="flex justify-center mt-6">
                <nav class="inline-flex space-x-2">
                    <button 
                        @click="handlePagination(pagination.prevPageUrl)" 
                        :disabled="!pagination.prevPageUrl"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        &laquo; Previous
                    </button>
                    <button 
                        v-for="page in pagination.lastPage" 
                        :key="page"
                        @click="handlePagination(`/list?page=${page}`)"
                        :class="pagination.currentPage === page ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'"
                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-md"
                    >
                        {{ page }}
                    </button>
                    <button 
                        @click="handlePagination(pagination.nextPageUrl)" 
                        :disabled="!pagination.nextPageUrl"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Next &raquo;
                    </button>
                </nav>
            </div>

            <BookModal
                :show="isModalOpen"
                :editing-book="editingBook"
                @close="closeModal"
                @save="handleSave"
            />
        </div>
    </div>
</AuthenticatedLayout>
</template>
