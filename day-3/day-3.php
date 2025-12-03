<?php
$puzzleInput = file('input.txt');
$totalJoltage = 0;

foreach ($puzzleInput as $batteryBank) {
    $batteriesJoltage = str_split($batteryBank);

    $firstHighestJoltage = max($batteriesJoltage);
    $firstHighestJoltageIndex = array_search($firstHighestJoltage, $batteriesJoltage);

    $remainingBatteries = array_slice($batteriesJoltage, $firstHighestJoltageIndex + 1);
    if (!empty($remainingBatteries)) {
        $secondHighestJoltage = max($remainingBatteries);
    } else {
        $secondHighestJoltage = 0;
    }

    $totalJoltage = $totalJoltage + intval($firstHighestJoltage . $secondHighestJoltage);

    var_dump($totalJoltage);
}

print "Total Output Joltage: " . $totalJoltage;