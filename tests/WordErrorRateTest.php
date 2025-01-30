<?php

use ItkDev\SentenceSimilarityMetrics\WordErrorRate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(WordErrorRate::class)]
final class WordErrorRateTest extends TestCase
{
    private WordErrorRate $wordErrorRate;
    private float $precision = 0.00001;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wordErrorRate = new WordErrorRate();
    }

    /**
     * Tests word error rate calculations.
     */
    #[DataProvider('wordErrorRateDataProvider')]
    public function testWordErrorRateCalculation(string $reference, string $hypothesis, float $wer): void
    {
        $this->compareFloats($wer, $this->wordErrorRate->wer($reference, $hypothesis));
    }

    /**
     * Compares floats.
     *
     * @see https://www.php.net/manual/en/language.types.float.php#language.types.float.comparison
     */
    private function compareFloats(float $float1, float $float2): void
    {
        $this->assertTrue(
            abs($float1 - $float2) < $this->precision,
            "Expected $float1, got $float2"
        );
    }

    /**
     * Data provider for word error rate calculation test.
     *
     * Word error rates are calculated by
     *
     * @see https://huggingface.co/spaces/evaluate-metric/wer.
     */
    public static function wordErrorRateDataProvider(): Generator
    {
        yield [
            // Reference
            'I am 32 years old and I am a software developer',
            // Hypothesis/guess/prediction
            'I am a 32 year old and I am as a developer',
            0.36363636363636,
        ];

        yield [
            'I am a 32 year old and I am as a developer',
            'I am 32 years old and I am a software developer',
            0.3333333333333333,
        ];

        yield [
            'The sky was filled with shimmering stars on a calm summer night.',
            'The sky was filled with shimmering stars on a calm summer night.',
            0.0,
        ];

        yield [
            'She opened the old books and discovered a letter tucked between the pages.',
            'She opened the old book and discovered a letter tucked between the pages.',
            0.07692307692307693,
        ];

        yield [
            'The curious cat cautiously approached the mysterious, glowing object.',
            'A gentle breeze carried the scent of blooming jasmine through the garden.',
            1.3333333333333333,
        ];

        yield [
            'The curious cat cautiously approached the mysterious object.',
            'The curious cat cautiously approached the mysterious, glowing object.',
            0.25,
        ];

        yield [
            'He could not resist the aroma of freshly baked delicious chocolate chip cookies.',
            'He could not resist the aroma of freshly baked chocolate chip cookies.',
            0.07692307692307693,
        ];

        yield [
            'The rhythmic sound of waves lapping on the shore brought immediate peace to her soul.',
            'The sound of waves crashing on the shore quickly eased her mind.',
            0.4666666666666667,
        ];

        yield [
            'Hello',
            'They were thrilled to finally see the snow-covered mountains in the distance.',
            12.0,
        ];

        yield [
            'The clock struck midnight, signaling the start of a brand new year.',
            'The clock struck midnight, signaling the start of a brand-new year.',
            0.16666666666666666,
        ];

        yield [
            'He forgot his umbrella and found himself drenched in a sudden downpour.',
            'He forgot hes coat and found himself caught in a random downpour.',
            0.3333333333333333,
        ];

        yield [
            'The little boys laughter echoed as he chased butterflies in the meadow.',
            'The young boys laughter echoed as he chased butterflys in the meadow.',
            0.16666666666666666,
        ];
    }
}
