#!/bin/bash

# Start Laravel development server with increased memory limits
# This script ensures the server runs with sufficient memory for large file uploads

echo "Starting Laravel development server with increased memory limits..."
echo "Memory limit: 1024M"
echo "Server will be available at: http://127.0.0.1:8000"
echo ""

# Kill any existing server processes
pkill -f "php artisan serve" 2>/dev/null

# Start the server with increased memory limit
php -d memory_limit=1024M artisan serve --host=127.0.0.1 --port=8000
