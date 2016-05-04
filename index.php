<?php
	include 'functions/coreFunctions.php';

	$textbuilder = renderHeader();

	$textbuilder .= '

		<section class="content">
			<div class="container">
				<h1 class="text-center">Template your CV Online</h1>

				<div class="col-lg-6 col-centered">
					<form action="templateCV.php" method="post" enctype="multipart/form-data">
						<input type="file" name="uploadedFile" class="form-control id="fileToUpload" required="">
						<button class="btn btn-lg btn-primary btn-block" type="submit">Template my CV</button>
					</form>
					
					<ul class="files-container">
						<h2>See all created CV\'s</h2>';

						//scan the createdCV directory to get all file names
						$createdCV = scandir('createdCV/');
						//removing first 2 array indexes (. and ..)
						$createdCV = array_splice($createdCV, 2);

						if( count($createdCV) == 0 )
							$textbuilder .= 'Sorry! No available CV\'s';

						$counter = 0;
						foreach ($createdCV as $key => $value) {

							//formatting the file name (removing .html file and _)
							$name = str_replace('.html', '', $value);
							$name = str_replace('_', ' ', $name);
							$counter++;

							$textbuilder .= sprintf('<li>%d) <a href="createdCV/%s">%s</a></li>', $key+1, $value, $name);
						}

						$textbuilder .= '
					</ul>
					
					<p class="statistics text-right">' . count($createdCV) . ' CV\'s Generated</p>
				</div>
			</div>
		</section>

	';

	$textbuilder .= renderFooter();

	echo $textbuilder;

?>