--TEST--
YiiPress\Highlighter rejects NUL bytes at the C string boundary
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

$highlighter = new Highlighter();

try {
    $highlighter->highlight("echo \"A\0B\";", 'php');
    ok(false, 'raw code NUL rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'Code input contains an unsupported NUL byte', 'raw code NUL rejected');
}

try {
    $highlighter->highlight('echo "Hello";', "p\0hp");
    ok(false, 'language NUL rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'Language input contains an unsupported NUL byte', 'language NUL rejected');
}

try {
    $html = '<pre><code class="language-php">echo &quot;A' . "\0" . 'B&quot;;</code></pre>';
    $highlighter->highlightHtml($html);
    ok(false, 'html NUL rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'HTML input contains an unsupported NUL byte', 'html NUL rejected');
}

try {
    $highlighter->highlight('echo "Hello";', 'php', "InspiredGitHub\0");
    ok(false, 'theme NUL rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'Highlight theme name contains an unsupported NUL byte', 'theme NUL rejected');
}
?>
--EXPECT--
ok raw code NUL rejected
ok language NUL rejected
ok html NUL rejected
ok theme NUL rejected
