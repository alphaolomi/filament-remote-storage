# Filament Remote Storage

A Laravel application demonstrating Filament PHP admin panel with remote storage integration using MinIO (local/staging) and AWS S3 (production), powered by Spatie Media Library.

## 🚀 Features

- **Filament PHP Admin Panel** - Modern, beautiful admin interface
- **Remote Storage Integration** - Seamless switching between MinIO and S3
- **Media Library** - Advanced file management with Spatie Media Library
- **Image Processing** - Automatic image conversions and thumbnails
- **ULID Support** - Unique identifier generation for posts
- **Slug Generation** - Auto-generated SEO-friendly URLs
- **Docker Support** - Easy MinIO setup with Docker Compose

## 📋 Requirements

- PHP ^8.2
- Composer
- Node.js & NPM
- Docker & Docker Compose (for MinIO)
- SQLite (default) or MySQL/PostgreSQL

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd filament-remote-storage
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

Copy the example environment file:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Storage

#### For Local/Staging (MinIO)

The `.env` file is pre-configured for MinIO. Update if needed:

```env
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=minioadmin
AWS_SECRET_ACCESS_KEY=minioadmin
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=filament-media
AWS_ENDPOINT=http://localhost:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_URL=http://localhost:9000/filament-media
```

#### For Production (AWS S3)

Update your `.env` file with your AWS credentials:

```env
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-production-bucket
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
AWS_URL=https://your-bucket.s3.amazonaws.com
```

### 5. Start MinIO (Local/Staging)

```bash
docker-compose up -d
```

This will:
- Start MinIO server on port 9000
- Start MinIO console on port 9001
- Automatically create the `filament-media` bucket
- Set the bucket to public access

**Access MinIO Console:**
- URL: http://localhost:9001
- Username: `minioadmin`
- Password: `minioadmin`

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Create Storage Link (if using local disk)

```bash
php artisan storage:link
```

### 8. Start Development Server

```bash
php artisan serve
```

Or use the dev script for concurrent services:

```bash
composer run dev
```

This runs:
- Laravel server
- Queue worker
- Vite dev server

## 📁 Project Structure

```
filament-remote-storage/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── PostResource.php      # Filament resource for posts
│   └── Models/
│       └── Post.php                  # Post model with media library
├── config/
│   ├── filesystems.php               # Storage configuration
│   └── media-library.php             # Media library configuration
├── database/
│   └── migrations/
│       └── create_posts_table.php     # Posts table migration
├── docker-compose.yml                 # MinIO Docker setup
└── .env                               # Environment configuration
```

## 🎯 Usage

### Accessing the Admin Panel

1. Start the development server: `php artisan serve`
2. Navigate to: `http://localhost:8000/admin`
3. Log in with your admin credentials

### Creating Posts

1. Navigate to **Posts** in the admin panel
2. Click **Create Post**
3. Fill in the form:
   - **Title** - Auto-generates slug
   - **Slug** - SEO-friendly URL (editable)
   - **ULID** - Auto-generated unique identifier
   - **Content** - Rich text editor
   - **Published At** - Optional publication date
   - **Featured Image** - Single image with conversions
   - **Image Gallery** - Multiple images (up to 10)
   - **Documents** - PDF and Word documents

### Media Collections

The Post model includes three media collections:

1. **featured_image** - Single file collection
   - Thumbnail conversion (300x300)
   - Medium conversion (800x600)

2. **gallery** - Multiple file collection
   - Thumbnail conversion (200x200)

3. **documents** - Multiple file collection
   - No conversions (original files)

## 🔧 Configuration

### Filesystem Configuration

The `config/filesystems.php` file includes an S3 disk configured for both MinIO and AWS S3:

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
    'visibility' => 'public',
],
```

### Media Library Configuration

The `config/media-library.php` uses the `FILESYSTEM_DISK` environment variable:

```php
'disk_name' => env('FILESYSTEM_DISK', 's3'),
```

## 🧪 Testing

Run the test suite:

```bash
composer test
```

Or with Pest:

```bash
php artisan test
```

## 📦 Technologies Used

- **Laravel 12** - PHP framework
- **Filament 4** - Admin panel
- **Spatie Media Library** - File management
- **MinIO** - S3-compatible object storage
- **AWS S3** - Production storage
- **Docker** - Containerization
- **Pest** - Testing framework

## 🔄 Queue Configuration

Image conversions are processed via queues. Configure in `.env`:

```env
QUEUE_CONNECTION=database
```

For synchronous processing (development):

```env
QUEUE_CONNECTION=sync
```

Run queue worker:

```bash
php artisan queue:work
```

## 🐳 Docker Commands

### Start MinIO

```bash
docker-compose up -d
```

### Stop MinIO

```bash
docker-compose down
```

### View MinIO Logs

```bash
docker-compose logs -f minio
```

### Remove MinIO Data

```bash
docker-compose down -v
```

## 🔐 Security

- Never commit `.env` file to version control
- Use strong credentials for production S3 buckets
- Configure proper IAM roles for AWS S3 access
- Set appropriate bucket policies for public/private access

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📚 Additional Resources

- [Filament Documentation](https://filamentphp.com/docs)
- [Spatie Media Library Documentation](https://spatie.be/docs/laravel-medialibrary)
- [MinIO Documentation](https://min.io/docs)
- [Laravel Documentation](https://laravel.com/docs)

## 🆘 Troubleshooting

### MinIO Connection Issues

1. Ensure MinIO is running: `docker-compose ps`
2. Check MinIO logs: `docker-compose logs minio`
3. Verify bucket exists in MinIO console
4. Check `.env` configuration matches MinIO settings

### Image Conversions Not Working

1. Ensure queue worker is running: `php artisan queue:work`
2. Check queue connection in `.env`
3. Verify image driver is installed (GD or Imagick)
4. Check application logs: `storage/logs/laravel.log`

### Storage Link Issues

If using local storage, ensure the symbolic link exists:

```bash
php artisan storage:link
```

## 🎉 Getting Started

1. Clone the repository
2. Install dependencies: `composer install && npm install`
3. Copy `.env.example` to `.env` and configure
4. Start MinIO: `docker-compose up -d`
5. Run migrations: `php artisan migrate`
6. Start server: `php artisan serve`
7. Access admin panel: http://localhost:8000/admin

Enjoy building with Filament and remote storage! 🚀

