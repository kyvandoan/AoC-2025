<?php
$puzzleInput = file('input.txt');
$totalJoltage = 0;

foreach ($puzzleInput as $batteryBank) {
    $batteries = str_split(trim($batteryBank));
    $currentMax = 0;

    foreach ($batteries as $firstIndex => $firstDigit) {
        foreach ($batteries as $secondIndex => $secondDigit) {
            if ($secondIndex > $firstIndex) {
                $joltage = intval($firstDigit . $secondDigit);
                
                if ($joltage > $currentMax) {
                    $currentMax = $joltage;
                }
            }
        }
    }

    $totalJoltage = $totalJoltage + $currentMax;
}

print "Total Output Joltage: " . $totalJoltage;