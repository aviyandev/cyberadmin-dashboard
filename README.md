# CyberAdmin Dashboard

A cyberpunk-themed Laravel admin dashboard package built with Livewire 4, featuring zero-configuration installation and production-ready components.

## Quick Installation (Recommended)

### 1. Create a new Laravel project
```bash
composer create-project laravel/laravel my-project
cd my-project
```

### 2. Require the package
```bash
composer require cyberadmin/dashboard
```

### 3. Run the installation command
```bash
php artisan cyberadmin:install
```

### 5. Set up authentication (if needed)
```bash
composer require laravel/ui
php artisan ui:auth
npm install && npm run build
```

### 6. Start using the dashboard!
Visit `/cyberadmin` in your browser (make sure you're logged in).

---

## Available Artisan Commands

### `php artisan cyberadmin:install`
Complete installation command that:
- Checks and installs Livewire 4 if missing
- Publishes configuration file
- Publishes assets (CSS, JS)
- Creates storage link
- Runs available migrations
- Provides rollback on failure

### `php artisan cyberadmin:publish-assets`
Publishes all frontend assets to `public/vendor/cyberadmin`:
- CSS stylesheets
- JavaScript files

### `php artisan cyberadmin:publish-config`
Publishes configuration file to `config/cyberadmin.php`
- Use `--force` to overwrite existing configuration

---

## Manual Installation (If Needed)

If you prefer manual setup, you can use the individual commands:

```bash
# Install dependencies (if not using cyberadmin:install)
composer require livewire/livewire:^4.0

# Publish config
php artisan cyberadmin:publish-config

# Publish assets
php artisan cyberadmin:publish-assets

# Run migrations
php artisan migrate
```

---

## Features

✅ **Cyberpunk-themed UI** - Neon colors, glitch effects, futuristic design
✅ **Dual Theme System** - Dark/Light theme switcher (persists in session)
✅ **Multi-language Support** - English, Spanish, French (extensible)
✅ **Livewire 4** - Fully reactive components
✅ **Zero-Configuration Install** - Single command setup
✅ **Production-ready Pages**:
  - Dashboard with statistics and charts
  - User management
  - Reports management
  - Profile view and editing
  - Settings page with theme/language controls
✅ **Authentication Integration** - Works seamlessly with Laravel's default auth
✅ **Error Handling & Rollback** - Safe installation with failure recovery

---

## Configuration

After publishing the config file with `php artisan cyberadmin:publish-config`, you can customize:

- `route_prefix` - The URL prefix for the dashboard (default: `cyberadmin`)
- `middleware` - Middleware applied to all dashboard routes
- `enabled` - Enable/disable the entire dashboard

---

## Architecture

This package follows Laravel and Livewire best practices, inspired by the official Laravel Livewire Starter Kit:

- **Modular Livewire Components** - Each page is an independent Livewire component
- **Blade Layout System** - Reusable layouts and components
- **Session-based State** - Theme and language preferences stored in session
- **Database Integration** - Works with Laravel's default User model
- **Asset Management** - Properly scoped assets in `public/vendor/cyberadmin`

---

## Troubleshooting

**Assets not loading?**
- Run `php artisan cyberadmin:publish-assets`
- Ensure `public/storage` link exists (`php artisan storage:link`)

**Permission issues?**
- Ensure `storage` and `bootstrap/cache` directories are writable
- On Linux/Mac: `chmod -R 775 storage bootstrap/cache`

**Want to reset everything?**
- Delete `config/cyberadmin.php`
- Delete `public/vendor/cyberadmin`
- Re-run `php artisan cyberadmin:install`

---

## License

MIT
