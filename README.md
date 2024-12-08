## Book Collection Management System

The Book Collection Management System is a web application that allows users to manage a collection of books. The application is built using Laravel as the backend framework, Inertia.js as a bridge between Laravel and Vue.js, and Vue.js for the frontend. It features a paginated book listing, book creation and editing functionality, and status-based filtering.

## Features

- **Book Management.**
- View a paginated list of books.
- Add new books to the collection.
- Edit details of existing books.
- Soft Delete books from the collection..
- **Filtering.**
- Filter books by their status (available, borrowed, reserved).
- Filter books by the year they were published.
- **Pagination.**
- Paginated listing of books for better performance and usability.
- **Modal-based Book Management.**
- Use a modal interface for adding or editing book details without navigating away from the list.
- **Responsive Design.**
- Fully responsive design for use on desktop and mobile devices..

## Installation Prerequisites

Ensure you have the following installed:

- **PHP 8.0+**
- **Composer**
- **Node**
- **MySQL (or any other supported database)**

### Steps in Setting-up

- **Clone the repository**
- git clone https://github.com/infotrix1/book-collection.git
- **Install dependencies**
- composer install
- npm install
- **Configure environment variables**
- Update the .env file with your database and Redis credentials:
- **Generate the application key**
- php artisan key:generate
- **Run migrations to set up the database**
- php artisan migrate
- **Run the application**
- npm run dev
- php artisan serve

### Technology Stack
### Backend

- **Laravel**
- A PHP framework used to manage the application's backend, including routes, controllers, and services.
- **Inertia.js**
- A server-side rendering engine that allows Laravel to serve Vue components.
### Frontend
- **Vue.js**
- A progressive JavaScript framework used for building the user interface.
- **Tailwind CSS**
- A utility-first CSS framework for styling.
- **Axios**
- For making HTTP requests..

### Architecture
### Key Components

### Backend
- **Controller**
- BookController handles web routes and validation.
- **Services**
- BookService contains business logic for fetching and organize data.
- **Repository**
- BookRepository manages database interactions for Books.

### Frontend
- **Layouts**
- Store Layout style.
- **Components**
- Store all Modal.
- **Pages**
- Book Pages.




  


