--TEST--
YiiPress\Highlighter supports .tmTheme file paths
--EXTENSIONS--
highlighter
--SKIPIF--
<?php if (!extension_loaded('highlighter')) die('skip highlighter extension not loaded'); ?>
--FILE--
<?php
use YiiPress\Highlighter;

function ok(bool $condition, string $message): void
{
    echo ($condition ? 'ok ' : 'not ok ') . $message . "\n";
}

$theme = __DIR__ . '/fixtures/custom.tmTheme';
$highlighter = new Highlighter($theme);
$code = 'echo "File Theme";';

$raw = $highlighter->highlight($code, 'php');
$html = (new Highlighter())->highlightHtml(
    '<pre><code class="language-php">echo &quot;File Theme&quot;;</code></pre>',
    $theme,
);
$default = (new Highlighter())->highlight($code, 'php');

ok($raw !== $default, 'custom theme file changes raw output');
ok(strpos($raw, '#fee715') !== false, 'raw output uses theme foreground');
ok(strpos($html, '#fee715') !== false, 'html output uses theme foreground');
ok(strpos($html, 'File Theme') !== false, 'html output preserves code text');
?>
--EXPECT--
ok custom theme file changes raw output
ok raw output uses theme foreground
ok html output uses theme foreground
ok html output preserves code text
