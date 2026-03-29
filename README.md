# External API Laravel Exam

A modern Laravel 13 REST API that imports data from an external API (JSONPlaceholder) and exposes it through authenticated endpoints with full test coverage.

## 🎯 What This Project Does

1. **Syncs Data**: Fetches 10 users, 100 posts, 200 todos, 100 albums, and 5,000 photos from JSONPlaceholder
2. **Stores Safely**: Uses DTOs (Data Transfer Objects) to validate and transform data before storing in PostgreSQL
3. **Protects Access**: Requires JWT authentication for all API endpoints
4. **Provides REST API**: Exposes the data through clean, paginated REST endpoints
5. **Tests Everything**: Includes feature tests for API endpoints and unit tests for business logic

## 🚀 Quick Start

### Prerequisites
- Docker and Docker Compose
- Git

### Installation (6 steps)

```bash
# 1. Navigate to repository
cd /home/rudy/projects/exam

# 2. Copy environment file
cp src/backend/slmp.exam.test/.env.example src/backend/slmp.exam.test/.env

# 3. Install dependencies
docker compose run --rm backend composer install

# 4. Generate keys
docker compose run --rm backend php artisan key:generate
docker compose run --rm backend php artisan jwt:secret

# 5. Setup database and sync data
docker compose up -d postgres
docker compose run --rm backend php artisan migrate --seed
docker compose run --rm backend php artisan app:sync-remote-data

# 6. Start the application
docker compose up --build -d
```

**Your API is ready at**: `http://localhost:8000`

## 📊 Technology Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Language** | PHP | 8.4 |
| **Framework** | Laravel | 13 |
| **Database** | PostgreSQL | 16 |
| **Authentication** | JWT (tymon/jwt-auth) | 2.3 |
| **Server** | Nginx + PHP-FPM | Latest |
| **Containers** | Docker Compose | Latest |

## 🔐 Authentication

### Get a Token

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'
```

**Response:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

### Use the Token

Add to every request:

```bash
curl http://localhost:8000/api/v1/users \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Default Test Account

- **Email**: `test@example.com`
- **Password**: `password`
- **Created by**: `php artisan migrate --seed`

## 🌐 API Endpoints

### Authentication
- `POST /api/v1/auth/login` - Get JWT token
- `GET /api/v1/auth/me` - Get current user profile
- `POST /api/v1/auth/refresh` - Refresh expired token (expires in 1 hour)
- `POST /api/v1/auth/logout` - Revoke token

### Data Endpoints (All require authentication)
- `GET /api/v1/users` - List all users (paginated)
- `GET /api/v1/posts` - List all posts (paginated)
- `GET /api/v1/comments` - List all comments (paginated)
- `GET /api/v1/albums` - List all albums (paginated)
- `GET /api/v1/photos` - List all photos (paginated)
- `GET /api/v1/todos` - List all todos (paginated)

### Relationship Endpoints
- `GET /api/v1/users/{id}/albums` - Get user's albums (paginated)
- `GET /api/v1/users/{id}/todos` - Get user's todos (paginated)
- `GET /api/v1/users/{id}/posts` - Get user's posts (paginated)
- `GET /api/v1/posts/{id}/comments` - Get post's comments (paginated)
- `GET /api/v1/albums/{id}/photos` - Get album's photos (paginated)

### Pagination

All collection endpoints use page-based pagination:

```bash
# Get page 1 (default: 10 items per page)
curl 'http://localhost:8000/api/v1/users?page=1' \
  -H "Authorization: Bearer TOKEN"
```

**Response structure:**
```json
{
  "data": [
    { "id": 1, "name": "User 1", ... },
    { "id": 2, "name": "User 2", ... }
  ],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "to": 10,
    "total": 1000,
    "per_page": 10,
    "last_page": 100
  }
}
```

**Parameters:**
- `page` (int, optional) - Page number, defaults to 1
- **Default limit**: 10 items per page
- **Maximum limit**: 100 items per page

## 🛠️ Management Commands

### Initialize Application

```bash
docker compose run --rm backend php artisan app:initialize
```

Runs database migrations and seeding. Use `--skip-seed` to skip seeding step.

### Create API User

```bash
docker compose run --it backend php artisan app:create-admin-user
```

Interactively create a new user for API authentication.

### Sync External Data

```bash
docker compose run --rm backend php artisan app:sync-remote-data
```

Fetches all data from JSONPlaceholder:
- **10 users** with addresses and companies
- **100 posts** with 500 comments
- **100 albums** with 5,000 photos
- **200 todos**

