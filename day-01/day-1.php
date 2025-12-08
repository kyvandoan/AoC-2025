<?php 
$puzzleInput = file('input.txt');
$dialClicks = 100;
$dialPosition = 50;
$password = 0;

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

foreach ($puzzleInput as $rotation) {
    $rotationHeading = substr($rotation, 0, 1);
    $rotationDistance = substr($rotation, 1);

    if ($rotationHeading == 'L') {
        $dialPosition = dialLeft($dialPosition, $rotationDistance, $dialClicks);
    } else {
        $dialPosition = dialRight($dialPosition, $rotationDistance, $dialClicks);
    }

    if ($dialPosition == 0) {
        $password++;
    }
}

return "Password: " . $password;
?>