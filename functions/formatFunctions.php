<?php

	
	/**
	 * Format the name section lines
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) - new data - contains all data formated
	*/
	function formatNameSection($data) {

		//make the last name uppercase
		$newData['name'] = strtoupper($data[0]);

		//make only the first letter of first name uppercase and others lower
		$newData['firstname'] = ucwords(strtolower($data[1]));

		//check if a job exists or not
		if( !isset($data[2]) )
			$newData['job'] = 'No current job!';

		else 
			$newData['job'] = ucwords(strtolower($data[2]));

		return $newData;
	}


	/**
	 * Format the address section lines
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) - new data - contains all data formated
	*/
	function formatAddressSection($data) {

		$newData = array();

		//getting all the sub sections (rows)
		foreach ($data as $fetch) {
			$informationArray[] = explode(':', $fetch);
		}

		//generating the new array with all elements, one by one, from every Sub Section (row)
		foreach ($informationArray as $fetch) {
			$informationKey = strtolower($fetch[0]); //key of the array
			$newData[$informationKey] = formatInformation($fetch[1]);
		}

		//check if address/email exists - if not, show a warning message
		if( !array_key_exists('address', $newData) ) {
			$newData['address'] = 'Adress does not exist!';
		}
		if( !array_key_exists('email', $newData) ) {
			$newData['email'] = 'Email does not exist!';
		}
		else {
			//check if the email exists and then, if yes, verify it
			$newData['email'] = checkEmail($newData['email']);
		}


		return $newData;
	}

	/**
	 * Format the social section lines
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) - new data - contains all data formated
	*/
	function formatSocialSection($data) {

		$newData = array();

		//getting all the sub sections (rows)
		foreach ($data as $fetch) {
			$informationArray[] = explode(':', $fetch);
		}

		//generating the new array with all elements, one by one, from every Sub Section (row)
		foreach ($informationArray as $fetch) {

			$informationKey = strtolower($fetch[0]); //key of the array
			$newData[$informationKey] = explode(',', $fetch[1]);
		}

		return $newData;
	}

	/**
	 * Format the work section lines
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) - new data - contains all data formated
	*/
	function formatWorkSection($data) {

		$newData = array();

		foreach ($data as $fetch) {
			$years = explode('- ', $fetch);

			//jump over description, we don-t need it
			if( count($years)>1 ) {
				$company = explode(' ', $years[1]);
				$newData[$company[1]] = array();
				$newData[$company[1]][] = $years[0];
				$newData[$company[1]][] = $company[0];
				
			}
		}

		return $newData;
	}

	/**
	 * Format the information data (removing some words, arange words letters, etc)
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) $formatedData - contains all data formated
	*/
	function formatInformation($data) {
		$formatedData = explode(',', $data);

		//removing the Address: / Phone: / etc... words from the line start
		$explode = explode(':', $formatedData[0]);
		$formatedData[0] = str_replace($explode[0].':', '',$formatedData[0]);

		//arrange words letter for every word
		$formatedData = arrangeWordsCase($formatedData);
		return $formatedData;
	}

	/**
	 * Format the words letters
	 * @param (array) $data - contains all information that must be formated
	 * @return (array) $arrangedWords - contains all $data formated
	*/
	function arrangeWordsCase($data) {
		$arrangedWords = array();

		foreach ($data as $value) {
			$value = ucwords(strtolower($value));
			array_push($arrangedWords, $value);
		}

		return $arrangedWords;
	}



	/**
	 * Check if the E-mail is valid
	 * @param (string) $email - contains the email value
	 * @return (string) - e-mail formated with lower cases
	*/
	function checkEmail($email) {

		//check if the email is text@text (simple validation)
		if( !preg_match('/[\w.]+@+[\w.]+/', $email[0]) )
			return 'E-mail is not valid!';

		return strtolower($email[0]);
	}

	/**
	 * Replace the placeholders from HTML template with clear values from imported CV file
	 * @param (string) $template - HTML template used for CV
	 * @param (string) $nameSection - name section (contains information about name)
	 * @param (string) $addressSection - address section (contains information about adress)
	 * @param (string) $socialSection - social section (contains information about social media)
	 * @param (string) $workSection - work section (contains information about work experience, jobs)
	 * @return (string) $template - returns the new template with the placeholders replaced
	*/
	function replacePlaceholders($template, $nameSection, $addressSection, $socialSection, $workSection ) {

		//replace first name placeholder
		$template = preg_replace('/{firstname}/', getName($nameSection), $template);
		//replace last name placeholder
		$template = preg_replace('/{lastname}/', getFirstName($nameSection), $template);

		//replace address placeholder
		$address = getAddress($addressSection);
		$fullAddress = '';

		foreach ($address as $fetch) {
			$fullAddress .= $fetch . ' ';
		}
		$template = preg_replace('/{address}/', $fullAddress, $template);


		//replace phone placeholder
		$phone = getPhone($addressSection);
		$allPhones = '';

		foreach ($phone as $fetch) {
			$allPhones .= $fetch . ' ';
		}
		$template = preg_replace('/{phone}/', $allPhones, $template);


		//replace phone placeholder
		$template = preg_replace('/{email}/', getEmail($addressSection), $template);

		//replace social media placeholder
		$social = getSocialMedia($socialSection);

		$allSocials = '';
		foreach ($social as $key => $socialName) {
			//make the first letter uppercase
			$allSocials .= sprintf('<strong>%s</strong>', ucfirst($key));

			foreach ($socialName as $accountName) {
				$allSocials .= $accountName . ' ';
			}
		}
		
		$template = preg_replace('/{social}/', $allSocials, $template);


		//replace work placeholder
		$work = $workSection;
		$allWorkExperience = '';

		foreach ($work as $key => $value) {
			$allWorkExperience .= sprintf('%s %d - %d (%d years experience) <br>', $key, $value[0], $value[1], ($value[1]-$value[0]));
		}

		$template = preg_replace('/{work}/', $allWorkExperience, $template);

		return $template;
	}



?>