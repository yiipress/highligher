<p align="center">
    <a href="https://github.com/yiipress" target="_blank">
        <img src="./logo.svg" height="100px" alt="YiiPress highlighter">
    </a>
    <h1 align="center">YiiPress highlighter PHP extension</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiipress/highlighter/v)](https://packagist.org/packages/yiipress/highlighter)
[![Total Downloads](https://poser.pugx.org/yiipress/highlighter/downloads)](https://packagist.org/packages/yiipress/highlighter)
[![Tests](https://github.com/yiipress/highligher/actions/workflows/tests.yml/badge.svg)](https://github.com/yiipress/highligher/actions/workflows/tests.yml)
[![Windows](https://github.com/yiipress/highligher/actions/workflows/windows.yml/badge.svg)](https://github.com/yiipress/highligher/actions/workflows/windows.yml)

The package provides a native PHP extension for fast server-side syntax highlighting with
[syntect](https://github.com/trishume/syntect/).

## Requirements

- PHP 8.1 - 8.5.
- [PIE](https://github.com/php/pie) for installation.
- On Linux and macOS: `cargo`, `phpize`, `php-config`, C compiler, and `make`.

Windows builds are distributed as prebuilt DLLs attached to GitHub releases.

## Installation

Install the extension with PIE:

```shell
pie install yiipress/highlighter
```

PIE installs the native extension into the target PHP installation. If PIE does not enable it automatically, add the
extension to your `php.ini`:

```ini
extension=highlighter
```

Composer can be used to declare that an application requires the loaded extension:

```shell
composer require ext-highlighter:*
```

Installing `yiipress/highlighter` with Composer alone is not enough because Composer does not build or enable native PHP
extensions.

## General usage

Highlight an HTML fragment that contains code blocks in the form
`<pre><code class="language-php">...</code></pre>`:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter();

$html = $highlighter->highlightHtml(
    '<pre><code class="language-php">&lt;?php echo "Hello";</code></pre>',
);
```

Highlight a raw code string by passing the language explicitly:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter();

$html = $highlighter->highlight('echo "Hello";', 'php');
```

Use a different default theme for a highlighter instance:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter('Solarized (dark)');
```

Or pass a theme for a single call:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter();

$html = $highlighter->highlight($code, 'php', 'base16-mocha.dark');
```

When no theme is specified, `InspiredGitHub` is used.

Themes available by default are:

- `base16-ocean.dark`
- `base16-eighties.dark`
- `base16-mocha.dark`
- `base16-ocean.light`
- `InspiredGitHub`
- `Solarized (dark)`
- `Solarized (light)`

You can also pass a `.tmTheme` file path as a theme name.

Use `class_exists(YiiPress\Highlighter::class)` to check whether the extension is loaded in the current PHP process.

## License

YiiPress Highlighter PHP Extension is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
