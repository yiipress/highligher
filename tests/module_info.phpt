--TEST--
highlighter exposes module info
--EXTENSIONS--
highlighter
--SKIPIF--
<?php if (!extension_loaded('highlighter')) die('skip highlighter extension not loaded'); ?>
--FILE--
<?php
ob_start();
phpinfo(INFO_MODULES);
$info = ob_get_clean();
$version = phpversion('highlighter');
$expectedVersion = getenv('HIGHLIGHTER_VERSION') ?: $version;

echo strpos($info, 'YiiPress highlighter support') !== false ? "ok support row\n" : "not ok support row\n";
echo $version === $expectedVersion ? "ok phpversion\n" : "not ok phpversion\n";
echo strpos($info, 'Version') !== false && strpos($info, $expectedVersion) !== false ? "ok version row\n" : "not ok version row\n";
?>
--EXPECT--
ok support row
ok phpversion
ok version row
