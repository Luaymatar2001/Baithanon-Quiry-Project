# TODO - Member Requests feature

## Step 1: Create migration
- Create migration: `create_member_requests_table`
- Columns per spec (including enum status default pending, review fields, and nullable file paths)

## Step 2: Create MemberRequest model
- `app/Models/MemberRequest.php`
- Fillable fields + casts for status/dates

## Step 3: Create MemberRequestController
- `store()` validates + stores uploads + creates pending record only in `member_requests`
- `pending/accepted/rejected` page methods
- `accept()` and `reject()` to update review fields

## Step 4: Add routes
- Add routes only (no existing route changes besides adding new ones)
- Add `member-requests.store` POST endpoint
- Add dashboard routes and accept/reject routes

## Step 5: Update popup form action ONLY
- In `resources/views/livewire/household-details.blade.php`
- Change popup form `action` from `route('addRowMember')` to `route('member-requests.store')`
- No other behavior changes

## Step 6: Dashboard views
- Create 3 views under `resources/views/Dashboard/member-requests/`
  - pending, accepted, rejected
- Pending view: accept/reject actions

## Step 7: Dashboard navigation link
- Edit only the dashboard navigation/layout to add link “Member Requests”
- Do not change existing links behavior

## Step 8: Run migration and manual test
- `php artisan migrate`
- Submit popup for relation=ابن/ابنه and relation=زوجة
- Verify: only member_requests rows created, never partner/children
- Verify review transitions from dashboard

