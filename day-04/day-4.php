<?php
$puzzleInput = file('input.txt');
$paperRolls = 0;
$cafetariaWall = [];

foreach ($puzzleInput as $shelf) {
    $cafetariaWall[] = str_split(trim($shelf));
}

$shelves = count($cafetariaWall);
$cols = count($cafetariaWall[0]);

$directions = [
    [-1, -1], [-1, 0], [-1, 1],     // top-left, top, top-right
    [0, -1], [0, 1],                // left, right
    [1, -1],  [1, 0],  [1, 1]       // bottom-left, bottom, bottom-right
];

foreach ($cafetariaWall as $shelfIndex => $shelf) {
    foreach ($shelf as $colIndex => $item) {
        if ($item == '@') {
            $adjacentPaperRolls = 0;
            
            foreach ($directions as $direction) {
                $row = $shelfIndex + $direction[0];
                $col = $colIndex + $direction[1];

                if ($row >= 0 && $row < $shelves && $col >= 0 && $col < $cols) {
                    if ($cafetariaWall[$row][$col] == '@') {
                        $adjacentPaperRolls++;
                    }
                }
            }
            
            if ($adjacentPaperRolls < 4) {
                $paperRolls++;
            }
        }
    }
}

print "[Part 1] Number of forklift accessible rolls of paper: " . $paperRolls . PHP_EOL;

$paperRollsRemoved = 0;
$keepRemoving = true;

while ($keepRemoving) {
    $toRemove = [];
    foreach ($cafetariaWall as $shelfIndex => $shelf) {
        foreach ($shelf as $colIndex => $item) {
            if ($item == '@') {
                $adjacentPaperRolls = 0;
                
                foreach ($directions as $direction) {
                    $row = $shelfIndex + $direction[0];
                    $col = $colIndex + $direction[1];

                    if ($row >= 0 && $row < $shelves && $col >= 0 && $col < $cols) {
                        if ($cafetariaWall[$row][$col] == '@') {
                            $adjacentPaperRolls++;
                        }
                    }
                }
                
                if ($adjacentPaperRolls < 4) {
                    $toRemove[] = [$shelfIndex, $colIndex];
                }
            }
        }
    }

    if (empty($toRemove)) {
        $keepRemoving = false;
    } else {
        foreach ($toRemove as $position) {
            $cafetariaWall[$position[0]][$position[1]] = '.';
            $paperRollsRemoved++;
        }
    }
}

print "[Part 2] Number of rolls removed: " . $paperRollsRemoved;