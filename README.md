<p align="center">
    <a href="https://github.com/yiipress" target="_blank">
        <img src="./logo.svg" height="100px" alt="YiiPress Highlighter">
    </a>
    <h1 align="center">YiiPress Highlighter PHP Extension</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiipress/highlighter/v)](https://packagist.org/packages/yiipress/highlighter)
[![Total Downloads](https://poser.pugx.org/yiipress/highlighter/downloads)](https://packagist.org/packages/yiipress/highlighter)
[![Tests](https://github.com/yiipress/highligher/actions/workflows/tests.yml/badge.svg)](https://github.com/yiipress/highligher/actions/workflows/tests.yml)
[![Windows](https://github.com/yiipress/highligher/actions/workflows/windows.yml/badge.svg)](https://github.com/yiipress/highligher/actions/workflows/windows.yml)

The package provides a native PHP extension for fast server-side syntax highlighting powered by
[syntect](https://github.com/trishume/syntect/).

## Requirements

- PHP 8.1 - 8.5.
- [PIE](https://github.com/php/pie) to install the extension.
- On Linux and macOS: `cargo`, `phpize`, `php-config`, C compiler, and `make`.

Prebuilt Windows DLLs are attached to GitHub releases.

## Installation

Install the extension with PIE:

```shell
pie install yiipress/highlighter
```

PIE installs the native extension into the target PHP installation. If the extension is not enabled automatically, add it
to your `php.ini`:

```ini
extension=highlighter
```

In an application, use Composer to declare that the extension must be available:

```shell
composer require ext-highlighter:*
```

Composer does not build or enable native PHP extensions, so `composer require yiipress/highlighter` is not an
installation substitute for PIE.

## General usage

Highlight an HTML fragment containing code blocks in the form
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

Highlight a raw code string by passing the language name explicitly:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter();

$html = $highlighter->highlight('echo "Hello";', 'php');
```

Set a different default theme for a highlighter instance:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter('Solarized (dark)');
```

Pass a theme for a single call:

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

You can also pass a `.tmTheme` file path as a theme name:

```php
<?php

declare(strict_types=1);

use YiiPress\Highlighter;

$highlighter = new Highlighter('/path/to/theme.tmTheme');
```

Use `class_exists(YiiPress\Highlighter::class)` to check whether the extension is loaded in the current PHP process.

## Release

To publish a release, push the release tag, for example `git tag 1.0.3 && git push origin 1.0.3`.
Do not create releases manually from the GitHub UI: immutable releases require the tag-driven workflow so release assets
can be attached by CI.

## License

YiiPress Highlighter PHP Extension is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
