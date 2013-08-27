<?php

Class regexp {

	/**
	* Validates a person code
	* @param string
	* @result bool
	*/
	static public function lvValidatePersonCode( $sInput ) {
		
		// First trim the input
		$sInput = trim($sInput, ' ');

		// Remove any possible spaces entered by mistake
		$sInput = str_replace(' ', '', $sInput);

		// Now let's use preg_match_all as it proves to be the fastest one in average use cases
		return (bool) preg_match_all('/[0-9]{6}\-[0-9]{5}/', $sInput, $aTmp);
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

}

?>
