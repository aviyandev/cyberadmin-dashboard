# CyberAdmin Dashboard

A cyberpunk-themed Laravel admin dashboard package built with Livewire 4 and Fortify, featuring 100% automated zero-configuration installation!

## 🚀 Three Simple Steps to Get Started!

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

**That's it! Your dashboard is ready!** Visit `/cyberadmin` in your browser! 🎉

---

## 📦 What the Install Command Does Automatically

The single `cyberadmin:install` command handles **everything**:
1. ✅ Checks/installs Livewire 4 and Fortify
2. ✅ Publishes all configuration files
3. ✅ Publishes all authentication views
4. ✅ Publishes all frontend assets
5. ✅ Creates storage link
6. ✅ Runs all database migrations
7. ✅ Sets up complete authentication system

---

## 🛠️ Available Artisan Commands

### `php artisan cyberadmin:install` (⭐ Main Command)
Complete one-click installation - **the only command you need!**

### `php artisan cyberadmin:publish-assets`
Publishes frontend assets to `public/vendor/cyberadmin`

### `php artisan cyberadmin:publish-config`
Publishes configuration to `config/cyberadmin.php` (use `--force` to overwrite)

---

## ✨ Features

- 🎨 **Cyberpunk-themed UI** - Neon colors, glitch effects, futuristic design
- 🌓 **Dual Theme System** - Dark/Light switcher (session-based)
- 🌍 **Multi-language Support** - English, Spanish, French
- ⚡ **Livewire 4** - Fully reactive components
- 🔐 **Authentication Included** - Powered by Laravel Fortify
- 📊 **Production-ready Pages**:
  - Dashboard with stats/charts
  - User management
  - Reports management
  - Profile view/edit
  - Settings page
- 🛡️ **Error Handling & Rollback** - Safe installation with failure recovery
- 📦 **Zero Configuration** - One command setup!

---

## ⚙️ Configuration

Publish config file to customize (optional):
```bash
php artisan cyberadmin:publish-config
```

Customizable options in `config/cyberadmin.php`:
- `route_prefix` - Dashboard URL prefix (default: `cyberadmin`)
- `middleware` - Middleware for all dashboard routes
- `enabled` - Toggle entire dashboard

---

## 🏗️ Architecture

Built following Laravel & Livewire best practices (like Laravel's official starter kits):
- **Modular Livewire Components** - Each page as independent Livewire component
- **Blade Layout System** - Reusable layouts/components
- **Session-based State** - Theme/language in session
- **Fortify Authentication** - No Laravel UI used!
- **Proper Asset Scoping** - All assets in `public/vendor/cyberadmin`

---

## 🚨 Troubleshooting

**Assets not loading?**
```bash
php artisan cyberadmin:publish-assets
php artisan storage:link
```

**Permissions?**
- Ensure `storage/` and `bootstrap/cache/` are writable
- Linux/Mac: `chmod -R 775 storage bootstrap/cache`

**Reset everything?**
- Delete `config/cyberadmin.php` and `config/fortify.php`
- Delete `public/vendor/cyberadmin`
- Delete `resources/views/auth`
- Re-run `php artisan cyberadmin:install`

---

## 📝 License

MIT
