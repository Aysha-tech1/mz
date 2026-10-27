# Admin Dashboard Guide

## Accessing the Admin Dashboard

1. **URL**: `http://localhost:8000/admin`
2. **Login Credentials**:
   - Email: `admin@example.com`
   - Password: `password`

## Features Available

### 1. Consultation Types Management
- View all consultation types
- Create new consultation types
- Edit existing types (title, duration, price, active status)
- Delete consultation types

### 2. Availability Management
- View all available time slots
- Create new time slots
- Edit availability (date, start time, end time, booked status)
- Delete time slots
- Filter by date and status

### 3. Bookings Management
- View all booking requests
- Create new bookings
- Edit booking details
- Update booking status (pending, confirmed, cancelled)
- Delete bookings
- View consultation type for each booking

## Database Seeding

To seed the database with sample data:

```bash
php artisan db:seed
```

This will create:
- 3 consultation types (30 min, 60 min, 90 min)
- Time slots for the next 30 days (excluding Fridays)
- Admin user account
- Sample bookings

## Calendar Features

The frontend calendar on the homepage includes:
- **Step 1**: Select consultation type
- **Step 2**: Interactive calendar with month navigation
  - Only available dates are clickable
  - Days with no availability are grayed out
  - Friday is automatically excluded
- **Step 3**: Select time slot for chosen date
- **Step 4**: Enter contact details and submit booking

## Tech Stack

- **Backend**: Laravel 12 with Filament 5.10 for admin panel
- **Frontend**: Alpine.js for interactivity, TailwindCSS 4 for styling
- **Database**: MySQL with proper relationships and foreign keys

## Customization

### Modify Time Slots
Edit `database/seeders/AvailabilitySeeder.php` to change available time slots.

### Modify Consultation Types
Edit `database/seeders/ConsultationTypeSeeder.php` to add or modify consultation types.

### Change Admin Credentials
Edit `database/seeders/AdminUserSeeder.php` to change the admin email and password.
