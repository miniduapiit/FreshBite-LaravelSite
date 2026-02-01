# Building Vite Assets - Quick Fix

## Problem
The error `Vite manifest not found` occurs because the Vite assets haven't been built yet.

## Solution

### Step 1: Install Node.js (if not already installed)
- Download from https://nodejs.org/ (LTS version recommended)
- Or use Homebrew: `brew install node`

### Step 2: Install Dependencies
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/FreshBite/freshbite
npm install
```

### Step 3: Build Assets

**For Production:**
```bash
npm run build
```

**For Development (with hot reload):**
```bash
npm run dev
```
*(Keep this running in a separate terminal while developing)*

## Alternative: Use Composer Setup Script
You can also use the built-in setup script:
```bash
composer run setup
```
This will install npm dependencies and build assets automatically.

## After Building
Once you run `npm run build`, the `public/build/manifest.json` file will be created and the error will be resolved.
