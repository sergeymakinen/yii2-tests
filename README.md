# Yii 2 tests stuff

Common Yii 2 extension tests stuff. I use it in my extension tests but you're also free to use. :)

[![Packagist Version](https://img.shields.io/packagist/v/sergeymakinen/yii2-tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/yii2-tests) [![Total Downloads](https://img.shields.io/packagist/dt/sergeymakinen/yii2-tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/yii2-tests) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```bash
composer require --dev "sergeymakinen/yii2-tests:^1.0"
```

or add

```json
"sergeymakinen/yii2-tests": "^1.0"
```

to the require-dev section of your `composer.json` file.

## Usage

```php
class MyClassTest extends \sergeymakinen\tests\TestCase
{
    // Use protected methods defined in the TestCase class
}
```
