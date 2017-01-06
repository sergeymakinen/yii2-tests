# Yii 2 tests stuff

Common Yii 2 extension tests stuff. I use it in my extension tests but you're also free to use. :)

[![Code Quality](https://img.shields.io/scrutinizer/g/sergeymakinen/yii2-tests.svg?style=flat-square)](https://scrutinizer-ci.com/g/sergeymakinen/yii2-tests) [![Build Status](https://img.shields.io/travis/sergeymakinen/yii2-tests.svg?style=flat-square)](https://travis-ci.org/sergeymakinen/yii2-tests) [![Code Coverage](https://img.shields.io/codecov/c/github/sergeymakinen/yii2-tests.svg?style=flat-square)](https://codecov.io/gh/sergeymakinen/yii2-tests) [![SensioLabsInsight](https://img.shields.io/sensiolabs/i/406a3388-8e6c-4979-a943-b1ad1b8aeed4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/406a3388-8e6c-4979-a943-b1ad1b8aeed4)

[![Packagist Version](https://img.shields.io/packagist/v/sergeymakinen/yii2-tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/yii2-tests) [![Total Downloads](https://img.shields.io/packagist/dt/sergeymakinen/yii2-tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/yii2-tests) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```bash
composer require --dev "sergeymakinen/yii2-tests:^2.0"
```

or add

```json
"sergeymakinen/yii2-tests": "^2.0"
```

to the require-dev section of your `composer.json` file.

## Usage

```php
class MyClassTest extends \sergeymakinen\yii\tests\TestCase
{
    // Use protected methods defined in the TestCase class
}
```
