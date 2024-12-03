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

## Installation Instructions

### 1. Clone the repository
Clone the repository to your local machine:

```bash
git clone [<repository-url>](https://github.com/Moaz98Hamde/news-aggregator-backend.git)
cd news-aggregator-backend
```

### 2. Install dependencies
Clone the repository to your local machine:

```bash
composer install
```

### 3. Configure Environment Variables
Copy the .env.example file to .env:

```bash
cp .env.example .env
```
Open the .env file and set up your API keys for the external services:


```bash
NEWS_API_KEY=<your-news-api-key>
NY_TIMES_API_KEY=<your-ny-times-api-key>
THE_GUARDIAN_API_KEY=<your-the-guardian-api-key>
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Set up Database
Set up your database by running the migrations and seeding:

```bash
php artisan migrate
php artisan db:seed --class=CategoriesSeeder
```

### 6. Configure Queues (Optional)
If you're using Redis for queueing, ensure that it's properly set up. You can configure the queue in the .env file:

```bash
QUEUE_CONNECTION=redis
```

### 7. Set up Scheduler (Optional)
To ensure news is fetched regularly, add the following line to your system's cron file:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
