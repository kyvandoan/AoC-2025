<?php
$puzzleInput = file('input.txt');
$freshIngredientsDatabase = [];
$ingredientsIds = [];
$freshIngredients = 0;

foreach ($puzzleInput as $line) {
    if (str_contains(trim($line), '-') && $line != '') {
        array_push($freshIngredientsDatabase, trim($line));
    } elseif (trim($line) != '') {
        array_push($ingredientsIds, trim($line));
    }
}

foreach ($ingredientsIds as $ingredientId) {
    foreach ($freshIngredientsDatabase as $freshIdsRange) {
        $currentFreshIdsRange = explode('-', $freshIdsRange);
        if ($ingredientId >= $currentFreshIdsRange[0] && $ingredientId <= $currentFreshIdsRange[1]) {
            $freshIngredients++;
            break;
        }
    }
}

$freshIngredientsRange = [];
foreach ($freshIngredientsDatabase as $freshIdsRange) {
    $idsRange = explode('-', $freshIdsRange);
    array_push($freshIngredientsRange, array(intval($idsRange[0]), intval($idsRange[1])));
}

usort($freshIngredientsRange, function($a, $b) {
    return $a[0] <=> $b[0];
});

$freshIngredientsRangeDeduplicated = [];
foreach ($freshIngredientsRange as $freshIdsRange) {
    if (empty($freshIngredientsRangeDeduplicated)) {
        array_push($freshIngredientsRangeDeduplicated, $freshIdsRange);
    } else {
        $lastRange = $freshIngredientsRangeDeduplicated[count($freshIngredientsRangeDeduplicated) - 1];
        if ($freshIdsRange[0] <= $lastRange[1] + 1) {
            $freshIngredientsRangeDeduplicated[count($freshIngredientsRangeDeduplicated) - 1][1] = max($lastRange[1], $freshIdsRange[1]);
        } else {
            array_push($freshIngredientsRangeDeduplicated, $freshIdsRange);
        }
    }
}

$totalUniqueIngredientId = 0;
foreach ($freshIngredientsRangeDeduplicated as $freshIdsRange) {
    $totalUniqueIngredientId += $freshIdsRange[1] - $freshIdsRange[0] + 1;
}

print "[Part 1] Number of fresh ingredients: " . $freshIngredients . PHP_EOL;
print "[Part 2] Total number of unique fresh ingredients IDs: " . $totalUniqueIngredientId . PHP_EOL;