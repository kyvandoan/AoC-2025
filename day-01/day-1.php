<?php 
$puzzleInput = file('input.txt');
$dialClicks = 100;
$dialPosition = 50;
$password = 0;
$passwordMethod = 0;

function dialLeft($dialPosition, $rotationDistance, $dialClicks) {
    $dialPosition = $dialPosition - $rotationDistance;
    $dialPosition = $dialPosition % $dialClicks;

    if ($dialPosition < 0) {
        $dialPosition = $dialPosition + $dialClicks;
    }

    return $dialPosition;
}

function dialRight($dialPosition, $rotationDistance, $dialClicks) {
    $dialPosition = $dialPosition + $rotationDistance;
    $dialPosition = $dialPosition % $dialClicks;

    return $dialPosition;
}

function countZeroCrossings($startPosition, $direction, $rotationDistance, $dialClicks) {
    $crossings = 0;
    
    if ($startPosition == 0) {
        return floor($rotationDistance / $dialClicks);
    }

    if ($direction == 'L') {
        if ($rotationDistance >= $startPosition) {
            $remainingDistance = $rotationDistance - $startPosition;
            $crossings = 1 + floor($remainingDistance / $dialClicks);
        }
    } else {
        $distanceToZero = $dialClicks - $startPosition;
        if ($rotationDistance >= $distanceToZero) {
            $remainingDistance = $rotationDistance - $distanceToZero;
            $crossings = 1 + floor($remainingDistance / $dialClicks);
        }
    }
    
    return $crossings;
}

foreach ($puzzleInput as $rotation) {
    $rotationHeading = substr($rotation, 0, 1);
    $rotationDistance = intval(substr($rotation, 1));

    $previousPosition = $dialPosition;

    if ($rotationHeading == 'L') {
        $dialPosition = dialLeft($dialPosition, $rotationDistance, $dialClicks);
    } else {
        $dialPosition = dialRight($dialPosition, $rotationDistance, $dialClicks);
    }

    if ($dialPosition == 0) {
        $password++;
    }

    $passwordMethod += countZeroCrossings($previousPosition, $rotationHeading, $rotationDistance, $dialClicks);
}

print "[Part 1] Password: " . $password . PHP_EOL;
print "[Part 2] 0x434C49434B Password: " . $passwordMethod;