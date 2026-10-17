<?php
// packages.php: the ONE place where package prices live.
// Edit a price here and the booking page and receipt update automatically.

$packages = [
    "Agra"    => ["price" => 8500,  "old_price" => 10000],
    "Delhi"   => ["price" => 8000,  "old_price" => 10000],
    "Goa"     => ["price" => 10000, "old_price" => 12000],
    "Jaipur"  => ["price" => 9000,  "old_price" => 11000],
    "Kashmir" => ["price" => 12000, "old_price" => 15000],
    "Udaipur" => ["price" => 9500,  "old_price" => 12000],
];

// Returns the price per person for a place, or null if the place doesn't exist.
function get_price($place) {
    global $packages;
    return $packages[$place]["price"] ?? null;
}