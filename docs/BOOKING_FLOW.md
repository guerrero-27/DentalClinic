# Appointment Booking Flow

## Overview
Patient online booking system para sa dental clinic. Ang user ay dapat logged in bago makagawa ng appointment.

---

## User Flow

```
Landing Page → Login/Register → Client Dashboard → Book Appointment
                                                   ↓
                                          Select Service
                                                   ↓
                                          Select Dentist
                                                   ↓
                                          Select Date
                                                   ↓
                                          Choose Time Slot (AJAX)
                                                   ↓
                                          Confirm Booking
                                                   ↓
                                    Success / Error Message
```

---

## Step-by-Step Process

### Step 1: Access Booking Page
- User navigates to `/client/appointments/create`
- System loads active services and available dentists

### Step 2: Fill Booking Form
- **Service**: Required. Dropdown ng mga active services.
- **Dentist**: Required. Dropdown ng mga active dentists.
- **Date**: Required. Date picker (default: tomorrow). Hindi pwede ang past dates.
- **Time**: Required. Auto-populated based sa service duration pag nag-change ng dentist/date.

### Step 3: Select Time Slot (AJAX)
- User selects service + dentist + date
- System calls `/client/appointments/slots` (GET)
- Returns available time slots based sa:
  - Service duration + buffer time
  - Clinic hours (9 AM - 5 PM)
  - Lunch break (12 PM - 1 PM)
  - Existing bookings ng dentist sa araw na yon

### Step 4: Submit Booking
- User clicks "Book Appointment"
- System validates lahat ng inputs

### Step 5: Server-Side Validation
1. **Service exists & is_active**
2. **Dentist exists, is_active, and role = dentist**
3. **Date is today or future**
4. **Time is within clinic hours**
5. **Time does not overlap lunch break**
6. **Time does not overlap existing booking** ← DOUBLE-BOOKING CHECK
7. **Time is not in the past** (if booking for today)

### Step 6: Create Appointment
- Status: `pending`
- is_online_booking: `true`
- User redirected to appointments list with success message

---

## Validation Rules

| Field | Rules |
|-------|-------|
| service_id | Required, must exist, must be active |
| dentist_id | Required, must exist, must be active, role = dentist |
| appointment_date | Required, must be today or future |
| appointment_time | Required, within clinic hours, not during lunch |
| notes | Optional, max 500 characters |

---

## Double-Booking Prevention

### How it works:
- Before saving, system checks kung may existing appointment yung dentist sa same date/time
- Uses `AvailabilityChecker::checkOverlap()` method
- Checks only `pending` and `confirmed` statuses (ignores `cancelled`)

### Overlap Logic:
```
New slot overlaps if:
- New Start < Existing End AND New End > Existing Start
```

### Error Message:
> "This schedule is already booked. Please choose another time."

---

## Schedule Conflict Scenarios

| Scenario | Result |
|----------|--------|
| Exact same time, same dentist | ❌ Blocked |
| New booking starts during existing | ❌ Blocked |
| New booking ends during existing | ❌ Blocked |
| New booking contains existing | ❌ Blocked |
| Different dentist, same time | ✅ Allowed |
| Same dentist, different time slot | ✅ Allowed |
| Existing is cancelled | ✅ Allowed |

---

## API Endpoints

### GET /client/appointments/slots
Get available time slots for a dentist on a specific date.

**Parameters:**
- `service_id` (required)
- `date` (required) - YYYY-MM-DD format
- `dentist_id` (required)

**Response:**
```json
{
  "slots": [
    {
      "time": "09:00",
      "formatted": "9:00 AM",
      "available": true,
      "reason": null
    },
    {
      "time": "09:15",
      "formatted": "9:15 AM",
      "available": false,
      "reason": "Already booked"
    }
  ]
}
```

---

## File Locations

| Purpose | File |
|---------|------|
| Controller | `app/Http/Controllers/Client/AppointmentController.php` |
| Availability Logic | `app/Services/AvailabilityChecker.php` |
| Validation Rule | `app/Rules/NoDoubleBooking.php` |
| Model (with overlap scope) | `app/Models/Appointment.php` |
| Booking Form View | `resources/views/client/appointments/create.blade.php` |
| Slots API | `Client/AppointmentController::getSlots()` |

---

## Database Tables Involved

### appointments
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key → users.id (patient) |
| service_id | bigint | Foreign key → services.id |
| dentist_id | bigint | Foreign key → users.id |
| appointment_date | date | YYYY-MM-DD |
| appointment_time | time | HH:MM:SS |
| end_time | time | Computed: start + duration + buffer |
| status | enum | pending, confirmed, completed, cancelled |
| notes | text | Patient notes (optional) |
| is_online_booking | boolean | True if booked via portal |

### Indexes for Performance
- `idx_dentist_date_status` - speeds up dentist/date lookups
- `idx_appointment_datetime` - speeds up time range queries

---

## Status Flow

```
pending → confirmed → completed
    ↓          ↓
  cancelled  cancelled

Any transition to cancelled is allowed except from completed.
```

---

## Error Messages

| Error | Message |
|-------|---------|
| Service not available | "Service is not available" |
| Dentist not available | "Dentist is not available" |
| Past date | "The selected date must be a date after or equal to today." |
| Outside clinic hours | "Appointments must be within clinic hours (9 AM - 5 PM)." |
| Lunch overlap | "Appointments cannot be during lunch break (12 PM - 1 PM)." |
| Double booking | "This schedule is already booked. Please choose another time." |
| Past time (same day) | "Cannot book in the past." |

---

## Testing Checklist

- [ ] Book appointment successfully
- [ ] Block duplicate for same dentist/date/time
- [ ] Block overlap (start during existing)
- [ ] Block overlap (end during existing)
- [ ] Allow different dentist same time
- [ ] Allow same dentist different time
- [ ] Allow booking after cancelled appointment
- [ ] Block past dates
- [ ] Block lunch hour bookings
- [ ] Block outside clinic hours
- [ ] AJAX slot loading works correctly