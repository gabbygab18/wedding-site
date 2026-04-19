# 💍 Wedding Invitation Site — Laravel

A beautiful, animated wedding invitation website with an envelope-opening experience, built with Laravel 11, Blade, SCSS, and vanilla JS. Includes a full admin panel.

---

## ✨ Features

### Guest-Facing Site
- **Envelope Animation** — guests open a wax-sealed envelope to reveal the invitation
- Floating petal particles in the background
- Elegant Cormorant Garamond / Cinzel typography (luxury editorial aesthetic)
- Animated countdown timer to the wedding date
- Love story section, photo gallery, wedding entourage list
- RSVP form with AJAX submission (no page reload)
- Scroll-triggered reveal animations throughout

### Admin Panel (`/admin`)
- Dashboard with RSVP stats (total, attending, declined, guest count)
- Edit all wedding details (couple names, date, time, venue, story, hashtag)
- Photo gallery management with drag-and-drop upload + sort order
- Entourage manager (add/remove members with roles and sides)
- RSVP list with filter tabs, CSV export, and delete
- New RSVP badge indicator in sidebar navigation

---

## 🚀 Quick Setup

### Requirements
- PHP 8.2+
- Composer
- Node.js 18+ & npm
- SQLite (default) or MySQL

### Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Run migrations and seed sample data
php artisan migrate --seed

# 5. Create storage symlink
php artisan storage:link

# 6. Install Node dependencies
npm install

# 7. Build assets (CSS + JS)
npm run build

# 8. Start development server
php artisan serve
```

Then visit:
- **Invitation:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin/login

### Default Admin Credentials
```
Email:    admin@wedding.local
Password: password
```
> ⚠️ Change this immediately in production via `php artisan tinker` or the database.

---

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php       # All admin panel logic
│   │   └── InvitationController.php  # Public invitation + RSVP
│   └── Models/
│       ├── Wedding.php
│       ├── WeddingPhoto.php
│       ├── EntourageMember.php
│       └── Rsvp.php
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php         # Guest site layout
│   │   │   └── admin.blade.php       # Admin layout with sidebar
│   │   ├── invitation.blade.php      # Main invitation page
│   │   └── admin/
│   │       ├── login.blade.php
│   │       ├── dashboard.blade.php
│   │       ├── wedding-edit.blade.php
│   │       ├── photos-index.blade.php
│   │       ├── entourage-index.blade.php
│   │       └── rsvp-index.blade.php
│   ├── scss/
│   │   ├── app.scss                  # Invitation styles (cream + gold)
│   │   └── admin.scss                # Admin panel styles
│   └── js/
│       ├── app.js                    # Envelope animation + countdown + RSVP
│       └── admin.js                  # Admin UI interactions
│
├── database/
│   ├── migrations/                   # 4 migration files
│   └── seeders/DatabaseSeeder.php    # Sample couple + entourage data
│
└── routes/web.php                    # All routes
```

---

## 🎨 Customisation

### Change the couple's details
Log in to `/admin` and go to **Wedding Details** to update names, date, venue, story, and more.

### Change the colour palette
Edit `resources/scss/app.scss` — all colours are SCSS variables at the top:
```scss
$cream:     #F9F3E8;
$gold:      #C9A96E;
$rose:      #8B2635;
$text-dark: #2A1F14;
```

### Personalised guest links
Append `?guest=Your+Name` to the URL to pre-fill the envelope address:
```
https://yourdomain.com/?guest=Maria+Santos
```

### Switch to MySQL
In `.env`, change:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=wedding_db
DB_USERNAME=root
DB_PASSWORD=secret
```
Then run `php artisan migrate --seed`.

---

## 🔒 Security Notes

- Admin panel is protected by Laravel's built-in authentication middleware
- All forms use CSRF tokens
- File uploads are validated (images only, max 5MB)
- Change the default admin password before going live

---

## 📦 Production Deployment

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

Set `APP_DEBUG=false` and `APP_ENV=production` in `.env`.

---

Made with ❤️ for your special day.
# wedding-site
