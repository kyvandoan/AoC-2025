<?php

class Day6
{
    public function solve($filename)
    {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            die("Could not read file: $filename\n");
        }

        // Pad lines to the same length
        $maxLength = 0;
        foreach ($lines as $line) {
            $maxLength = max($maxLength, strlen($line));
        }

        $paddedLines = [];
        foreach ($lines as $line) {
            $paddedLines[] = str_pad($line, $maxLength, " ");
        }

        // Identify separator columns (all spaces)
        $separators = [];
        $separators[] = -1; // Virtual separator at the start

        for ($col = 0; $col < $maxLength; $col++) {
            $isSeparator = true;
            for ($row = 0; $row < count($paddedLines); $row++) {
                if ($paddedLines[$row][$col] !== ' ') {
                    $isSeparator = false;
                    break;
                }
            }
            if ($isSeparator) {
                $separators[] = $col;
            }
        }
        $separators[] = $maxLength; // Virtual separator at the end

        $grandTotal = 0;

        // Extract problems between separators
        for ($i = 0; $i < count($separators) - 1; $i++) {
            $startCol = $separators[$i] + 1;
            $endCol = $separators[$i + 1];
            $length = $endCol - $startCol;

            if ($length <= 0) {
                continue;
            }

            // check if this block is actually empty (consecutive separators)
            // Logic above should handle it, but let's be sure we have content.

            $problemBlock = "";
            for ($row = 0; $row < count($paddedLines); $row++) {
                $problemBlock .= substr($paddedLines[$row], $startCol, $length) . "\n";
            }

            // Parse numbers and operator
            preg_match_all('/\d+/', $problemBlock, $matches);
            $numbers = $matches[0];

            preg_match('/[\+\*]/', $problemBlock, $opMatch);
            $operator = $opMatch[0] ?? null;

            if (empty($numbers) || !$operator) {
                continue;
            }

            // Calculate
            $result = 0;
            if ($operator === '+') {
                $result = 0;
                foreach ($numbers as $num) {
                    $result += (int) $num;
                }
            } elseif ($operator === '*') {
                $result = 1;
                foreach ($numbers as $num) {
                    $result *= (int) $num;
                }
            }

            $grandTotal += $result;
        }

        return $grandTotal;
    }
}

// Check if running directly
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    $solver = new Day6();

    // Example Verification
    echo "Verifying with example...\n";
    $exampleFile = 'example_input.txt';
    $exampleContent = "123 328  51 64 
 45 64  387 23 
  6 98  215 314
*   +   *   +  ";
    file_put_contents($exampleFile, $exampleContent);
    $exampleResult = $solver->solve($exampleFile);
    echo "Example Result: " . $exampleResult . "\n";
    if ($exampleResult == 4277556) {
        echo "Example PASSED!\n";
    } else {
        echo "Example FAILED (Expected 4277556)\n";
    }

    // Real Input
    echo "\nSolving real input...\n";
    $realResult = $solver->solve('input.txt');
    echo "Grand Total: " . $realResult . "\n";

    // Cleanup
    if (file_exists($exampleFile)) {
        unlink($exampleFile);
    }
}
