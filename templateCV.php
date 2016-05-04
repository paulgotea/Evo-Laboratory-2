<?php

	//includes
	include 'functions/coreFunctions.php';
	include 'functions/formatFunctions.php';
	include 'functions/displayFunctions.php';


	//verify if the CV was uploaded or not
	if( !isset($_FILES['uploadedFile']['tmp_name']) || empty($_FILES['uploadedFile']['tmp_name']) || mime_content_type($_FILES['uploadedFile']['tmp_name']) != 'text/plain' ) {
		header('Location: index.php');
		exit;
	}


	//grab the uploaded file and read it
	$data = readCV($_FILES['uploadedFile']['tmp_name']);

	//divide the whole CV data into sections
	$nameSection = getSection($data, 'name');
	$addressSection = getSection($data, 'address');
	$socialSection = getSection($data, 'social');
	$workSection = getSection($data, 'work');

	//formatting each sections
	$nameSection = formatNameSection($nameSection);
	$addressSection = formatAddressSection($addressSection);
	$socialSection = formatSocialSection($socialSection);
	$workSection = formatWorkSection($workSection);

	//reading the template used for generating HTML files
	$template = readTemplate();
	$template = replacePlaceholders($template, $nameSection, $addressSection, $socialSection, $workSection);

	//render the HTML Header
	$textbuilder = renderHeader();

	//getting the HTML Body
	$textbuilder .= '

		<section class="content">
			<div class="container">
				<div class="col-lg-8 col-centered text-left">
					' . $template . '
				</div>
			</div>
		</section>';

	//render the HTML Footer
	$textbuilder .= renderFooter();

	//create and Save the HTML File
	createHTMLFile(getName($nameSection) . '_' . getFirstName($nameSection), $textbuilder);
	
?>