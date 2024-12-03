
# News Aggregator

This is a news aggregator built with Laravel 11, designed to fetch articles from external APIs such as News API, New York Times, and The Guardian. The project uses Laravel's scheduler and queues to automate news fetching and processing tasks.

## Features
- Aggregates news from multiple external sources.
- Uses external APIs for fetching news:
  - News API
  - New York Times
  - The Guardian
- Implements Laravel Queues for background processing.
- Scheduler for periodic news fetching.

## Prerequisites
Before you begin, ensure you have the following installed:
- PHP 8.2 or higher
- Composer
- Laravel 11
- MySQL or any supported database
- Redis (for queues, optional but recommended)
- Node.js and npm (for frontend build tools like Vite)

## Installation Instructions

### 1. Clone the repository
Clone the repository to your local machine:

```bash
git clone https://github.com/Moaz98Hamde/news-aggregator-backend.git
cd news-aggregator-backend
```

### 2. Install dependencies
Run the following command to install the necessary PHP dependencies:

```bash
composer install
```

### 3. Configure Environment Variables
Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Open the `.env` file and set up your API keys for the external services:

```env
NEWS_API_KEY=<your-news-api-key>
NY_TIMES_API_KEY=<your-ny-times-api-key>
THE_GUARDIAN_API_KEY=<your-the-guardian-api-key>
```

Make sure your other environment variables, such as database credentials, are properly set.

### 4. Generate Application Key
Generate the Laravel application key:

```bash
php artisan key:generate
```

### 5. Set up Database
Set up your database by running the migrations and seeding:

```bash
php artisan migrate --seed
```

The seeder will run `CategoriesSeeder` to populate the categories table with initial data.

### 6. Configure Queues (Optional)
If you're using Redis for queueing, ensure that it's properly set up. You can configure the queue in the `.env` file:

```env
QUEUE_CONNECTION=redis
```

To start processing the queues, run the following command:

```bash
php artisan queue:work
```

### 7. Set up Scheduler (Optional)
To ensure news is fetched regularly, add the following line to your system's cron file:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

This will run Laravel's scheduler every minute.


This will compile and bundle your frontend assets for production.

### 8. Run the Application
You can now serve the application locally using:

```bash
php artisan serve
```

### 9. Run Development Server (Optional)
You can run the development environment using the following command, which starts the Laravel development server, queues, logs, and Vite:

run the following:
- `php artisan serve` (Laravel development server)
- `php artisan queue:listen --tries=1` (Queue listener)
- `php artisan pail --timeout=0` (Laravel Pail for logging)

## Simple API Documentation For The Available Endpoints

| **Endpoint**          | **Description**                          | **Controller**                | **Filters**                                                                 | **Example** |
|------------------------|------------------------------------------|--------------------------------|------------------------------------------------------------------------------|-------------|
| `/sources`            | Lists all available news sources.       | `ListSourcesController`       | None                                                                         | `GET /api/sources` |
| `/categories`         | Lists paginated news categories.             | `ListCategoriesController`    | None                                                                         | `GET /api/categories` |
| `/articles`           | Lists paginated updated articles with optional filters. | `ListArticlesController`      | - `title`: Filters by title (partial match). <br> - `category`: Filters by category ID. <br> - `author`: Filters by author name. <br> - `source`: Filters by source name. | `GET /api/articles?title=example&category=1&author=John Doe&source=APIName` |


