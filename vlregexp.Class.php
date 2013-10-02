<?php

Class vlregexp {

	/**
	* Format a phone number in LV
	* @param string
	* @return string
	*/
	static public function lvFormatPhoneNumber( $sPhone ) {
		
		// First trim the input
		$sPhone = trim($sPhone, ' ');
		
		// Remove any other symbol that is not a number
		$sPhone = preg_replace('/[^0-9]/', '', $sPhone);
		
		// Now let us just seperate input
		return '+' . substr($sPhone, 0, 3) . ' ' . substr($sPhone, 3, strlen($sPhone));
	}
	
	/**
	* Validates a person code
	* @param string
	* @return bool
	*/
	static public function lvValidatePersonCode( $sInput ) {
		
		// First trim the input
		$sInput = trim($sInput, ' ');

		// Remove any possible spaces entered by mistake
		$sInput = str_replace(' ', '', $sInput);

		// Now let's use preg_match_all as it proves to be the fastest one in average use cases
		return (bool)preg_match_all('/[0-9]{6}\-[0-9]{5}/', $sInput, $aTmp);
	}

	/**
	* Forms a correct formed person code from input string, eather with or without spaces
	* Use the second parameters to turn it off as by default is is on
	* @param string
	* @param bool
	* @return string
	* @throws exception if input is insufficient
	*/
	static public function lvFormPersonCode( $sInput, $bSpaces = true ) {

		// bSpaces has to be bool
		$bSpaces = filter_var($bSpaces, FILTER_VALIDATE_BOOLEAN);

		// First trim the input
		$sInput = trim($sInput, ' ');

		// Remove any irrelevant chars
		$sInput = preg_replace('/[^0-9]/', '', $sInput);

		// Initiate temp array / unset is useless becouse function contents are unset automatically afterwards
		$aTmp = array();

		// Now let us get the first 6 numbers and next 5 numbers from the input and ignore the rest
		if( !preg_match_all('/[0-9]{11}/', $sInput, $aTmp) ) {
			throw new Exception('Input insufficient - not enough numbers', 500);
		}
		$iFirst = substr($aTmp[0][0], 0, 6);
		$iLast = substr($aTmp[0][0], 6, 5);

		// Let us form and return the result
		return $bSpaces ? $iFirst . ' - ' . $iLast : $iFirst . '-' . $iLast;
	}

	/**
	* Split URL sectors into array
	* @param string
	* @return array
	*/
	static public function gsplitURLSectors( $sUrl ) {

		// Trim input
		$sUrl = trim($sUrl, ' ');

		// Initiate temp array / unset is useless becouse function contents are unset automatically afterwards
		$aTmp = array();

		// If full url given remove root
		preg_match_all('/[^ \#\?]*/', preg_replace('/http[^ \/]*\/{2}[^ \/]*\//', '', $sUrl), $aTmp);
		$sUrl = $aTmp[0][0];

		// Return exploded array
		return explode('/', $sUrl);
	}

}

?>
