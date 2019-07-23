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
 * User inputs
 */
$arguments = $argv;

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
					\Yas\Index\indexClass::getCountries($arguments[1]);
					break;
				case 3:
					\Yas\Index\indexClass::compareCities($arguments[1], $arguments[2]);
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
		$url = \Yas\Index\indexClass::REST_URL."name/{$country}?fullText=true";
		$json_data = \Yas\Index\indexClass::getRestResult($url);
		$lang_code = $json_data[0]->alpha2Code;
		$similar_countries = \Yas\Index\indexClass::getSimilarCountries($lang_code);
		echo "Country language code: ".strtolower($lang_code)."\n";
		echo \Yas\Index\indexClass::makeUpper($country)." speaks same language with these countries: ".$similar_countries."\n";
	}
	/**
	 *
	 * Reads the country name and provide countries list using same langugages
	 *
	 * @param    string $lang_code
	 * @return   string $scountries
	 *
	 */
	public static function getSimilarCountries($lang_code) {
		$url = \Yas\Index\indexClass::REST_URL."lang/{$lang_code}";
		$json_data = \Yas\Index\indexClass::getRestResult($url);
		foreach($json_data as $country) {
			$scountries[] = $country->name;
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
	public static function compareCities($city1, $city2) {
		$url1 = \Yas\Index\indexClass::REST_URL."name/{$city1}?fullText=true";
		$url2 = \Yas\Index\indexClass::REST_URL."name/{$city2}?fullText=true";
		
		$json_data1 = \Yas\Index\indexClass::getRestResult($url1);
		$json_data2 = \Yas\Index\indexClass::getRestResult($url2);
		
		foreach ($json_data1 as $country1) {
			$lang_array1[] = $country1->languages[0]->iso639_1;
		}
		
		foreach ($json_data2 as $country2) {
			$lang_array2[] = $country1->languages[0]->iso639_1;
		}
		$final_array = array_intersect($lang_array1, $lang_array1);
		if (empty($final_array)) {
			echo "{$city1} and {$city2} do not speak the same language";
			echo "\n";
		} else {
			echo "{$city1} and {$city2} do speak the same language";
			echo "\n";
		}
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
		return json_decode($json);
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


\Yas\Index\indexClass::getResult($arguments);


 
