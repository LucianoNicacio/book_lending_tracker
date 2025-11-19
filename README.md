# Book Lending Tracker API

A simple Laravel API for tracking books, friends, and lending transactions.

## 📚 What This Project Does

This API lets you:
- Add books
- Add friends  
- Lend a book to a friend
- Return a lent book
- View overdue lendings
- Enforce basic business rules (can't lend twice, date rules, valid ISBN)

### Built With
- **One Form Request** for validation
- **One Service Class** for lending logic  
- **One API Resource** for responses
- **One Custom Exception** for business rule errors
- **One Feature Test** to ensure you can't double-lend a book

## 🚀 Setup Instructions

### 1. Install dependencies
```bash
composer install
```

### 2. Copy environment file
```bash
cp .env.example .env
```

### 3. Generate app key
```bash
php artisan key:generate
```

### 4. Configure your database in `.env`
Example:
```env
DB_DATABASE=book_lending
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Run seeders (optional test data)
```bash
php artisan db:seed
```

### 7. Start the server
```bash
php artisan serve
```

## 📡 API Endpoints

### Books
- `POST /api/books` - Create a new book
- `GET /api/books` - List all books

### Friends  
- `POST /api/friends` - Add a new friend

### Lendings
- `POST /api/lendings` - Lend a book to a friend
- `PATCH /api/lendings/{id}` - Mark a book as returned

### Reports
- `GET /api/reports/overdue` - List all overdue lendings

## 🧪 Running Tests
```bash
php artisan test
```

The included test ensures a book cannot be lent out twice at the same time.

## 💼 Business Rules

- ✅ Cannot lend a book that's already lent out
- ✅ Due date must be in the future
- ✅ Return date cannot be before lent date  
- ✅ ISBN must be 10 or 13 digits

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **PHP:** 8.2+
- **Database:** MySQL/SQLite
- **Testing:** PHPUnit
