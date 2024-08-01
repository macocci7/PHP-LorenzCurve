# PHP Lorenz Curve

A PHP Library to draw a Lorenz Curve.

## 1. Features

`PHP-LorenzCurve` draws a Lorenz Curve and also calculates the Gini's coefficient.

<img src="examples/img/BasicUsage.png" width="300" />

## 2. Contents

- [1. Features](#1-features)
- 2\. Contents
- [3. Requirements](#3-requirements)
- [4. Installation](#4-installation)
- [5. Usage](#5-usage)
- [6. Examples](#6-examples)
- [7. LICENSE](#7-license)

## 3. Requirements

- PHP 8.1 or later
- Imagick PHP Extention
- Composer

## 4. Installation

```bash
composer require macocci7-lorenz-curve
```

## 5. Usage

### 5.1. Basic Usage

To draw a Lorenz Curve, create an instance of `LorenzCurve` class at first.

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpLorenzCurve\LorenzCurve;

$lc = new LorenzCurve();
```

Next, set the data, the class range and save the image into a file.

```php
$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->create('img/BasicUsage.png');
```

This results in the image below.

<img src="examples/img/BasicUsage.png" width="300" />

### 5.2. Adjusting the Appearance

You can draw grid lines with `grid()` method specifying the width and the color.

> Note: Specifying `null` as a color code results in transparent.

```php
$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->grid(1, '#ffcccc')    // width: 1 pix, color: '#ffcccc'
    ->create('img/DrawGrid.png');
```

This results in the image below.

<img src="examples/img/DrawGrid.png" width="300" />

You can create an upward convex Lorenz Curve by sorting the list of the classes in decending order with `reverseClasses()` method.

```php
$lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->reverseClasses()
    ->grid(1, '#ffcccc')
    ->create('img/UpwardConvexCurve.png');
```

This results in the image below.

<img src="examples/img/UpwardConvexCurve.png" width="300" />

### 5.3. Gini's Coefficient

You can get the Gini's Coefficient with `getGinisCoefficient()` method without generating an image.

```php
var_dump(
    $lc
    ->setData([1, 5, 10, 15, 20])
    ->setClassRange(5)
    ->getGinisCoefficient()
);
```

This results in as below.

```bash
double(0.37647058823529)
```

## 6. Examples

- [BasicUsage.php](examples/BasicUsage.php) >> results in:

    <img src="examples/img/BasicUsage.png" width="300" />

- [DrawGrid.php](examples/DrawGrid.php) >> results in:

    <img src="examples/img/DrawGrid.png" width="300" />

- [UpwardConvexCurve.php](examples/UpwardConvexCurve.php) >> results in:

    <img src="examples/img/UpwardConvexCurve.png" width="300" />

- [GinisCoefficient.php](examples/GinisCoefficient.php) >> results in:

    ```bash
    double(0.37647058823529)
    ```

- [GinisCoefficient0.php](examples/GinisCoefficient0.php) >> results in:

    <img src="examples/img/GinisCoefficient0.png" width="300" />

    ▼Gini's Coefficient:

    ```bash
    int(0)
    ```

- [GinisCoefficientAlmost1.php](examples/GinisCoefficientAlmost1.php) >> results in:

    <img src="examples/img/GinisCoefficientAlmost1.png" width="300" />

    ▼Gini's Coefficient:

    ```bash
    double(0.99800399201597)
    ```

- [GinisCoefficient1.php](examples/GinisCoefficient1.php) >> results in:

    <img src="examples/img/GinisCoefficient1.png" width="300" />

    ▼Gini's Coefficient:

    ```bash
    double(1)
    ```

## 7. LICENSE

[MIT](LICENSE)

***

*Copyright 2024 macocci7*
