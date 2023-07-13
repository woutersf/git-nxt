<?php
//TODO require git.

$output = shell_exec('git tag');
$tags = explode(PHP_EOL, $output);

// TODO: improve sort
sort($tags);
$last = end($tags);
// possible improvement: https://github.com/z4kn4fein/php-semver 

// For debugging: 
echo "[nxt] List of current tags:" . PHP_EOL;
foreach ($tags as $tag) {
	echo " $tag  ";	
}

// Create next version suggestions
$pattern = '/(\d)*\.(\d)*\.(\d)*/';
preg_match($pattern, $last, $matches);
$major = $matches[1];
$minor = $matches[2];
$patch = $matches[3];
$nextmajor = (int)$major + 1  . ".0.0";
$nextminor = $major . '.' . ((int)$minor + 1) . '.0';
$nextpatch = $major . '.' . $minor . '.' .((int)$patch + 1);

// Output next version suggestions.
echo "[nxt] Last tag seems like $last" . PHP_EOL;
echo "[nxt] Next patch is $nextpatch" . PHP_EOL;
echo "[nxt] Next minor is $nextminor" . PHP_EOL;
echo "[nxt] Next major is $nextmajor" . PHP_EOL;