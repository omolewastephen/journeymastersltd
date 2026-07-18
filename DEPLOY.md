# Deploying Journey Masters Ltd to cPanel (Git Version Control)

## One-time setup

1. **Push this repo to GitHub** (done via the project setup).
2. In **cPanel → Git™ Version Control → Create**:
   - **Clone URL:** your repo URL
     - Public repo: `https://github.com/<you>/journeymastersltd.git`
     - Private repo: add cPanel's SSH key (cPanel → SSH Access → *Manage SSH Keys* → copy the public key) as a **Deploy key** on GitHub (repo → Settings → Deploy keys), then use the SSH URL `git@github.com:<you>/journeymastersltd.git`.
   - **Repository Path:** e.g. `repositories/journeymastersltd`
3. cPanel clones the repo. Because `.cpanel.yml` is present, click **Manage → Update from Remote** then **Deploy HEAD Commit** to publish.

## What the deploy does

`.cpanel.yml` copies:
- `public/*` → `public_html/` (front controller, assets, .htaccess)
- `app/`, `config/`, `database/` → `public_html/` (protected by per-folder `.htaccess` deny)
- creates writable `storage/` and `uploads/`
- creates `public_html/.env` from `.env.example` **once** (never overwritten on redeploys)

## After the first deploy

1. Edit `public_html/.env` on the server:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://journeymastersltd.com
   DB_ENABLED=true          # once the database is imported
   DB_NAME=..., DB_USER=..., DB_PASS=...
   MAIL_TO=inquiries@journeymastersltd.com
   ```
2. **Database:** cPanel → MySQL Databases (create db + user), then phpMyAdmin → Import `database/schema.sql`. Set `DB_ENABLED=true`.
3. **SSL:** enable AutoSSL, then uncomment the HTTPS redirect block in `public/.htaccess` (now `public_html/.htaccess`).
4. Confirm `PHP 8.1+` is selected in cPanel → MultiPHP Manager.

## Redeploying

Push to GitHub → in cPanel Git: **Update from Remote → Deploy HEAD Commit**. `.env`, `storage/` and `uploads/` are preserved.

## Local development

```
cp .env.example .env
php -S 127.0.0.1:8000 -t public public/index.php
# visit http://127.0.0.1:8000
```
The site runs fully on file-backed content until `DB_ENABLED=true`.
