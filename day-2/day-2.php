<?php
$puzzleInput = file('input.txt');
$productIdsRange = explode(',', $puzzleInput);
$regexRepeatingSequence = '\b(\d+)\1\b';
$invalidIds = array();

foreach ($productIdsRange as $range) {
    $idRange = explode('-', $range);
    foreach (range($idRange[0], $idRange[1]) as $productId) {
        preg_match($regexRepeatingSequence, $productId, $invalidIds);
    }
}

print "All Invalid IDs Added Up:" . array_sum($invalidIds);