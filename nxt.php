<?php
//TODO require git.

$output = shell_exec('git tag  -l --sort=v:refname');
if($output == null) {
	echo "[nxt] No tags found. Maybe go for 1.0.0?";
	exit();
}

$tags = explode(PHP_EOL, $output);


// TODO: improve sort
#sort($tags);
$tags = array_filter($tags);
$last = end($tags);
// possible improvement: https://github.com/z4kn4fein/php-semver 
echo count($tags);
if (count($tags) <= 0) {
	die();
}

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

// test witj VX.Y.Z
// if XXX/tag , next = XXX/newtag
//if RC -> dont add 1, remove the RC.
$nextmajor = (int)$major + 1  . ".0.0";
$nextminor = $major . '.' . ((int)$minor + 1) . '.0';
$nextpatch = $major . '.' . $minor . '.' .((int)$patch + 1);

// Output next version suggestions.
echo PHP_EOL."[nxt] Last tag seems like $last" . PHP_EOL;
echo "[nxt] Next patch is $nextpatch" . PHP_EOL;
echo "[nxt] Next minor is $nextminor" . PHP_EOL;
echo "[nxt] Next major is $nextmajor" . PHP_EOL;