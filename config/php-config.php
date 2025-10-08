<?php
// PHP Configuration for Insolvency Data System
// This file ensures proper memory and execution limits for large file processing

// Memory and execution limits
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 600);
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');

// Error reporting
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// Session configuration
ini_set('session.gc_maxlifetime', 7200); // 2 hours
ini_set('session.cookie_lifetime', 7200);

// Output buffering
ini_set('output_buffering', 4096);

// Timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Log errors
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/storage/logs/php_errors.log');

// Configuration loaded silently
// echo "PHP Configuration loaded successfully!\n";
// echo "Memory limit: " . ini_get('memory_limit') . "\n";
// echo "Max execution time: " . ini_get('max_execution_time') . " seconds\n";
// echo "Upload max filesize: " . ini_get('upload_max_filesize') . "\n";
// echo "Post max size: " . ini_get('post_max_size') . "\n";
