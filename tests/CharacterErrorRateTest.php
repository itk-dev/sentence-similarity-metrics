<?php

use ItkDev\SentenceSimilarityMetrics\CharacterErrorRate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CharacterErrorRate::class)]
final class CharacterErrorRateTest extends TestCase
{
    private CharacterErrorRate $characterErrorRate;
    private float $precision = 0.00001;

    protected function setUp(): void
    {
        parent::setUp();

        $this->characterErrorRate = new CharacterErrorRate();
    }

    /**
     * Tests character error rate calculations.
     *
     * @param string $reference
     *  Reference sentence
     * @param string $hypothesis
     *  Hypothesis sentence
     * @param float $cer
     *  Expected CER score
     */
    #[DataProvider('characterErrorRateDataProvider')]
    public function testCharacterErrorRateCalculation(string $reference, string $hypothesis, float $cer): void
    {
        $this->compareFloats($cer, $this->characterErrorRate->cer($reference, $hypothesis));
    }

    /**
     * Compares floats.
     *
     * @see https://www.php.net/manual/en/language.types.float.php#language.types.float.comparison
     *
     * @param float $float1
     *   Float value
     * @param float $float2
     *   Float value
     */
    private function compareFloats(float $float1, float $float2): void
    {
        $this->assertTrue(
            abs($float1 - $float2) < $this->precision,
            "Expected $float1, got $float2"
        );
    }

    /**
     * Data provider for character error rate calculation test.
     *
     * Character error rates are calculated by
     *
     * @see https://huggingface.co/spaces/evaluate-metric/cer.
     */
    public static function characterErrorRateDataProvider(): Generator
    {
        yield [
            // Reference
            'I am 32 years old and I am a software developer',
            // Hypothesis/guess/prediction
            'I am a 32 year old and I am as a developer',
            0.2127659574468085,
        ];

        yield [
            'I am a 32 year old and I am as a developer',
            'I am 32 years old and I am a software developer',
            0.23809523809523808,
        ];

        yield [
            'The sky was filled with shimmering stars on a calm summer night.',
            'The sky was filled with shimmering stars on a calm summer night.',
            0.0,
        ];

        yield [
            'She opened the old books and discovered a letter tucked between the pages.',
            'She opened the old book and discovered a letter tucked between the pages.',
            0.013513513513513514,
        ];

        yield [
            'The curious cat cautiously approached the mysterious, glowing object.',
            'A gentle breeze carried the scent of blooming jasmine through the garden.',
            0.8695652173913043,
        ];

        yield [
            'The curious cat cautiously approached the mysterious object.',
            'The curious cat cautiously approached the mysterious, glowing object.',
            0.15,
        ];

        yield [
            'He could not resist the aroma of freshly baked delicious chocolate chip cookies.',
            'He could not resist the aroma of freshly baked chocolate chip cookies.',
            0.125,
        ];

        yield [
            'The rhythmic sound of waves lapping on the shore brought immediate peace to her soul.',
            'The sound of waves crashing on the shore quickly eased her mind.',
            0.43529411764705883,
        ];

        yield [
            'Hello',
            'They were thrilled to finally see the snow-covered mountains in the distance.',
            14.6,
        ];

        yield [
            'The clock struck midnight, signaling the start of a brand new year.',
            'The clock struck midnight, signaling the start of a brand-new year.',
            0.014925373134328358,
        ];

        yield [
            'He forgot his umbrella and found himself drenched in a sudden downpour.',
            'He forgot hes coat and found himself caught in a random downpour.',
            0.29577464788732394,
        ];

        yield [
            'The little boys laughter echoed as he chased butterflies in the meadow.',
            'The young boys laughter echoed as he chased butterflys in the meadow.',
            0.11267605633802817,
        ];
    }
}
