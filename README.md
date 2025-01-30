# Sentence similarity metrics

A PHP library containing metrics for comparing sentences.

## Install

You can install this library by utilizing PHP Composer, which is the recommended
dependency management tool for PHP.

```shell
composer require itk-dev/sentence-similarity-metrics
```

## Metrics

### Word error rate (WER)

WER is a metric used for determining the performance of a speech recognition system.
See [Wikipedia: Word error rate](https://en.wikipedia.org/wiki/Word_error_rate) and
[Metric: wer](https://huggingface.co/spaces/evaluate-metric/wer) for more information.

WER compares a reference sentence to a prediction made by a speech recognition system.

```php
use ItkDev\SentenceSimilarityMetrics\WordErrorRate;

$wordErrorRate = new WordErrorRate();

$reference = 'I am 32 years old and I am a software developer';
$prediction = 'I am a 32 year old and I am as a developer';

$wer = $wordErrorRate->wer($reference, $prediction); // 0.36363636363636365
```

### Character error rate (CER)

CER is WER on character level rather than word level.

```php
use ItkDev\SentenceSimilarityMetrics\CharacterErrorRate;

$characterErrorRate = new CharacterErrorRate();

$reference = 'I am 32 years old and I am a software developer';
$prediction = 'I am a 32 year old and I am as a developer';

$cer = $characterErrorRate->cer($reference, $prediction); // 0.2127659574468085
```

## Development

### Install

To install the dependencies required for the development and usage of this
library, run `composer install` through the supplied docker compose setup.

```shell
docker compose run --rm phpfpm composer install
```

### Tests

We use the [PHPUnit](https://phpunit.de/) testing framework.

To run tests execute the following command:

```shell
docker compose run --rm phpfpm vendor/bin/phpunit --coverage-clover=coverage/unit.xml
```

### Check coding standards

The following commands let you test that the code follows the coding
standards we decided to adhere to in this project.

```shell
docker compose run --rm phpfpm composer coding-standards-check
```

#### Check Markdown file

```shell
docker run --rm --volume "$PWD:/md" itkdev/markdownlint **/*.md --fix
docker run --rm --volume "$PWD:/md" itkdev/markdownlint **/*.md
```

### Apply coding standards

You can automatically fix some coding styles issues by running:

```shell
docker compose run --rm phpfpm composer coding-standards-apply
```