**Safe to run multiple times** (idempotent - existing records are updated, not duplicated)

## 🧪 Testing

### Run All Tests

```bash
docker compose run --rm backend php artisan test
```

### Run Feature Tests

```bash
docker compose run --rm backend php artisan test tests/Feature
```

**Verifies:**
- Authentication flow (login, refresh, logout)
- API authorization and access control
- Endpoint response formatting
- Data syncing correctness
- Pagination functionality

### Run Unit Tests

```bash
docker compose run --rm backend php artisan test tests/Unit
```

**Run specific test:**
```bash
docker compose run --rm backend php artisan test tests/Unit/Models/UserTest.php
```

**Run tests matching pattern:**
```bash
docker compose run --rm backend php artisan test --filter=UserTest
```

**With code coverage:**
```bash
docker compose run --rm backend php artisan test --coverage
```

**Verifies:**
- Model relationships and accessors
- DTO serialization and validation
- Service layer business logic
- Data transformation accuracy

## 🧑‍💻 Interactive API Testing

Use the `.rest` files in `src/backend/testing/` to test endpoints manually:

**Available files:**
- `auth.rest` - Login, token refresh, profile, logout
- `users.rest` - User listing and user relationships
- `posts.rest` - Posts and comments
- `comments.rest` - Comments access
- `albums.rest` - Albums and album photos
- `photos.rest` - Photos listing
- `todos.rest` - Todos listing

**Compatible with:**
- ✅ VS Code REST Client extension
- ✅ IntelliJ HTTP Client
- ✅ Postman (import the files)
- ✅ Any REST client (curl, httpie, etc.)

## 📁 Project Structure

```
src/backend/slmp.exam.test/
├── app/
│   ├── DTO/                    # Data Transfer Objects (UserDTO, PostDTO, etc.)
│   ├── Http/
│   │   ├── Controllers/        # API controllers (endpoints)
│   │   ├── Requests/           # Form request validation
│   │   └── Resources/          # API response formatting
│   ├── Models/                 # Eloquent ORM models
│   ├── Services/               # Business logic (data syncing)
│   └── Providers/              # Laravel service providers
├── database/
│   ├── migrations/             # Database schema definitions
│   └── seeders/                # Demo data seeding
├── routes/
│   └── api.php                 # API routes
├── tests/
│   ├── Feature/                # API endpoint tests
│   └── Unit/                   # Unit tests
└── config/                     # Configuration files
```

## 🔄 Data Syncing Architecture

Uses **Data Transfer Objects (DTOs)** for type safety:

1. **Fetch** - HTTP request to JSONPlaceholder API
2. **Validate** - DTO validates data types and structure
3. **Transform** - Convert camelCase (API) to snake_case (database)
4. **Upsert** - Store data (create new or update existing records)
5. **Idempotent** - Running sync multiple times produces identical results

**Example:** When syncing users, `UserDTO` ensures:
- `id` is an integer
- `name` and `email` are valid strings
- `address` and `company` objects are properly structured
- Database fields use snake_case naming convention

## 📊 Database Schema

**Main tables:**
- `auth_users` - Application users for JWT authentication
- `users` - Imported users from JSONPlaceholder
- `addresses` - User addresses (normalized)
- `companies` - Company information (normalized)
- `posts` - Blog posts by users
- `comments` - Comments on posts
- `albums` - Photo albums by users
- `photos` - Photos in albums
- `todos` - Todo items by users

**Relationships:**
- User → has many Posts, Todos, Albums
- Post → has many Comments, belongs to User
- Album → has many Photos, belongs to User
- Photo → belongs to Album
- User → has one Address, one Company

## 🐛 Troubleshooting

### "Connection refused" to PostgreSQL

Start the database:
```bash
docker compose up -d postgres
```

### "Authentication failed" on API requests

- Verify you have a valid JWT token (not expired)
- Check token is included as: `Authorization: Bearer TOKEN`
- Tokens expire after 1 hour - use refresh endpoint to get a new one

### "Tests failing" after code changes

Rebuild the containers:
```bash
docker compose down
docker compose up --build -d
docker compose run --rm backend php artisan test
```

### Database migration errors

Check migration status:
```bash
docker compose run --rm backend php artisan migrate:status
```

Reset and retry:
```bash
docker compose run --rm backend php artisan migrate:reset
docker compose run --rm backend php artisan migrate --seed
```