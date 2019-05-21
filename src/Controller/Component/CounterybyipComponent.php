<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * UUID component
 *Get user id by uuid
 */
class CounterybyipComponent extends Component {
	public $components = ['Language'];
	// public function initialize() {
	// 	parent::initialize();
	// 	$this->loadComponent('Language');

	// 	//$this->loadComponent('RequestHandler');
	// }

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function databyip($purpose = "location", $deep_detect = TRUE) {
		$ip = $_SERVER["REMOTE_ADDR"];
		//global $sitepress;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				}

				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				}

			}
		}
		$purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support = array("country", "countrycode", "state", "region", "city", "location", "address");
		//$continents = configure::read('continents');
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . '122.161.192.39' /*$ip*//*'89.18.172.65','122.161.192.39'*/));
			// if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
			$output['country_code'] = @$ipdat->geoplugin_countryCode;
			$output['currency_symbol'] = @$ipdat->geoplugin_currencySymbol_UTF8;
			$output['currency_converter'] = @$ipdat->geoplugin_currencyConverter;
			$output['currency_converter'] = @$ipdat->geoplugin_currencyConverter;
			$output['currency_code'] = @$ipdat->geoplugin_currencyCode;
			$output['timezone'] = @$ipdat->geoplugin_timezone;
			$output['countryName'] = @$ipdat->geoplugin_countryName;
			$output['currency_symbol'] = @$ipdat->geoplugin_currencySymbol;
			$output['currency_converte'] = @$ipdat->geoplugin_currencyConverte;
			$contientcode = strtolower(trim($ipdat->geoplugin_continentCode));
			$output['continent_code'] = $contientcode;
			$output['timezone'] = trim($ipdat->geoplugin_timezone);
			//}
		}
		$lang = $this->Language->country2locale($output['country_code']);
		$language_array = ['nl' => 'Dutch', 'en' => 'English', 'de' => 'German'];
		if ($output['currency_code'] == 'USD') {
			$currency_code = [$output['currency_symbol'] => $output['currency_code']];
			$currency_converter = '';
		} else {
			$currency_code = [$output['currency_symbol'] => $output['currency_code'], '$' => 'USD'];
			$currency_converter = $output['currency_converter'];
		}

		return $output;

	}

}
