# FreshBite Navigation Bar Documentation

## Overview

The FreshBite navigation bar is a responsive, modern navbar component designed for the public website. It provides easy navigation to all public pages and handles authentication state appropriately.

---

## File Location

- **Component:** `resources/views/components/public-header.blade.php`
- **Included in:** `resources/views/layouts/freshbite.blade.php`
- **Usage:** Automatically included in all pages using `@extends('layouts.freshbite')`

---

## Navigation Links

All navigation links are included and properly routed:

1. **Home** → `route('home')` → `/`
2. **About Us** → `route('about')` → `/about`
3. **Menu** → `route('menu')` → `/menu`
4. **Testimonials** → `route('testimonials')` → `/testimonials`
5. **Reservation** → `route('reservation')` → `/reservation`
6. **Contact** → `route('contact')` → `/contact`

---

## Authentication Buttons

### For Guests (Not Logged In)
- **Login Button:** Links to `route('login')`
  - Styled as a text link with hover effect
  - Shows on desktop and mobile

- **Register Button:** Links to `route('register')`
  - Styled as a green rounded button
  - Prominent call-to-action styling

### For Authenticated Users
- **Dashboard Button:** Links to `route('dashboard')`
  - Text link with hover effect
  - Provides quick access to user dashboard

- **Logout Button:** Submits POST request to `route('logout')`
  - Green rounded button
  - Uses CSRF protection
  - Properly logs user out

---

## Features

### ✅ Responsive Design
- **Desktop (lg and above):** Horizontal navigation with all links visible
- **Mobile/Tablet:** Hamburger menu that expands/collapses
- **Breakpoint:** `lg` (1024px) - switches between desktop and mobile views

### ✅ Active Route Highlighting
- Current page is highlighted with:
  - Green text color (`text-green-600`)
  - Green bottom border (`border-b-2 border-green-600`)
- Works for both desktop and mobile views

### ✅ Mobile Menu
- Hamburger icon that transforms to close icon when open
- Smooth expand/collapse animation
- All navigation links accessible
- Divider separates navigation from auth buttons
- Full-width buttons for better touch targets

### ✅ Styling
- **Background:** White with 95% opacity and backdrop blur
- **Shadow:** Subtle shadow for depth
- **Hover Effects:** Green color transitions on all interactive elements
- **Active States:** Visual feedback for current page
- **Buttons:** Rounded buttons with shadow effects

### ✅ Accessibility
- ARIA labels on mobile menu button
- ARIA expanded state management
- Semantic HTML structure
- Keyboard navigation support

---

## Component Structure

```
<header>
  ├── Logo (FreshBite with icon)
  ├── Desktop Navigation (lg+)
  │   ├── Home
  │   ├── About Us
  │   ├── Menu
  │   ├── Testimonials
  │   ├── Reservation
  │   └── Contact
  ├── Desktop Auth Buttons (lg+)
  │   ├── [Guest] Login + Register
  │   └── [Auth] Dashboard + Logout
  ├── Mobile Menu Button
  └── Mobile Menu (hidden on lg+)
      ├── All Navigation Links
      ├── Divider
      └── Auth Buttons
```

---

## Blade Directives Used

### Authentication Checks
```blade
@auth
    <!-- Show for authenticated users -->
@else
    <!-- Show for guests -->
@endauth
```

### Route Checks
```blade
@if (Route::has('login'))
    <!-- Show if login route exists -->
@endif

@if (Route::has('register'))
    <!-- Show if register route exists -->
@endif
```

### Active Route Detection
```blade
{{ request()->routeIs('home') ? 'text-green-600 border-b-2 border-green-600' : '' }}
```

---

## JavaScript Functionality

The navbar includes JavaScript for mobile menu toggle:

- Toggles mobile menu visibility
- Switches between hamburger and close icons
- Updates ARIA expanded attribute
- Smooth user experience

---

## Styling Details

### Colors
- **Primary:** Green (`green-600`, `green-700`)
- **Text:** Gray (`gray-700`, `gray-900`)
- **Background:** White with transparency (`bg-white/95`)
- **Hover:** Green accents (`hover:text-green-600`, `hover:bg-green-50`)

### Typography
- **Font Weight:** Medium (`font-medium`)
- **Font Size:** Responsive (base text sizes)

### Spacing
- **Height:** `h-20` (80px)
- **Padding:** Responsive (`px-4 sm:px-6 lg:px-8`)
- **Gaps:** `gap-4`, `gap-6`, `gap-8` for different sections

### Effects
- **Backdrop Blur:** `backdrop-blur-sm`
- **Shadow:** `shadow-md`
- **Transitions:** `transition-colors` on all interactive elements
- **Sticky:** `sticky top-0` - navbar stays at top when scrolling

---

## Integration

### Automatic Inclusion
The navbar is automatically included in the FreshBite layout:

```blade
<!-- resources/views/layouts/freshbite.blade.php -->
<header role="banner">
    <x-public-header />
</header>
```

### Manual Usage
If needed, you can include it manually in any Blade view:

```blade
<x-public-header />
```

---

## Responsive Breakpoints

| Screen Size | Navigation Style |
|-------------|------------------|
| **Mobile (< 1024px)** | Hamburger menu, vertical navigation |
| **Desktop (≥ 1024px)** | Horizontal navigation, all links visible |

---

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)
- Responsive design tested on various screen sizes

---

## Testing Checklist

- [x] All navigation links work correctly
- [x] Active route highlighting works
- [x] Login/Register buttons show for guests
- [x] Dashboard/Logout buttons show for authenticated users
- [x] Mobile menu toggles correctly
- [x] Mobile menu closes when link is clicked
- [x] Logout functionality works
- [x] Responsive design works on all screen sizes
- [x] Hover effects work properly
- [x] Accessibility features implemented

---

## Summary

The FreshBite navigation bar provides:

✅ **Complete Navigation** - All 6 required links  
✅ **Authentication Handling** - Conditional buttons based on auth state  
✅ **Responsive Design** - Works on all devices  
✅ **Modern Styling** - Clean Tailwind CSS design  
✅ **Active States** - Visual feedback for current page  
✅ **Accessibility** - ARIA labels and keyboard support  
✅ **Integrated** - Automatically included in FreshBite layout  

The navbar is production-ready and provides an excellent user experience for both desktop and mobile users.

---

**Documentation Created:** {{ date('Y-m-d') }}  
**Component Version:** 1.0.0  
**Laravel Version:** 12.46.0
