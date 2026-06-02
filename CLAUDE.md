# Food & Beverage Industry Portal — Project Guide

## Project Overview

A Laravel 8 web portal for the Food & Beverage industry. Features include industry news, product directory, company directory, events, and a full admin panel.

- **Live URL (XAMPP):** `http://localhost/Industry%20Website/public/`
- **Live URL (artisan serve):** `http://localhost:8000`
- **GitHub:** `https://github.com/Shorifa1234/pet_industry_website`

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 8 |
| PHP | 7.3+ / 8.0+ |
| Database | MySQL (via XAMPP) |
| Frontend | Bootstrap 5.3, Font Awesome 6, Inter font |
| Server (dev) | XAMPP Apache or `php artisan serve` |
| Auth | Laravel Breeze (built-in Auth) |

---

## Local Setup

### Prerequisites
- XAMPP (Apache + MySQL)
- PHP 8.0+
- Composer

### Steps

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=food_industry
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Seed database (if seeder exists)
php artisan db:seed

# 7. Create storage symlink
php artisan storage:link

# 8. Start server
php artisan serve
```

---

## Environment (.env) Key Settings

```env
APP_NAME="Food & Beverage Industry"
APP_ENV=local
APP_DEBUG=true                    # Set false in production
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=food_industry
DB_USERNAME=root
DB_PASSWORD=                      # Empty for XAMPP default

SESSION_DRIVER=file
SESSION_LIFETIME=120
```

---

## Admin Credentials

| Field | Value |
|-------|-------|
| Email | `admin@foodindustry.com` |
| Password | `admin123` |
| Role | `admin` |

**Admin Panel URL:** `http://localhost:8000/admin`

> **Note:** After login, navigate directly to `/admin`. The session works correctly with `php artisan serve` on port 8000. Avoid using XAMPP subdirectory URL for the admin panel due to cookie path issues.

---

## Database

**Database name:** `food_industry`

### Tables

| Table | Description |
|-------|-------------|
| `users` | Admin, editor, regular users |
| `categories` | Article/product/event categories |
| `articles` | News & articles |
| `products` | Product listings |
| `companies` | Company directory |
| `events` | Industry events |
| `sessions` | User sessions |

### User Roles
- `admin` — full access to admin panel
- `editor` — content management only
- `user` — frontend only

---

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin panel controllers
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── CompanyController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EventController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── UserController.php
│   │   │   ├── ArticleController.php   # Frontend
│   │   │   ├── CompanyController.php
│   │   │   ├── EventController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   └── SitemapController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Article.php
│       ├── Category.php
│       ├── Company.php
│       ├── Event.php
│       ├── Product.php
│       └── User.php
├── public/
│   ├── images/
│   │   ├── logo.svg               # Logo (blue bg — for admin sidebar)
│   │   ├── logo-white.svg         # Logo (transparent — for header/footer)
│   │   └── hero-illustration.svg  # Hero section illustration
│   ├── robots.txt
│   └── storage -> storage/app/public  (symlink)
├── resources/views/
│   ├── admin/                     # Admin panel views
│   │   ├── articles/
│   │   ├── categories/
│   │   ├── companies/
│   │   ├── events/
│   │   ├── products/
│   │   ├── users/
│   │   └── dashboard.blade.php
│   ├── frontend/                  # Public-facing views
│   │   ├── articles/
│   │   ├── companies/
│   │   ├── events/
│   │   ├── home.blade.php
│   │   └── products/
│   ├── layouts/
│   │   ├── admin.blade.php
│   │   └── app.blade.php
│   └── sitemap.blade.php
├── routes/
│   └── web.php
└── storage/app/public/
    ├── articles/                  # Article featured images (SVG)
    └── products/                  # Product images (SVG)
