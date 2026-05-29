# TODO

## Goal: Fix FatalError / Maximum execution time exceeded (30 seconds)

### Plan summary

- Root cause is likely an inefficient/buggy appointment overlap checking and slot generation logic causing long DB loops.

## Steps

1. Identify the exact heavy loop path in AvailabilityChecker / AppointmentController that can trigger timeouts.
2. Fix schema mismatch issues (appointments table may be missing columns used by logic: dentist_id, end_time, is_online_booking, etc.).
3. Optimize overlap queries:
    - Avoid N+1 Service::find inside loops.
    - Fetch required end times in one query or compute without extra DB hits.
    - Ensure queries are indexed/filtered correctly.
4. Add/adjust required migrations so the runtime code doesn’t compute missing columns (and queries stop scanning huge sets).
5. Run Laravel tests / quick smoke commands to confirm endpoints no longer time out.
6. Document any behavior changes.
7. If tests time out previously, re-run after availability checker changes.
