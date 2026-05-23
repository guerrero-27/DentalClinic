# TODO

- [ ] Fix AvailabilityChecker overlap checks to use dentist_id and consider correct appointment statuses.
- [ ] Fix AvailabilityChecker slot generation/availability flags (end_time logic, lunch/clinic boundaries).
- [ ] Fix client create.blade.php JS so unavailable slots cannot be selected (remove event.target dependency; correct button click handling + selected state).
- [ ] Ensure server-side hard rejection in AppointmentController@store and @reschedule for overlaps even if client-side is bypassed.
- [ ] Run a quick syntax check / test compilation (php -l) for modified files.
