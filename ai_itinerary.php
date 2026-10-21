<?php
// ai_itinerary.php: builds a day-by-day trip plan for one destination using Gemini.
// The API key stays on the server (config.php) and is never sent to the browser.

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';
require 'packages.php';

function send_plan($text) {
    echo json_encode(['plan' => $text], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_plan("Please use the Plan button on a destination page.");
}

if (!defined('GEMINI_API_KEY') || GEMINI_API_KEY === '' || strpos(GEMINI_API_KEY, 'PASTE') === 0) {
    send_plan("The AI planner is not set up yet (API key missing in config.php).");
}

// ---- Limit: 5 plans per 10 minutes per visitor ----
$now = time();
$times = array_filter($_SESSION['plan_times'] ?? [], function ($t) use ($now) {
    return $t > $now - 600;
});
if (count($times) >= 5) {
    $_SESSION['plan_times'] = $times;
    send_plan("You have made several plans already. Please wait a few minutes and try again.");
}
$times[] = $now;
$_SESSION['plan_times'] = $times;
session_write_close();

// ---- Read and check the input ----
$input = json_decode(file_get_contents("php://input"), true);

$place = ucfirst(strtolower(trim($input['place'] ?? '')));
if (!isset($packages[$place])) {
    send_plan("Unknown destination.");
}

$days = (int)($input['days'] ?? 3);
$days = max(1, min(7, $days));

$styles = ['Budget', 'Comfortable', 'Adventure', 'Family', 'Romantic'];
$style  = in_array($input['style'] ?? '', $styles, true) ? $input['style'] : 'Comfortable';

$price = number_format($packages[$place]['price']);

$prompt =
    "Create a $days-day travel itinerary for $place, India, for a $style trip.\n" .
    "Format (plain text, no markdown symbols like ** or #):\n" .
    "Day 1: short title\n" .
    "Morning: ...\nAfternoon: ...\nEvening: ...\n" .
    "Repeat for each day.\n" .
    "End with 2 short practical tips (best time to visit, what to carry).\n" .
    "Rules: suggest real, well-known places and activities only. Do not invent hotel names, prices or timings. " .
    "Keep the whole answer under 250 words. " .
    "You may mention that the BlueHorizon $place package costs Rs. $price per person.";

$payload = [
    'system_instruction' => ['parts' => [['text' => "You are a friendly travel planner for BlueHorizon, an Indian travel agency website. Answer only with the itinerary."]]],
    'contents'           => [['role' => 'user', 'parts' => [['text' => $prompt]]]],
    'generationConfig'   => ['temperature' => 0.7, 'maxOutputTokens' => 2048],
];

$model = defined('GEMINI_MODEL') ? GEMINI_MODEL : 'gemini-3.8-flash';
$url   = "https://generativelanguage.googleapis.com/v1beta/models/" . $model . ":generateContent";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'x-goog-api-key: ' . GEMINI_API_KEY],
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 40,
    CURLOPT_SSL_VERIFYPEER => false, // XAMPP on Windows usually has no CA bundle. Remove this line on a real server.
]);
$response = curl_exec($ch);
$curlErr  = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$debug = defined('AI_DEBUG') && AI_DEBUG;

if ($response === false) {
    send_plan($debug ? "Connection error: $curlErr" : "Sorry, I could not reach the AI service right now.");
}

$data = json_decode($response, true);

if ($httpCode !== 200) {
    $apiMsg = $data['error']['message'] ?? 'Unknown error';
    error_log("Gemini itinerary error $httpCode: $apiMsg");
    send_plan($debug ? "AI error ($httpCode): $apiMsg" : "Sorry, I could not create a plan right now. Please try again.");
}

$plan = '';
foreach (($data['candidates'][0]['content']['parts'] ?? []) as $part) {
    $plan .= $part['text'] ?? '';
}
$plan = trim($plan);

send_plan($plan !== '' ? $plan : "Sorry, I could not create a plan. Please try again.");
