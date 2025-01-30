<?php

namespace ItkDev\SentenceSimilarityMetrics;

class CharacterErrorRate
{
    /**
     * Calculates character error rate (CER) between two sentences.
     */
    public function cer(string $reference, string $hypothesis): float
    {
        $referenceCharacters = mb_str_split($reference); // Split into characters
        $hypothesisCharacters = mb_str_split($hypothesis); // Split into characters

        $referenceLength = count($referenceCharacters);
        $hypothesisLength = count($hypothesisCharacters);

        $dpTable = array_fill(
            0,
            $referenceLength + 1,
            array_fill(0, $hypothesisLength + 1, 0)
        );

        // Initialize table for dynamic programming
        for ($i = 0; $i <= $referenceLength; ++$i) {
            $dpTable[$i][0] = $i;
        }

        for ($j = 0; $j <= $hypothesisLength; ++$j) {
            $dpTable[0][$j] = $j;
        }

        // Calculate CER using dynamic programming
        for ($i = 1; $i <= $referenceLength; ++$i) {
            for ($j = 1; $j <= $hypothesisLength; ++$j) {
                $delete = $dpTable[$i - 1][$j] + 1;
                $insert = $dpTable[$i][$j - 1] + 1;
                $substitute = $dpTable[$i - 1][$j - 1] + ($referenceCharacters[$i - 1] !== $hypothesisCharacters[$j - 1]);

                $dpTable[$i][$j] = min($delete, $insert, $substitute);
            }
        }

        // CER is the minimal cost divided by the number of characters in the reference
        return $dpTable[$referenceLength][$hypothesisLength] / $referenceLength;
    }
}
