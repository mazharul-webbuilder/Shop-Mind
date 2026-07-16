# ShopMind Production Deployment Guide

This document explains the complete infrastructure setup for running the ShopMind Laravel application on Railway using Apache. It keeps your core PHP application code completely separate from server-level configurations.

---

## 1. Required Railway Environment Variables

Configure these variables inside your [Railway Variables Tab](https://railway.com/project/5804e915-4415-4ddb-adc6-3abe502a5658/service/dedeef81-844f-48ed-810a-e2665eb8c863/variables?environmentId=3293c6fe-4e7b-414f-93b5-fdc98415a1c7):

| Variable Name | Required Value | Purpose & Explanation |
| :--- | :--- | :--- |
| `APP_ENV` | `production` | Tells Laravel it is running in a live production environment. |
| `APP_URL` | `https://shop-mind-production.up.railway.app` | **CRITICAL:** The live secure address of your application. Do not include trailing slashes `/`, brackets `[ ]`, or parentheses `( )`. This must be a clean string. |
| `TRUSTED_PROXIES` | `*` | Tells Laravel to trust the secure SSL headers forwarded by Railway's outer router. Without this, Laravel will ignore HTTPS headers and default back to HTTP. |

### ⚠️ The Asset Rule (Do NOT use ASSET_URL)
* **What to do:** Delete or leave the `ASSET_URL` variable completely blank. 
* **Why:** If `ASSET_URL` is empty, Laravel automatically builds relative paths (like `/build/assets/app.css`). Relative paths are completely safe and dynamically inherit the secure protocol from the browser request.

---

## 2. Docker & Web Server Configuration

To run Apache successfully on Railway's hosting environment, your configuration files must adapt dynamically to Railway's assigned ports and SSL structure.

### A. Dockerfile (`Dockerfile.prod`)
Make sure your production Dockerfile points Apache's default virtual host mapping to your Laravel `/public` folder instead of the default `/var/www/html` folder.

```dockerfile
# Tells Apache to serve files from the Laravel public directory
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf