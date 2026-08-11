<?php
/**
 * SERVER-SIDE PROXY (optional fallback) for the microservice API.
 * Not strictly required since script.js fetches the API directly
 * from the browser (http://localhost:81/api.php), but included
 * in case you prefer server-side fetching or hit CORS issues.
 *
 * Usage: /fetch_api.php  -> proxies http://nginx:81/api.php
 */
header('Content-Type: application/json; charset=utf-8');

// "nginx" is the service name on the docker network, port 81 is the
// microservice's internal listen port (container-to-container call)
$microserviceUrl = 'http://nginx:81/api.php';

$context = stream_context_create(['http' => ['timeout' => 5]]);
$response = @file_get_contents($microserviceUrl, false, $context);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['success' => false, 'error' => 'Could not reach microservice API']);
    exit;
}

echo $response;
