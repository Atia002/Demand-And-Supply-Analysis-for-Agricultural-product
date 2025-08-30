<?php
// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path constants
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

function serveFile($filePath, $contentType = null) {
    if (file_exists($filePath)) {
        if ($contentType) {
            header("Content-Type: $contentType");
        }
        readfile($filePath);
        return true;
    }
    return false;
}

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/Demand-And-Supply-Analysis-for-Agricultural-product/';

// Remove base path from URI if present
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Remove query string
$request_uri = strtok($request_uri, '?');

// Try to serve static files first
$static_file = PUBLIC_PATH . '/' . $request_uri;
if (file_exists($static_file)) {
    $ext = pathinfo($static_file, PATHINFO_EXTENSION);
    switch ($ext) {
        case 'css':
            serveFile($static_file, 'text/css');
            exit;
        case 'js':
            serveFile($static_file, 'application/javascript');
            exit;
        case 'jpg':
        case 'jpeg':
            serveFile($static_file, 'image/jpeg');
            exit;
        case 'png':
            serveFile($static_file, 'image/png');
            exit;
        case 'html':
            serveFile($static_file, 'text/html');
            exit;
    }
}

// Route the request
switch ($request_uri) {
    case '':
    case 'index':
    case 'index.php':
    case 'index.html':
        include PUBLIC_PATH . '/index.php';
        break;
        
    case 'api':
        require BASE_PATH . '/src/api.php';
        break;
        
    default:
        // Check if it's an API request
        if (strpos($request_uri, 'api/') === 0) {
            require BASE_PATH . '/src/api.php';
            break;
        }
        
        // Try to find the file in different locations
        $possible_locations = [
            PUBLIC_PATH . '/views/' . $request_uri,
            PUBLIC_PATH . '/views/' . $request_uri . '.html',
            PUBLIC_PATH . '/views/' . $request_uri . '.php',
            PUBLIC_PATH . '/views/dashboard/' . $request_uri,
            PUBLIC_PATH . '/views/dashboard/' . $request_uri . '.html',
            PUBLIC_PATH . '/views/auth/' . $request_uri,
            PUBLIC_PATH . '/views/auth/' . $request_uri . '.html'
        ];
        
        $found = false;
        foreach ($possible_locations as $location) {
            if (file_exists($location)) {
                include $location;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "<p>The requested URL " . htmlspecialchars($request_uri) . " was not found on this server.</p>";
        }
        break;
}
