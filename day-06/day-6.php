<?php
// Experimentation of Gemini 3 Pro using Antigravity

class Day6
{
    private function getProblemBlocks($filename)
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

        $blocks = [];
        // Extract problems between separators
        for ($i = 0; $i < count($separators) - 1; $i++) {
            $startCol = $separators[$i] + 1;
            $endCol = $separators[$i + 1];
            $length = $endCol - $startCol;

            if ($length <= 0) {
                continue;
            }

            $blockLines = [];
            for ($row = 0; $row < count($paddedLines); $row++) {
                $blockLines[] = substr($paddedLines[$row], $startCol, $length);
            }
            // Filter out purely empty blocks if any (though logic suggests separators handle this)
            // But checking block content is safe
            $fullString = implode("", $blockLines);
            if (trim($fullString) === "") {
               continue;
            }
            
            $blocks[] = $blockLines;
        }

        return $blocks;
    }

    public function solvePart1($filename)
    {
        $blocks = $this->getProblemBlocks($filename);
        $grandTotal = 0;

        foreach ($blocks as $blockLines) {
            $problemBlock = implode("\n", $blockLines);

            // Parse numbers and operator
            preg_match_all('/\d+/', $problemBlock, $matches);
            $numbers = $matches[0];

            preg_match('/[\+\*]/', $problemBlock, $opMatch);
            $operator = $opMatch[0] ?? null;

            if (empty($numbers) || !$operator) {
                continue;
            }

            // Calculate
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
            } else {
                $result = 0;
            }

            $grandTotal += $result;
        }

        return $grandTotal;
    }

    public function solvePart2($filename)
    {
        $blocks = $this->getProblemBlocks($filename);
        $grandTotal = 0;

        foreach ($blocks as $blockLines) {
            $problemBlock = implode("\n", $blockLines);
            
            // Find operator
            preg_match('/[\+\*]/', $problemBlock, $opMatch);
            $operator = $opMatch[0] ?? null;

            if (!$operator) {
                continue;
            }

            // Parse numbers column by column (Right to Left)
            // Actually order doesn't matter for + and *, but spec says Right to Left.
            $numbers = [];
            $width = strlen($blockLines[0]);
            
            for ($col = $width - 1; $col >= 0; $col--) {
                $currentNumStr = "";
                for ($row = 0; $row < count($blockLines); $row++) {
                    $char = $blockLines[$row][$col];
                    if (is_numeric($char)) {
                        $currentNumStr .= $char;
                    }
                }
                if ($currentNumStr !== "") {
                    $numbers[] = (int)$currentNumStr;
                }
            }

            if (empty($numbers)) {
                continue;
            }

            // Calculate
            if ($operator === '+') {
                $result = 0;
                foreach ($numbers as $num) {
                    $result += $num;
                }
            } elseif ($operator === '*') {
                $result = 1;
                foreach ($numbers as $num) {
                    $result *= $num;
                }
            } else {
                $result = 0;
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
    
    echo "Part 1 Example Result: " . $solver->solvePart1($exampleFile) . "\n";
    echo "Part 2 Example Result: " . $solver->solvePart2($exampleFile) . "\n";

    // Real Input
    echo "\nSolving real input...\n";
    echo "Part 1 Answer: " . $solver->solvePart1('input.txt') . "\n";
    echo "Part 2 Answer: " . $solver->solvePart2('input.txt') . "\n";

    // Cleanup
    if (file_exists($exampleFile)) {
        unlink($exampleFile);
    }
}
