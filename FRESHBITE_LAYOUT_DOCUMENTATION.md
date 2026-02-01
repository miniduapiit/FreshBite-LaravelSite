# FreshBite Layout Documentation

## Overview

The FreshBite layout (`resources/views/layouts/freshbite.blade.php`) is a dedicated, reusable Blade layout designed specifically for all public-facing pages of the FreshBite website. It is completely separate from Jetstream layouts and provides a consistent structure for the public website.

---

## Layout Structure

### File Location
- **Layout:** `resources/views/layouts/freshbite.blade.php`
- **Header Component:** `resources/views/components/public-header.blade.php`
- **Footer Component:** `resources/views/components/public-footer.blade.php`

### Layout Components

```
┌─────────────────────────────────────┐
│         Header (Navbar)             │
│    <x-public-header />              │
├─────────────────────────────────────┤
│                                     │
│      Main Content Area              │
│      @yield('content')              │
│                                     │
├─────────────────────────────────────┤
│         Footer                      │
│    <x-public-footer />              │
└─────────────────────────────────────┘
```

---

## Key Features

### ✅ Semantic HTML
- Uses proper HTML5 semantic elements (`<header>`, `<main>`, `<footer>`)
- Includes ARIA roles for accessibility (`role="banner"`, `role="main"`, `role="contentinfo"`)
- Skip-to-content link for keyboard navigation

### ✅ Tailwind CSS Styling
- All styling uses Tailwind utility classes
- No inline CSS styles
- Consistent spacing and design system
- Responsive design built-in

### ✅ Scalable Architecture
- Modular component-based structure
- Easy to extend with additional sections
- Supports `@stack` directives for additional scripts/styles
- Supports `@yield` for page-specific content

### ✅ Separation from Jetstream
- Completely independent layout system
- No Jetstream dependencies
- Uses public header/footer components
- No authentication UI components

---

## Usage Example

### Basic Page Structure

```blade
@extends('layouts.freshbite')

@section('title', 'Page Title')
@section('description', 'Page description for SEO')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-6">Page Title</h1>
        <p class="text-gray-600">Page content goes here...</p>
    </div>
@endsection
```

### With Additional Scripts

```blade
@extends('layouts.freshbite')

@section('content')
    <!-- Your content -->
@endsection

@push('scripts')
<script>
    // Page-specific JavaScript
</script>
@endpush
```

### With Custom Head Content

```blade
@extends('layouts.freshbite')

@push('head')
<meta property="og:title" content="Page Title">
<meta property="og:description" content="Page Description">
@endpush

@section('content')
    <!-- Your content -->
@endsection
```

---

## Layout Sections

### Available Sections

1. **`@section('title')`** - Page title (appears in `<title>` tag)
   - Default: `config('app.name', 'FreshBite')`
   - Format: `{Page Title} - {App Name}`

2. **`@section('description')`** - Meta description for SEO
   - Default: Generic FreshBite description

3. **`@section('content')`** - Main page content (required)
   - Rendered in `<main>` element

### Available Stacks

1. **`@stack('head')`** - Additional head content (meta tags, styles, etc.)
2. **`@stack('scripts')`** - Additional JavaScript (placed before `</body>`)

---

## Differences from Jetstream Layouts

### FreshBite Layout vs. Jetstream App Layout

| Feature | FreshBite Layout | Jetstream App Layout |
|---------|------------------|----------------------|
| **Purpose** | Public website pages | Authenticated dashboard pages |
| **Header** | Public navigation (`<x-public-header />`) | Jetstream navigation menu (`@livewire('navigation-menu')`) |
| **Footer** | Public footer with links, contact info | No footer |
| **Authentication** | Not required | Required (protected by middleware) |
| **Banner** | No banner | Jetstream banner component (`<x-banner />`) |
| **Background** | Light gray (`bg-gray-50`) | Gray (`bg-gray-100`) |
| **Livewire** | Optional (for public components) | Required (for navigation, modals) |
| **Content Structure** | Simple `@yield('content')` | Complex with header slots, modals stack |
| **Styling** | Public-facing, marketing-focused | Dashboard-focused, admin-style |

### FreshBite Layout vs. Guest Layout

| Feature | FreshBite Layout | Guest Layout |
|---------|------------------|--------------|
| **Structure** | Full layout (header, main, footer) | Minimal wrapper |
| **Header** | Public navigation component | None (pages define their own) |
| **Footer** | Public footer component | None |
| **Purpose** | Complete public website pages | Simple guest pages (login, register) |
| **Styling** | Full Tailwind utility classes | Minimal styling |

---

## Component Breakdown

### Header Component (`<x-public-header />`)

**Location:** `resources/views/components/public-header.blade.php`

