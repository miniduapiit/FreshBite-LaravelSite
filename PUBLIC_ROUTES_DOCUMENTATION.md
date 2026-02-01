# Public Website Routes Documentation

## Overview
This document outlines all public (guest-facing) routes for the FreshBite food ordering system. All routes listed below are accessible **WITHOUT authentication**.

---

## Public Routes

### 1. Home Page
- **Route:** `GET /`
- **Route Name:** `home`
- **View:** `resources/views/welcome.blade.php`
- **Description:** Main landing page with hero banner, features, and call-to-action sections
- **Access:** Public (No authentication required)
- **Navigation:** Clicking "Dashboard" in header redirects authenticated users to `/dashboard`

### 2. About Us Page
- **Route:** `GET /about`
- **Route Name:** `about`
- **View:** `resources/views/public/about.blade.php`
- **Description:** Information about FreshBite, company story, values, and mission
- **Access:** Public (No authentication required)

### 3. Menu Page
- **Route:** `GET /menu`
- **Route Name:** `menu`
- **Controller:** `ProductController@index`
- **View:** Uses existing products index view
- **Description:** Displays all available menu items/products
- **Access:** Public (No authentication required)
- **Note:** This route uses the same controller as `/products` but provides a cleaner URL for the public menu

### 4. Testimonials Page
- **Route:** `GET /testimonials`
- **Route Name:** `testimonials`
- **View:** `resources/views/public/testimonials.blade.php`
- **Description:** Customer reviews and testimonials with ratings
- **Access:** Public (No authentication required)

### 5. Reservation Page
- **Route:** `GET /reservation`
- **Route Name:** `reservation`
- **View:** `resources/views/public/reservation.blade.php`
- **Description:** Form to make table reservations with date/time selection
- **Access:** Public (No authentication required)
- **Note:** Form submission handler needs to be implemented

### 6. Contact Page
- **Route:** `GET /contact`
- **Route Name:** `contact`
- **View:** `resources/views/public/contact.blade.php`
- **Description:** Contact form and business information (address, phone, email, hours)
- **Access:** Public (No authentication required)
- **Note:** Form submission handler needs to be implemented

---

## Additional Public Routes

### Product Routes
- **Route:** `GET /products`
- **Route Name:** `products.index`
- **Controller:** `ProductController@index`
- **Description:** Public product listing page

- **Route:** `GET /products/{slug}`
- **Route Name:** `products.show`
- **Controller:** `ProductController@show`
- **Description:** Individual product detail page

---

## Protected Routes (Require Authentication)

### Dashboard
- **Route:** `GET /dashboard`
- **Route Name:** `dashboard`
- **Middleware:** `auth:sanctum`, `verified`
- **View:** `resources/views/dashboard.blade.php`
- **Description:** Jetstream dashboard for authenticated users
- **Access:** Requires authentication
- **Behavior:** 
  - Logged-out users attempting to access are redirected to login
  - Authenticated users clicking "Dashboard" in navigation are taken here

---

## Route Definitions in `routes/web.php`

```php
// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About Us Page
Route::get('/about', function () {
    return view('public.about');
})->name('about');

// Menu Page (using products as menu items)
Route::get('/menu', [ProductController::class, 'index'])->name('menu');

// Testimonials Page
Route::get('/testimonials', function () {
    return view('public.testimonials');
})->name('testimonials');

// Reservation Page
Route::get('/reservation', function () {
    return view('public.reservation');
})->name('reservation');

// Contact Page
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

// Public product routes (for detailed product views)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ============================================
// PROTECTED ROUTES (Require Authentication)
// ============================================

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
```

---

## Files Created/Modified

### Created Files:
1. `resources/views/components/public-header.blade.php` - Reusable header component for all public pages
2. `resources/views/public/about.blade.php` - About Us page
3. `resources/views/public/testimonials.blade.php` - Testimonials page
4. `resources/views/public/reservation.blade.php` - Reservation page
5. `resources/views/public/contact.blade.php` - Contact page

### Modified Files:
1. `routes/web.php` - Added all public route definitions
2. `resources/views/welcome.blade.php` - Updated to use shared header component

---

## Navigation Structure

All public pages use the `<x-public-header />` component which provides:
- **Logo:** Links to home page
- **Navigation Links:** Home, About Us, Menu, Testimonials, Reservation
- **Right Side Actions:**
  - **For Guests:** Search icon, Login link, Register button, Contact Us button
  - **For Authenticated Users:** Dashboard link, Profile link, Contact Us button
- **Mobile Menu:** Responsive navigation for mobile devices

---

## Key Features

### ✅ All Public Routes Are Accessible Without Authentication
- No middleware applied to public routes
- Guests can browse all pages freely

### ✅ Dashboard Remains Protected
- `/dashboard` route requires authentication
- Uses Jetstream middleware (`auth:sanctum`, `verified`)
- Redirects unauthenticated users to login

### ✅ Consistent Navigation
- All public pages share the same header component
- Active route highlighting in navigation
- Mobile-responsive menu

### ✅ No Jetstream Core Files Modified
- Only application views and routes modified
- Jetstream functionality remains intact

---

## Testing Checklist

- [x] Home page (`/`) accessible to guests
- [x] About page (`/about`) accessible to guests
- [x] Menu page (`/menu`) accessible to guests
- [x] Testimonials page (`/testimonials`) accessible to guests
- [x] Reservation page (`/reservation`) accessible to guests
- [x] Contact page (`/contact`) accessible to guests
- [x] Dashboard (`/dashboard`) requires authentication
- [x] Navigation links work correctly
- [x] Authenticated users see Dashboard link
- [x] Guests see Login/Register links
- [x] Mobile menu functions properly

---

## Next Steps (Future Implementation)

1. **Form Handlers:**
   - Implement reservation form submission handler
   - Implement contact form submission handler

2. **Email Notifications:**
   - Send confirmation emails for reservations
   - Send notification emails for contact form submissions

3. **Database Integration:**
   - Store reservations in database
   - Store contact form submissions in database

4. **Admin Panel:**
   - Add admin interface to manage reservations
   - Add admin interface to view contact submissions

---

## Route Summary Table

| Route | Method | Name | View/Controller | Auth Required |
|-------|--------|------|-----------------|---------------|
| `/` | GET | `home` | `welcome.blade.php` | ❌ No |
| `/about` | GET | `about` | `public.about` | ❌ No |
| `/menu` | GET | `menu` | `ProductController@index` | ❌ No |
| `/testimonials` | GET | `testimonials` | `public.testimonials` | ❌ No |
| `/reservation` | GET | `reservation` | `public.reservation` | ❌ No |
| `/contact` | GET | `contact` | `public.contact` | ❌ No |
| `/products` | GET | `products.index` | `ProductController@index` | ❌ No |
| `/products/{slug}` | GET | `products.show` | `ProductController@show` | ❌ No |
| `/dashboard` | GET | `dashboard` | `dashboard.blade.php` | ✅ Yes |

---

**Documentation Created:** {{ date('Y-m-d') }}
**Laravel Version:** 12.46.0
**Jetstream Version:** 5.4
