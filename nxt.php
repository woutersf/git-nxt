<?php
//TODO require git.

$semver_pattern = '/(\w*\/)?(v)?(\d+)\.(\d+)\.(\d+)(\-\w*\.\d)?/';

function sort_versions($a, $b)
{
	$semver_pattern = '/(\w*\/)?(v)?(\d+)\.(\d+)\.(\d+)(\-\w*\.\d)?/';
    if ($a == $b) {
        return 0;
    }

	preg_match($semver_pattern, $a, $matches);
	$prefix = '';
	if (isset($matches[1])) {
		$prefix = $matches[1];	
	}
	if (isset($matches[2])) {
		$textualprefix = $matches[2];
	}
	$major = (int) $matches[3];
	$minor = (int) $matches[4];
	$patch = (int) $matches[5];


	preg_match($semver_pattern, $b, $bmatches);

	$bprefix = '';
	if (isset($bmatches[1])) {
		$bprefix = $bmatches[1];	
	}
	if (isset($bmatches[2])) {
		$textualprefix = $bmatches[2];
	}
	$bmajor = (int) $bmatches[3];
	$bminor = (int) $bmatches[4];
	$bpatch = (int) $bmatches[5];

	if ($major < $bmajor) {return  -1; };
	if ($major > $bmajor) {return  1 ;};

	if ($minor < $bminor) {return  -1 ;};
	if ($minor > $bminor) {return  1 ;};

	if ($patch < $bpatch) {return  -1 ;};
	if ($patch > $bpatch) {return  1 ;};
	
    return ($a < $b) ? -1 : 1;
}

$output = shell_exec('git tag  -l --sort=v:refname');
if($output == null) {
	echo "[nxt] No tags found. Maybe go for 1.0.0?";
	exit();
}

$tags = explode(PHP_EOL, $output);


// TODO: improve sort
usort($tags, 'sort_versions');
echo "sorted:";
print_r($tags);
$tags = array_filter($tags);
$last = end($tags);
// possible improvement: https://github.com/z4kn4fein/php-semver 
//echo count($tags);
if (count($tags) <= 0) {
	die();
}

// For debugging: 
echo "[nxt] List of current tags:" . PHP_EOL;
foreach ($tags as $tag) {
	echo " $tag  ";	
}

// Create next version suggestions
// TODO: improve to use official REGEX
// https://regex101.com/r/Ly7O1x/3/
// from https://semver.org/

preg_match($semver_pattern, $last, $matches);
$prefix = '';
if (isset($matches[1])) {
	$prefix = $matches[1];	
}
$textualprefix = $matches[2];
$major = $matches[3];
$minor = $matches[4];
$patch = $matches[5];
$suffix = '';
if (isset($matches[6])) {
	$suffix = $matches[6];	
}
//print_r($matches);
if (str_contains($suffix, 'rc')) {
	// Dont increment version
	preg_match ('/-(\w+)\.(\d)/',$suffix, $rc_matches);
	//print_r($rc_matches);
	$num = (int) $rc_matches[2];

	$nextrc = $prefix . $textualprefix . $major . '.' . $minor . '.' . $patch . '-' . $rc_matches[1] . '.' .($num + 1);
	$nextmajor = $prefix . $textualprefix . $major . '.' . $minor . '.' .$patch;
	// Output next version suggestions.
	echo PHP_EOL."[nxt] Last tag seems like $last" . PHP_EOL;
	echo "[nxt] Next release candidate is $nextrc" . PHP_EOL;
	echo "[nxt] Next major is $nextmajor" . PHP_EOL;

}else{

	// increment version
	

	//if RC -> dont add 1, remove the RC.
	$nextmajor = $prefix . $textualprefix .(int)$major + 1  . ".0.0";
	$nextminor = $prefix . $textualprefix . $major . '.' . ((int)$minor + 1) . '.0';
	$nextpatch = $prefix . $textualprefix . $major . '.' . $minor . '.' .((int)$patch + 1);
	// Output next version suggestions.
	echo PHP_EOL."[nxt] Last tag seems like $last" . PHP_EOL;
	echo "[nxt] Next patch is $nextpatch" . PHP_EOL;
	echo "[nxt] Next minor is $nextminor" . PHP_EOL;
	echo "[nxt] Next major is $nextmajor" . PHP_EOL;

}

