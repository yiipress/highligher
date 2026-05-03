--TEST--
YiiPress\Highlighter supports explicit and default themes
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

$code = 'echo "Theme";';
$default = (new Highlighter())->highlight($code, 'php');
$explicitDefault = (new Highlighter('InspiredGitHub'))->highlight($code, 'php');
$dark = (new Highlighter())->highlight($code, 'php', 'Solarized (dark)');
$defaultFromConstructor = (new Highlighter('Solarized (dark)'))->highlight($code, 'php');
$override = (new Highlighter('Solarized (dark)'))->highlight($code, 'php', 'InspiredGitHub');

ok($default === $explicitDefault, 'constructor default is InspiredGitHub');
ok($default !== $dark, 'explicit theme changes output');
ok($dark === $defaultFromConstructor, 'constructor default theme is used');
ok($override === $default, 'method theme overrides constructor default');
?>
--EXPECT--
ok constructor default is InspiredGitHub
ok explicit theme changes output
ok constructor default theme is used
ok method theme overrides constructor default
