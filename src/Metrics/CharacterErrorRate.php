<?php

namespace ItkDev\SentenceSimilarityMetrics;

class CharacterErrorRate
{
    /**
     * Calculates character error rate (CER) between a reference sentence
     * and a prediction.
     *
     * CER is WER on character level rather than word level.
     *
     * @see https://en.wikipedia.org/wiki/Word_error_rate
     *
     * @param string $reference
     *   Reference sentence
     * @param string $prediction
     *   Prediction
     *
     * @return float
     *   The CER score
     */
    public function cer(string $reference, string $prediction): float
    {
        // Split into characters.
        $referenceCharacters = mb_str_split($reference);
        $predictionCharacters = mb_str_split($prediction);

        $referenceLength = count($referenceCharacters);
        $predictionLength = count($predictionCharacters);

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

        // Calculate CER using dynamic programming.
        for ($i = 1; $i <= $referenceLength; ++$i) {
            for ($j = 1; $j <= $predictionLength; ++$j) {
                $delete = $dpTable[$i - 1][$j] + 1;
                $insert = $dpTable[$i][$j - 1] + 1;
                $substitute = $dpTable[$i - 1][$j - 1] + ($referenceCharacters[$i - 1] !== $predictionCharacters[$j - 1]);

                $dpTable[$i][$j] = min($delete, $insert, $substitute);
            }
        }

        // CER is the minimal cost divided by the number of characters in the reference.
        return $dpTable[$referenceLength][$predictionLength] / $referenceLength;
    }
}
