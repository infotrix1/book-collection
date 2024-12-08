import { ref, computed, watch } from 'vue';
import axios from 'axios';

const books = ref([]);
const isModalOpen = ref(false);
const editingBook = ref(null);

const fetchBooks = async () => {
  const { data } = await axios.get('/list');
  books.value = data.books;
};

const addBook = async (bookData: any) => {
  await axios.post('/books', bookData);
  await fetchBooks();
  closeModal();
};

const updateBook = async (bookData: any) => {
  await axios.put(`/books/${bookData.id}`, bookData);
  await fetchBooks();
  closeModal();
};

const deleteBook = async (id: string) => {
  await axios.delete(`/books/${id}`);
  await fetchBooks();
};

const openModal = (book: any = null) => {
  editingBook.value = book;
  isModalOpen.value = true;
};

const closeModal = () => {
  editingBook.value = null;
  isModalOpen.value = false;
};


export const useBooks = () => ({
  books,
  filteredBooks: computed(() => books.value),
  isModalOpen,
  editingBook,
  fetchBooks,
  addBook,
  updateBook,
  deleteBook,
  openModal,
  closeModal,
});
