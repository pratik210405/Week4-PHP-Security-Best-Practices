WEEK 4 SECURITY PATCH — PHP CRUD

Your current public repository already documents prepared statements for INSERT/UPDATE/DELETE,
htmlspecialchars() output escaping, and basic email validation. This patch adds reusable
security helpers for HTML escaping, CSRF tokens, and safer session cookie settings.

IMPORTANT: Uploading this helper alone does not automatically secure every page. Integrate it:
1. Back up your repository first.
2. Add security.php to the project root.
3. On pages that process forms, include security.php before any HTML output.
4. Add a hidden CSRF field inside each POST form:
   <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
5. At the start of each POST handler, call verify_csrf_token(); reject invalid requests with HTTP 403.
6. Continue to use prepared statements and e()/htmlspecialchars() for all untrusted output.
7. Check phone/name/department lengths and formats server-side.
8. Do not show raw database errors to users; log details privately instead.
9. Test add, view, edit and delete; test invalid email, blank fields, HTML/script-like input,
   and a missing/incorrect CSRF token.

The report is a project report/template. Only describe a check as passed after you actually run it.
