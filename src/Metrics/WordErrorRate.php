<?php

namespace ItkDev\SentenceSimilarityMetrics;

class WordErrorRate
{
    /**
     * Calculates word error rate (WER) between a reference sentence
     * and a prediction.
     *
     * @see https://en.wikipedia.org/wiki/Word_error_rate.
     *
     * @param string $reference
     *   Reference sentence
     * @param string $prediction
     *   Prediction
     *
     * @return float
     *   The WER score
     */
    public function wer(string $reference, string $prediction): float
    {
        $referenceWords = explode(' ', $reference);
        $predictionWords = explode(' ', $prediction);

        $referenceLength = count($referenceWords);
        $predictionLength = count($predictionWords);

        $dpTable = array_fill(
            0,
            $referenceLength + 1,
            array_fill(0, $predictionLength + 1, 0)
        );

        // Initialize table for dynamic programming.
        for ($i = 0; $i <= $referenceLength; ++$i) {
            $dpTable[$i][0] = $i;
        }

        for ($j = 0; $j <= $predictionLength; ++$j) {
            $dpTable[0][$j] = $j;
        }

        // Calculate WER using dynamic programming.
        for ($i = 1; $i <= $referenceLength; ++$i) {
            for ($j = 1; $j <= $predictionLength; ++$j) {
                $delete = $dpTable[$i - 1][$j] + 1;
                $insert = $dpTable[$i][$j - 1] + 1;
                $substitute = $dpTable[$i - 1][$j - 1] + ($referenceWords[$i - 1] !== $predictionWords[$j - 1]);

                $dpTable[$i][$j] = min($delete, $insert, $substitute);
            }
        }

        // WER is the minimal cost divided by the number of words in the reference.
        return $dpTable[$referenceLength][$predictionLength] / $referenceLength;
    }
}
