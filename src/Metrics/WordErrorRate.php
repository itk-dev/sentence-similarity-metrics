<?php

namespace ItkDev\SentenceSimilarityMetrics;

class WordErrorRate
{
    /**
     * Calculates word error rate (WER) between two sentences.
     */
    public function wer(string $reference, string $hypothesis): float
    {
        $referenceWords = explode(' ', $reference);
        $hypothesisWords = explode(' ', $hypothesis);

        $referenceLength = count($referenceWords);
        $hypothesisLength = count($hypothesisWords);

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

        // Calculate WER using dynamic programming
        for ($i = 1; $i <= $referenceLength; ++$i) {
            for ($j = 1; $j <= $hypothesisLength; ++$j) {
                $delete = $dpTable[$i - 1][$j] + 1;
                $insert = $dpTable[$i][$j - 1] + 1;
                $substitute = $dpTable[$i - 1][$j - 1] + ($referenceWords[$i - 1] !== $hypothesisWords[$j - 1]);

                $dpTable[$i][$j] = min($delete, $insert, $substitute);
            }
        }

        // WER is the minimal cost divided by the number of words in the reference
        return $dpTable[$referenceLength][$hypothesisLength] / $referenceLength;
    }
}
