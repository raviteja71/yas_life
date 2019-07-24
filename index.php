<?php
/**
 * Perform operations based on input
 *
 * This Class takes the user input and perform various operations like Comparing the COuntry langugaes
 * 	Get the countries list based on langugage code
 *	Countries list that shares similar language
 * @author     Ravi Teja <raviteja.muchintala@gmail.com>
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    1.0
 * @since      File available since Release 1.0
 */

namespace Yas\Index;

/**
 * This calss simplifies the Json results received based on 
 * 		user input
 *  
 * @see       https://restcountries.eu/
 * @since     Class available since Release 1.0
 */
class indexClass {
	/**
     * REST Url
     *
     * To get countries list
     *
     * @var string
     */
	CONST REST_URL = "https://restcountries.eu/rest/v2/";
	/**
	 *
	 * Send the args to related function based on number of args
	 *
	 * @param    array $arguments
	 * @return   null
	 *
	 */
	public function getResult($arguments) {
			$num_of_args = count($arguments);
			switch ($num_of_args) {
				case 2:
					return \Yas\Index\indexClass::getCountries($arguments[1]);
					break;
				case 3:
					return \Yas\Index\indexClass::compareCities($arguments[1], $arguments[2]);
					break;
				default:
					trigger_error("Invalid number of Arguments", E_USER_NOTICE);
					break;
			}
	}
	/**
	 *
	 * Reads the country name and provide the needed details
	 *
	 * @param    string $country
	 * @return   echo output
	 *
	 */
	public static function getCountries($country) {
		$url = \Yas\Index\indexClass::REST_URL."name/{$country}?fullText=true%27";
		$json_data = \Yas\Index\indexClass::getRestResult($url);
		if (!isset($json_data[0]->status)) {
			$lang_code = \Yas\Index\indexClass::getLanguageCodes($json_data[0]->languages);
			$similar_countries = \Yas\Index\indexClass::getSimilarCountries($lang_code, $json_data[0]->alpha2Code);
			$fText =  "Country language code(s): ".strtolower( implode(", ",  $lang_code))."\n";
			
			if ($similar_countries != NULL)
				$fText .= \Yas\Index\indexClass::makeUpper($country)." speaks same language with these countries: ".$similar_countries."\n";
			else
				$fText .= "No matches for Country ".\Yas\Index\indexClass::makeUpper($country);
		} else {
			$fText = "Not a valid Country name. Please check";
		}
		
		return $fText;
	}
	/**
	 *
	 * Reads the country name and provide countries list using same langugages
	 *
	 * @param    string $lang_code
	 * @return   string $scountries
	 *
	 */
	public static function getSimilarCountries($lang_codes, $cCode) {
		foreach($lang_codes as $lang_code) {
			$url = \Yas\Index\indexClass::REST_URL."lang/{$lang_code}";
			$json_data = \Yas\Index\indexClass::getRestResult($url);
			if (!isset($json_data[0]->status)) {
				foreach($json_data as $country) {
					if($country->alpha2Code != $cCode)
						$scountries[] = $country->name;
				}
			}
			$json_data = '';
		}
		
		return implode(", ",  $scountries);
	}
	
	/**
	 *
	 * Reads the country names and checks whether they had same langugage
	 *
	 * @param    strings $city1, city2
	 * @return   echo the output
	 *
	 */
	public static function getLanguageCodes($langugaes) {
		foreach ($langugaes as $lang) {
			$lang_array[] = $lang->iso639_1;
		}
		return $lang_array;
	}
	
	/**
	 *
	 * Reads the country names and checks whether they had same langugage
	 *
	 * @param    strings $city1, city2
	 * @return   echo the output
	 *
	 */
	public static function compareCities($city1, $city2) {
		$url1 = \Yas\Index\indexClass::REST_URL."name/{$city1}?fullText=true%27";
		$url2 = \Yas\Index\indexClass::REST_URL."name/{$city2}?fullText=true%27";
		
		$json_data1 = \Yas\Index\indexClass::getRestResult($url1);
		if (!isset($json_data1[0]->status)) {
			foreach ($json_data1 as $country1) {
				$lang_array1[] = $country1->languages[0]->iso639_1;
			}
		} else {
			return "First Country name paramter is not a valid value: {$city1}";
		}
		
		$json_data2 = \Yas\Index\indexClass::getRestResult($url2);
		if (!isset($json_data2[0]->status)) {
			foreach ($json_data2 as $country2) {
				$lang_array2[] = $country2->languages[0]->iso639_1;
			}
		} else {
			return "Second Country name paramter is not a valid value: {$city2}";
		}
		
		$final_array = array_intersect($lang_array1, $lang_array2);
		if (empty($final_array)) {
			$fText = "{$city1} and {$city2} do not speak the same language";
		} else {
			$fText = "{$city1} and {$city2} do speak the same language";
		}
		
		return $fText;
	}
	/**
	 *
	 * Perfomes CURL operations
	 *
	 * @param    string $url
	 * @return   Json object
	 *
	 */
	private static function getRestResult($url) {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
		$json = curl_exec($ch);
		if(!$json) {
			echo curl_error($ch);
		}
		curl_close($ch);
		
		$data = $json;
		//Get the first character.
		$firstCharacter = $data[0];
		if($firstCharacter == '{') {
			$data = "[".$data."]";
		}
		return json_decode($data);
	}
	/**
	 *
	 * Uses for string Capitalization
	 *
	 * @param    strings $arg
	 * @return   $arg
	 *
	 */
	public function makeUpper($arg) {
		return ucfirst($arg);
	}
}
/**
 * User inputs
 */
 if(isset($argv)) {
	$arguments = $argv;
	$output = \Yas\Index\indexClass::getResult($arguments);

	echo $output;
	echo "\n";
}


 
