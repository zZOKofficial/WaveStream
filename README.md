<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

---

# Music Admin Dashboard

A slick and minimal **Admin Panel** to manage users, songs, and everything behind your music platform. Built with **Laravel**, **Blade**, and **Bootstrap 5** with a full dark theme and responsive layout.

---

## Features

- Admin login, logout, and profile
- User management: list, edit, delete
- Music management: upload, edit, delete songs
- Dashboard with alerts for success/errors
- Font Awesome icons for a sleek UI
- Sidebar navigation with active route highlights
- Fully responsive (mobile-first)

---

## Tech Stack

- **Framework:** Laravel 10+
- **Frontend:** Blade, Bootstrap 5, Font Awesome 6
- **Database:** MySQL
- **Authentication:** Laravel Breeze / Sanctum *(optional)*

---

## Installation

```bash
git clone https://github.com/yourusername/music-admin-dashboard.git
cd music-admin-dashboard

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate