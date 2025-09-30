#!/bin/bash

# Start Laravel development server with increased memory limits
# This script ensures the server runs with sufficient memory for large file uploads

echo "Starting Laravel development server with increased memory limits..."
echo "Memory limit: 1024M"
echo "Max execution time: 600 seconds"
echo "Upload max filesize: 50M"
echo "Server will be available at: http://127.0.0.1:8000"
echo ""

# Kill any existing server processes
pkill -f "php artisan serve" 2>/dev/null

# Load PHP configuration
if [ -f "config/php-config.php" ]; then
    echo "Loading PHP configuration..."
    php config/php-config.php
    echo ""
fi

# Start the server with increased memory limit and other optimizations
php -d memory_limit=1024M \
    -d max_execution_time=600 \
    -d upload_max_filesize=50M \
    -d post_max_size=50M \
    artisan serve --host=127.0.0.1 --port=8000
