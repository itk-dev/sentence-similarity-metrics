# Sentence similarity metrics

A PHP library containing metrics for comparing sentences.

## Install

You can install this library by utilizing PHP Composer, which is the recommended
dependency management tool for PHP.

```shell
composer require itk-dev/sentence-similarity-metrics
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
