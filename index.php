<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Instant Mockup</title>
	<meta name="viewport" content="width=device-width">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
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

// Determining current, previous, next, and last file index. First is 1.
$current = (isset($_GET['n']) && is_numeric($_GET['n'])) ? intval($_GET['n']) : 1;
$last = count($allFiles);
$next = ($current < $last) ? $current + 1 : 1; // Wrap-around
$previous = ($current > 1) ? $current - 1 : $last; // Around-wrap

?>

		<div class="pagination">
			<ul>
				<li><a href="?n=<?php echo $previous;?>">Prev</a></li>
				<?php for ($i = 1; $i <= $last; $i++):?>
					<li class="<?php echo ($i == $current) ? 'active' : '';?>"><a href="?n=<?php echo $i;?>"><?php echo $i;?></a></li>
				<?php endfor;?>
				<li><a href="?n=<?php echo $next;?>">Next</a></li>
			</ul>
		</div>

		<a href="?n=<?php echo $next;?>">
			<img src="<?php echo $allFiles[$current-1];?>" alt="<?php echo $allFiles[$current-1];?>">
		</a>

	</div>
</body>
</html>
