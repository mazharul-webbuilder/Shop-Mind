#!/bin/bash
set -e

# Turn off conflicting Apache modules that Railway injects
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true

# Force only PHP's module to run
a2enmod mpm_prefork 2>/dev/null || true

# Start Apache normally
exec apache2-foreground