<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Instant Mockup</title>
	<meta name="viewport" content="width=device-width">
	<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

body {
	text-align: center;
}
	</style>
</head>
<body>
<?php

// Read all the files in the current directory
$allFiles = scandir('.');

// Filter it so only images remain
foreach ($allFiles as $key => $file)
{
	if (!preg_match('/.+\.(jpg|jpeg|png|gif)$/i', $file))
	{
		unset($allFiles[$key]);
	}
}

// Check weather there are any images
if (empty($allFiles))
{
	die('No images found.');
}

// Sort them 'naturally'
sort($allFiles, SORT_NATURAL);

// Determining current, next, and last file index. First is 1.
$current = (isset($_GET['n']) && is_numeric($_GET['n'])) ? intval($_GET['n']) : 1;
$last = count($allFiles);
$next = ($current < $last) ? $current + 1 : 1; // Wrap-around

?>

<a href="?n=<?php echo $next;?>">
	<img src="<?php echo $allFiles[$current-1];?>" alt="<?php echo $allFiles[$current-1];?>">
</a>

</body>
</html>