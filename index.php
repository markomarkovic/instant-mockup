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
		/**
		* Scan current directory and prepare
		* array to hold list of files.
		*/
		$filesInCurrentFolder = scandir('.');
		$filteredFiles = array();

		/**
		* Valid:
		* 0.jpg
		* 01.jpg
		* 1.jpg
		* 10.jpg
		* 1 foo bar.jpg
		*
		* Invalid:
		* foo.jpg
		* 012 foo bar.jpg
		*/
		foreach ($filesInCurrentFolder as $file) {
			if( preg_match( '/^([0-9]|[0-9][0-9]).*(\.jpg)$/i', $file ) ) {
				$filteredFiles[] = $file;
			}
		}

		/**
		* If there are no .jpg images
		* then just print error message
		*/
		if( empty( $filteredFiles ) ) {
			echo '<h1>No images found!</h1>';
		} else {
			/**
			* Sort filtered files so this list:
			* 1, 11, 12, 2, 3
			* becomes this list:
			* * 1, 2, 3, 11, 12
			*/
			sort( $filteredFiles, SORT_NUMERIC );

			// get index of last element in filtered files array
			$indexOfLastFilteredFile = key(array_slice($filteredFiles, -1, 1, TRUE));

			/**
			* Get URI and set requested image id
			*/
			$uri = $_SERVER["REQUEST_URI"];

			$explodedUri = explode( '/', $uri );

			$requestedImageId = $explodedUri[ key(array_slice( $explodedUri, -1, 1, TRUE)) ];

			/**
			* If requested image id matches one digit(without
			* leading zero) or two digits AND if requested
			* image id exists in $filteredFiles continue
			* else show error message.
			*/
			if( preg_match( '/^([1-9]|[1-9][0-9])$/', $requestedImageId ) && array_key_exists($requestedImageId - 1, $filteredFiles) ) {
				/**
				* Check if requested file is actually last file
				* and if so link last image to first image.
				*/
				if( $indexOfLastFilteredFile == $requestedImageId - 1 ) {
					echo '<a href="1"><img src="' . $filteredFiles[$requestedImageId - 1] . '" alt=""></a>';
				} else {
					echo '<a href="' . ($requestedImageId + 1) . '"><img src="' . $filteredFiles[$requestedImageId - 1] . '" alt=""></a>';
				}
			} else {
				if( $requestedImageId == '' ) {
					echo '<a href="2"><img src="' . $filteredFiles[0] . '" alt=""></a>';
				} else {
					echo '<h1>ERROR!</h1>';
				}
			}
		}
	?>
</body>
</html>