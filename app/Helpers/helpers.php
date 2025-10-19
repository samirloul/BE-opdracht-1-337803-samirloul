<?php
if (!function_exists('url')) {
    function url(string $route = ''): string {
        $scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $prefix = $scriptDir ?: '';
        $route = ltrim($route, '/');
        return "{$prefix}/index.php" . ($route !== '' ? "?route={$route}" : '');
    }
}
