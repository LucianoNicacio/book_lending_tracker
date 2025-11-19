📚 Book Lending Tracker API

A Laravel-based REST API for managing books, friends, and lending transactions.
Designed as a clean, testable architecture with business rules, service layers, form requests, and API resources.

🚀 Features
Books

Add new books

List all books

Validates ISBN (10 or 13 digits)

Friends

Add friends who can borrow books

Lendings

Lend a book to a friend

Mark a lending as returned

Prevent double-lending a book

Enforce lending/return date logic

Reports

List all overdue lendings (due date < today)

Architecture

Form Request for validation

Service class for business logic

API Resource for consistent JSON responses

Custom Exception for business rule violations

Fully tested with PHPUnit

🗂 Project Structure (Important Files)
app/
 ├─ Exceptions/
 │   └─ BusinessRuleException.php
 ├─ Http/
 │   ├─ Controllers/
 │   │   ├─ BookController.php
 │   │   ├─ FriendController.php
 │   │   ├─ LendingController.php
 │   │   └─ ReportController.php
 │   ├─ Requests/
 │   │   └─ LendBookRequest.php
 │   └─ Resources/
 │       └─ LendingResource.php
 ├─ Models/
 │   ├─ Book.php
 │   ├─ Friend.php
 │   └─ Lending.php
 └─ Services/
     └─ LendingService.php

🧬 Business Rules
❌ Cannot lend a book that is already lent out

A book with an active lending (return_at = null) cannot be lent again.

📅 Due date must be in the future

Enforced at the validation layer (after:today).

❌ Cannot return a book before it was lent

If return_at < lent_at, a custom exception is thrown.

🔢 ISBN must be valid

Book creation validates that ISBN must contain:

exactly 10 digits, or

exactly 13 digits

🛣 API Endpoints
📚 Books
Method	URL	Description
POST	/api/books	Store new book
GET	/api/books	List all books
🧑‍🤝‍🧑 Friends
Method	URL	Description
POST	/api/friends	Add a friend
📘 Lendings
Method	URL	Description
POST	/api/lendings	Lend a book
PATCH	/api/lendings/{id}	Mark a book as returned
⏰ Reports
Method	URL	Description
GET	/api/reports/overdue	List overdue lendings
🧪 Testing

This project includes a PHPUnit test that verifies a core business rule:

✔ Can't lend a book that's already lent out
tests/Feature/LendBookTest.php


Run tests with:

php artisan test

🛠 Installation
1. Clone the repo
git clone https://github.com/<your-username>/<your-repo>.git
cd <your-repo>

2. Install dependencies
composer install

3. Copy environment file
cp .env.example .env

4. Generate app key
php artisan key:generate

5. Configure your database

Update .env:

DB_DATABASE=book_lending
DB_USERNAME=root
DB_PASSWORD=

6. Run migrations
php artisan migrate

7. Serve the application
php artisan serve

📘 Example API Usage
Create a book
POST /api/books
{
  "title": "The Hobbit",
  "author": "J.R.R. Tolkien",
  "isbn": "1234567890",
  "added_at": "2024-01-01"
}

Lend a book
POST /api/lendings
{
  "book_id": 1,
  "friend_id": 2,
  "lent_at": "2024-02-01",
  "due_at": "2024-03-01"
}

Mark as returned
PATCH /api/lendings/1
{
  "return_at": "2024-02-15"
}

🧼 Code Quality Highlights

Clean separation of concerns

Controllers are thin

Validation moved to Form Requests

Business logic encapsulated in a Service class

Consistent JSON responses via Resources

Domain rule failures result in custom exceptions

One reliable feature test included

🤝 Contributions

PRs and suggestions are welcome!
Feel free to open issues or submit improvements.

📄 License

MIT – free to use and modify.
