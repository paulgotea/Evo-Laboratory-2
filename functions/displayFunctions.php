<?php


	/**
	 * Get the name from choosed section of data
	 * @param (string) $section - choosed section
	 * @return (sring) - the value from choosed $section where the key is 'name'
	*/
	function getName($section) {
		return $section['name'];
	}

	/**
	 * Get the first name from choosed section of data
	 * @param (string) $section - choosed section 
	 * @return (sring) - the value from choosed $section where the key is 'firstname'
	*/
	function getFirstName($section) {
		return $section['firstname'];
	}

	/**
	 * Get the job from choosed section of data
	 * @param (string) $section - choosed section 
	 * @return (sring) - the value from choosed $section where the key is 'job'
	*/
	function getJob($section) {
		return $section['job'];
	}

	/**
	 * Get the email from choosed section of data
	 * @param (string) $section - choosed section 
	 * @return (sring) - the value from choosed $section where the key is 'email'
	*/
	function getEmail($section) {
		return $section['email'];
	}

	/**
	 * Get the adress (street, town, state, country or full address) from choosed section of data
	 * @param (string) $section - choosed section 
	 * @param (string) $option - choose what type of address you want (street/ town/ state/ country or fullAddress)
	 * @return (sring) - the value from choosed $section where the key is choosed option
	*/
	function getAddress($section, $option = 'fullAddress') {
		switch ($option) {
			case 'street':
				return $section['address'][0];
				break;
			case 'town':
				return $section['address'][1];
				break;		
			case 'state':
				return $section['address'][2];
				break;
			case 'country':
				return $section['address'][3];
				break;
			case 'fullAddress';
				return $section['address'];
				break;
				//default
		}
	}

	/**
	 * Get the phone from choosed section of data
	 * @param (string) $section - choosed section 
	 * @return (sring) - the value from choosed $section where the key is 'phone'
	*/
	function getPhone($section) {
		return $section['phone'];
	}

	/**
	 * Get the work from choosed section of data
	 * @param (string) $section - choosed section 
	 * @return (sring) - the value from choosed $section where the key is 'work'
	*/
	function getWork($section) {
		return $section['work'];
	}		

	/**
	 * Get the Social Media from choosed section of data
	 *
	 * @param (string) $section - choosed section 
	 * @param (string) $name - if you know exactly what social media network you want to get
	 * @return (array) - contains the social media netowrks => user accounts 
	*/
	function getSocialMedia($section, $name = '') {
		if( isset($name) && !is_null($name) && !empty($name) ) {
			return $section[$name];
		}
		return $section;
	}

?>