```

---

## Routes

### Frontend
| URL | Name | Description |
|-----|------|-------------|
| `/` | `home` | Homepage |
| `/news` | `articles.index` | News listing |
| `/news/{slug}` | `articles.show` | Article detail |
| `/news/category/{slug}` | `articles.category` | Category filter |
| `/products` | `products.index` | Products listing |
| `/products/{slug}` | `products.show` | Product detail |
| `/directory` | `companies.index` | Company directory |
| `/directory/{slug}` | `companies.show` | Company profile |
| `/events` | `events.index` | Events listing |
| `/events/{slug}` | `events.show` | Event detail |
| `/sitemap.xml` | `sitemap` | XML sitemap |

### Admin (requires auth + admin role)
| URL | Description |
|-----|-------------|
| `/admin` | Dashboard |
| `/admin/articles` | Article management |
| `/admin/products` | Product management |
| `/admin/companies` | Company management |
| `/admin/events` | Event management |
| `/admin/categories` | Category management |
| `/admin/users` | User management |

---

## Key Models

### Article
- Route key: `slug`
- Scopes: `published()`, `featured()`
- `published()` scope checks: `status = 'published'` AND `published_at <= now()`
- Fields: title, slug, excerpt, content, featured_image, category_id, user_id, author_name, status, is_featured, views, tags, published_at

### Product
- Route key: `slug`
- Scope: `published()`
- `gallery` field cast to `array`
- Fields: name, slug, short_description, description, featured_image, gallery, category_id, company_id, brand, sku, status, is_featured, tags

### Company
- Route key: `slug`
- Status values: `active`, `inactive`, `pending`

### Event
- Route key: `slug`
- Status values: `upcoming`, `past`, `cancelled`
- Scope: `upcoming()` — status=upcoming AND start_date >= now()

### User
- Roles: `admin`, `editor`, `user`
- `isAdmin()` — returns true if role = admin
- `isEditor()` — returns true if role = admin OR editor
- `is_active` — inactive users cannot login

---

## Images

All images are SVG files stored in `storage/app/public/`:

### Article Images (auto-assigned by category)
| File | Category |
|------|---------|
| `articles/cat-market-trends.svg` | Market Trends |
| `articles/cat-regulatory.svg` | Regulatory & Safety |
| `articles/cat-sustainability.svg` | Sustainability |
| `articles/cat-ingredients.svg` | Ingredients |
| `articles/cat-processing.svg` | Processing & Technology |
| `articles/cat-packaging.svg` | Packaging |

### Product Images
| File | Product |
|------|---------|
| `products/natural-flavor-enhancer.svg` | Natural Flavor Enhancer Pro |
| `products/wheat-protein.svg` | Organic Wheat Protein Isolate |
| `products/plant-fat-replacer.svg` | Plant-Based Fat Replacer |
| `products/vanilla-extract.svg` | Premium Vanilla Extract |
| `products/beverage-stabilizer.svg` | Beverage Stabilizer System |
| `products/clean-label-preservative.svg` | Clean Label Preservative |

> Images are served via `asset('storage/filename.svg')`.
> Symlink must exist: `php artisan storage:link`

---

## SEO Implementation

Every page includes:
- `<title>`, `<meta description>`, `<meta keywords>`, `rel=canonical`
- Open Graph tags (og:title, og:description, og:image, og:url, og:type)
- Twitter Card tags

Structured data (JSON-LD) per page type:
| Page | Schema |
|------|--------|
| Article show | `NewsArticle` + `BreadcrumbList` |
| Product show | `Product` + `BreadcrumbList` |
| Company show | `Organization` + `BreadcrumbList` |
| Event show | `Event` + `BreadcrumbList` |
| Homepage | `WebSite` (with SearchAction) + `Organization` |

Other SEO files:
- `/sitemap.xml` — auto-generated dynamic sitemap
- `/robots.txt` — crawl rules (admin/login pages blocked)

---

## Common Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Fresh migration + seed
php artisan migrate:fresh --seed

# Create storage symlink
php artisan storage:link

# Clear all caches
php artisan optimize:clear

# View all routes
php artisan route:list
```

---

## Bugs Fixed (History)

| Bug | Fix |
|-----|-----|
| Admin edit pages returned 404 | Changed `findOrFail($id)` to route model binding — models use slug as route key |
| Missing views: categories/create, articles/show, companies/show | Created missing blade files |
| Product admin showed all categories | Added `where('type', 'product')` filter |
| Cancelled events accessible on frontend | Added `abort(404)` check in `EventController::show()` |
| Inactive users could login | Added `is_active => true` to `LoginController::credentials()` |
| `gallery` field not decoded | Added `'gallery' => 'array'` cast to Product model |
| `Article::scopePublished` showed future articles | Added `published_at <= now()` condition |
| `public/storage` was empty directory, not symlink | Ran `php artisan storage:link` to fix |

---

## Production Checklist

Before deploying to live server:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_URL` to real domain
- [ ] Update `SESSION_SECURE_COOKIE=true` (HTTPS only)
- [ ] Update `robots.txt` sitemap URL to real domain
- [ ] Submit `sitemap.xml` to Google Search Console
- [ ] Set strong `DB_PASSWORD`
- [ ] Set `MAIL_FROM_ADDRESS` for email functionality
- [ ] Run `php artisan optimize` for caching
- [ ] Set proper file permissions on `storage/` and `bootstrap/cache/`
