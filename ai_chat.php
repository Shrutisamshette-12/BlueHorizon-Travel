<?php
// ai_chat.php: receives a chat message from the website, asks Gemini, returns the answer as JSON.
// The API key stays here on the server (in config.php) and is never sent to the browser.

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';
require 'packages.php';

function send_reply($text) {
    echo json_encode(['reply' => $text], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_reply("Please use the chat box on the website.");
}

if (!defined('GEMINI_API_KEY') || GEMINI_API_KEY === '' || strpos(GEMINI_API_KEY, 'PASTE') === 0) {
    send_reply("The AI assistant is not set up yet (API key missing in config.php).");
}

// ---- Simple limit: 20 messages per 10 minutes per visitor ----
$now = time();
$times = array_filter($_SESSION['chat_times'] ?? [], function ($t) use ($now) {
    return $t > $now - 600;
});
if (count($times) >= 20) {
    $_SESSION['chat_times'] = $times;
    send_reply("You are sending messages very fast. Please wait a few minutes and try again.");
}
$times[] = $now;
$_SESSION['chat_times'] = $times;
session_write_close(); // do not keep the session locked while waiting for the AI

// ---- Read the message ----
$input   = json_decode(file_get_contents("php://input"), true);
$message = trim($input['message'] ?? '');

if ($message === '') {
    send_reply("Please type a question.");
}
$message = mb_substr($message, 0, 500);

// Last few turns of the conversation, so the bot remembers the context
$contents = [];
$history  = is_array($input['history'] ?? null) ? array_slice($input['history'], -6) : [];
foreach ($history as $h) {
    $role = ($h['role'] ?? '') === 'model' ? 'model' : 'user';
    $text = mb_substr(trim((string)($h['text'] ?? '')), 0, 800);
    if ($text !== '') {
        $contents[] = ['role' => $role, 'parts' => [['text' => $text]]];
    }
}
$contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

// ---- Build the instructions from the REAL package list ----
$lines = [];
foreach ($packages as $place => $p) {
    $lines[] = "- $place: Rs. " . number_format($p['price']) . " per person (usual price Rs. " . number_format($p['old_price']) . ")";
}

$system =
    "You are the friendly travel assistant of BlueHorizon, a travel agency website.\n" .
    "Our packages (the ONLY packages we offer):\n" . implode("\n", $lines) . "\n\n" .
    "How booking works: the customer opens a package page, clicks Book Now, logs in, fills the form " .
    "(mobile, age, number of travellers, travel date), clicks Proceed To Payment, pays, and then can download the receipt.\n\n" .
    "Rules:\n" .
    "- Only talk about travel and BlueHorizon. Politely refuse anything else.\n" .
    "- Use only the packages and prices above. Never invent packages, discounts, dates, hotels or policies. " .
    "If you do not know something, say so and suggest the Contact page.\n" .
    "- You can suggest a package that fits the visitor's budget or interests and do simple price calculations (price x travellers).\n" .
    "- Keep answers short (under 120 words), in plain text with no markdown symbols like ** or #.\n" .
    "- Be warm and helpful. Reply in the language the visitor uses.";

$payload = [
    'system_instruction' => ['parts' => [['text' => $system]]],
    'contents'           => $contents,
    'generationConfig'   => ['temperature' => 0.6, 'maxOutputTokens' => 1024],
];

$model = defined('GEMINI_MODEL') ? GEMINI_MODEL : 'gemini-2.5-flash';
$url   = "https://generativelanguage.googleapis.com/v1beta/models/" . $model . ":generateContent";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'x-goog-api-key: ' . GEMINI_API_KEY],
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 25,
    CURLOPT_SSL_VERIFYPEER => false, // XAMPP on Windows usually has no CA bundle. Remove this line on a real server.
]);
$response = curl_exec($ch);
$curlErr  = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$debug = defined('AI_DEBUG') && AI_DEBUG;

if ($response === false) {
    send_reply($debug ? "Connection error: $curlErr" : "Sorry, I could not reach the AI service right now.");
}

$data = json_decode($response, true);

if ($httpCode !== 200) {
    $apiMsg = $data['error']['message'] ?? 'Unknown error';
    error_log("Gemini error $httpCode: $apiMsg");
    send_reply($debug ? "AI error ($httpCode): $apiMsg" : "Sorry, I could not answer that right now. Please try again.");
}

$parts = $data['candidates'][0]['content']['parts'] ?? [];
$reply = '';
foreach ($parts as $part) {
    $reply .= $part['text'] ?? '';
}
$reply = trim($reply);

send_reply($reply !== '' ? $reply : "Sorry, I could not come up with an answer. Please try rephrasing.");
