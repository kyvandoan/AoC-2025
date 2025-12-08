<?php
$puzzleInput = file('input.txt');
$productIdsRange = explode(',', $puzzleInput[0]);
$invalidIds = 0;

foreach ($productIdsRange as $range) {
    $idRange = explode('-', $range);
    foreach (range($idRange[0], $idRange[1]) as $productId) {
        if (preg_match('/\b(\d+)\1\b/', $productId)) {
            $invalidIds = $invalidIds + $productId;
        }
    }
}

print "All Invalid IDs Added Up: " . $invalidIds;