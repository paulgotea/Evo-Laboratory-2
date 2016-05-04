<?php

	/**
	 * Get the absolute path of the project
	 * @param type $data
	 * @return (string) with absolute path
	*/
	function mainURL() {
		return 'http://localhost/lab2/';
	}

	/**
	 * Get only a section from a multidimensional array (used for sections)
	 * @param (string) $data - multidimensional array
	 * @param (string) $section - name of the section that you want to get from $data array
	 * @return (array) with the wanted section
	*/
	function getSection($data, $section) {
		$section = strtoupper($section);
		return $data[$section];
	}

	/**
	 * Read the imported CV file (usually a .txt) and fetching the information line by line
	 * @param (string) $file - uploaded file as CV
	 * @return (array) $data with the information from file fetched, line by line
	*/
	function readCV($file) {
		//reading the content file
		$content = file_get_contents($file);
		$lines = explode(PHP_EOL, $content);

		$data = array();

		//fetching the contents between sections
		foreach ($lines as $line) {
			$line = trim($line);

			//verify if the whole row isn't uppercase;
			if( !preg_match('/^\p{Lu}+$/u', $line) ) {
				$data[$key][] = $line;
				continue;
			}
			
			$key = $line;
		}

		return $data;
	}


	/**
	 * Read the HTML templated used for CV
	 * @return (string) $content with the whole content of the template (templates/template.txt)
	*/
	function readTemplate() {
		$content = file_get_contents(mainURL().'templates/template.txt');
		return $content;
	}


	/**
	 * Create and save a HTML file with the CV templated
	 * @param (string) $fileName - wanted name in order to save the file
	 * @param (string) $content - wanted content that you want to be in the saved file
	*/
	function createHTMLFile($fileName, $content) {
		$fileName = str_replace(' ', '', $fileName);
		$handle = fopen('createdCV/'.$fileName.'.html', 'w');

		fwrite($handle, $content);
		fclose($handle);

		header('Location: createdCV/'.$fileName.'.html');
	}

	/**
	 * Render the Header of the website
	 * @return (string) $textbuilder - contains the header of the website
	*/
	function renderHeader() {
		$textbuilder = '
		<!DOCTYPE html>

		<html lang="en">

			<head>
				<meta charset="utf-8">

				<title>Online CV Generator</title>

				<!-- Bootstrap -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

				<!-- CSS -->
				<link href="'.mainURL().'/css/style.css" rel="stylesheet">

				<!-- Google Fonts -->
				<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
			</head>
			<body>';

		return $textbuilder;
	}

	/**
	 * Render the Footer of the website
	 * @return (string) $textbuilder - contains the footer of the website
	*/	
	function renderFooter() {
		$textbuilder = '
			<img src="'.mainURL().'img/people.png" class="img-responsive center-block" />

			<footer>
				<p>Copyright © Paul Gotea - Evozon PHP Internship</p>
			</footer>

			</body>
			</html>
		';
		return $textbuilder;
	}


?>