**Features:**
- FreshBite logo (links to home)
- Navigation menu (Home, About, Menu, Testimonials, Reservation)
- Conditional navigation based on auth status:
  - **Guests:** Search, Login, Register, Contact Us
  - **Authenticated:** Dashboard, Profile, Contact Us
- Mobile-responsive hamburger menu
- Sticky positioning with backdrop blur

### Footer Component (`<x-public-footer />`)

**Location:** `resources/views/components/public-footer.blade.php`

**Features:**
- Company information and description
- Quick links to all public pages
- Contact information (address, phone, email)
- Social media links (Facebook, Twitter, Instagram)
- Newsletter subscription form
- Copyright and legal links
- Responsive grid layout

---

## Styling Guidelines

### Background Colors
- **Body:** `bg-gray-50` (light gray background)
- **Header:** `bg-white/90 backdrop-blur-sm` (semi-transparent white with blur)
- **Footer:** `bg-gray-900` (dark background)

### Spacing
- Use Tailwind spacing utilities (`py-12`, `px-4`, `gap-8`, etc.)
- Consistent max-width container: `max-w-7xl mx-auto`
- Responsive padding: `px-4 sm:px-6 lg:px-8`

### Typography
- Font family: `font-sans` (Figtree from Google Fonts)
- Base text: `text-gray-900` for headings, `text-gray-600` for body
- Font weights: `font-medium`, `font-semibold`, `font-bold`

### Responsive Design
- Mobile-first approach
- Breakpoints: `sm:`, `md:`, `lg:`, `xl:`
- Grid layouts adapt to screen size

---

## Accessibility Features

1. **Semantic HTML:** Proper use of `<header>`, `<main>`, `<footer>`
2. **ARIA Roles:** `role="banner"`, `role="main"`, `role="contentinfo"`
3. **Skip Link:** "Skip to main content" link for keyboard navigation
4. **Screen Reader Support:** Proper heading hierarchy and alt text
5. **Keyboard Navigation:** All interactive elements are keyboard accessible

---

## Migration Guide

### Converting Existing Public Pages

**Before (using guest layout):**
```blade
<x-guest-layout>
    <x-public-header />
    <!-- Content -->
</x-guest-layout>
```

**After (using FreshBite layout):**
```blade
@extends('layouts.freshbite')

@section('content')
    <!-- Content (header and footer included automatically) -->
@endsection
```

### Benefits of Migration

1. **Consistency:** All pages use the same layout structure
2. **Maintainability:** Update header/footer in one place
3. **SEO:** Better meta tag management with `@section('title')` and `@section('description')`
4. **Cleaner Code:** No need to include header/footer in every page
5. **Scalability:** Easy to add new sections or modify layout

---

## File Structure

```
resources/views/
├── layouts/
│   ├── freshbite.blade.php      ← Main FreshBite layout
│   ├── app.blade.php            ← Jetstream authenticated layout
│   └── guest.blade.php          ← Simple guest layout
└── components/
    ├── public-header.blade.php  ← Public navigation header
    └── public-footer.blade.php  ← Public footer
```

---

## Best Practices

1. **Always use `@section('content')`** for main page content
2. **Set page titles** using `@section('title')` for better SEO
3. **Add meta descriptions** using `@section('description')`
4. **Use semantic HTML** within content sections
5. **Leverage Tailwind utilities** instead of custom CSS
6. **Keep content responsive** using Tailwind responsive classes
7. **Use `@stack` for page-specific scripts/styles** when needed

---

## Example: Complete Page

```blade
@extends('layouts.freshbite')

@section('title', 'About Us')
@section('description', 'Learn about FreshBite - our story, values, and commitment to delivering fresh, delicious meals.')

@section('content')
    <section class="bg-gradient-to-br from-green-50 via-yellow-50 to-green-100 min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    About <span class="text-green-600">FreshBite</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're passionate about bringing you the freshest, most delicious food experience
                </p>
            </div>
            
            <!-- Page content continues... -->
        </div>
    </section>
@endsection
```

---

## Summary

The FreshBite layout provides:

✅ **Complete separation** from Jetstream layouts  
✅ **Consistent structure** for all public pages  
✅ **Semantic HTML** with accessibility features  
✅ **Tailwind CSS** styling (no inline CSS)  
✅ **Scalable architecture** with components and stacks  
✅ **SEO-friendly** with title and description sections  
✅ **Responsive design** built-in  

This layout ensures all public FreshBite pages have a consistent look and feel while remaining completely independent from the authenticated Jetstream dashboard system.

---

**Documentation Created:** {{ date('Y-m-d') }}  
**Laravel Version:** 12.46.0  
**Layout Version:** 1.0.0
