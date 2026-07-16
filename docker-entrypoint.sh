#!/bin/bash
set -e

# Turn off conflicting Apache modules that Railway injects
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true

# Force only PHP's module to run
a2enmod mpm_prefork 2>/dev/null || true

# Enable Apache header module (needed to handle proxy headers)
a2enmod headers 2>/dev/null || true

# Force Apache to tell Laravel that the traffic came in securely over HTTPS
echo "RequestHeader set X-Forwarded-Proto 'https'" >> /etc/apache2/apache2.conf

# Point Apache to Railway's assigned port (defaults to 80 if not set)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/*.conf

# Clear and optimize Laravel config/routes for production
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start Apache normally
exec apache2-foreground