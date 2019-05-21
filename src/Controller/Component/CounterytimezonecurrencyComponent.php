<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * UUID component
 *Get user id by uuid
 */
class CounterytimezonecurrencyComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function countryregioncode($code, $region) {

		if ($code == NULL) {
			return NULL;
		}
		if ($region == NULL) {
			$region = "";
		}
		if ($code == "AD") {
			$timezone = [
				'timezone' => "Europe/Andorra",
				'currency' => '',
				'currency_code' => '',
			];
			$currency = "EUR";
		} else if ($code == "AE") {
			$timezone = [
				'timezone' => "Asia/Dubai",
				'currency' => "EUR",
				'currency_symbol' => "&#8364;",
			];
		} else if ($code == "AF") {
			$timezone = [
				'timezone' => "Asia/Kabul",
				'currency' => "AED",
				'currency_symbol' => "&#1583;.&#1573;",
			];
		} else if ($code == "AG") {
			$timezone = [
				'timezone' => "America/Antigua",
				'currency' => "XCD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "AI") {
			$timezone = [
				'timezone' => "America/Anguilla",
				'currency' => "XCD",
				'currency_symbol' => "&#36;"];
		} else if ($code == "AL") {
			$timezone = [
				'timezone' => "Europe/Tirane",
				'currency' => "ALL",
				'currency_symbol' => "&#76;&#101;&#107;",
			];
		} else if ($code == "AM") {
			$timezone = [
				'timezone' => "Asia/Yerevan",
				'currency' => "AMD",
				'currency_symbol' => "&#1423;",
			];
		} else if ($code == "AO") {
			$timezone = [
				'timezone' => "Africa/Luanda",
				'currency' => "AOA",
				'currency_symbol' => "&#75;&#122;",
			];
		} else if ($code == "AR") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "America/Argentina/Catamarca",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "America/Argentina/Tucuman",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "America/Argentina/Rio_Gallegos",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "America/Argentina/Cordoba",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "America/Argentina/Tucuman",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "America/Argentina/Tucuman",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "America/Argentina/Jujuy",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "America/Argentina/San_Luis",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "America/Argentina/La_Rioja",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "America/Argentina/Mendoza",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "America/Argentina/San_Luis",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "America/Argentina/Salta",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "America/Argentina/San_Juan",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "America/Argentina/San_Luis",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "America/Argentina/Rio_Gallegos",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "America/Argentina/Buenos_Aires",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "America/Argentina/Catamarca",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "America/Argentina/Ushuaia",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "America/Argentina/Tucuman",
					'currency' => "ARS",
					'currency_symbol' => "&#36;",
				];
			}
		} else if ($code == "AS") {
			$timezone = [
				'timezone' => "US/Samoa",
				'currency' => "USD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "AT") {
			$timezone = [
				'timezone' => "Europe/Vienna",
				'currency' => "EUR",
				'currency_symbol' => "&#8364;",
			];
		} else if ($code == "AU") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Australia/Canberra",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Australia/NSW",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Australia/North",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Australia/Queensland",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Australia/South",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Australia/Tasmania",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Australia/Victoria",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Australia/Queensland",
					'currency' => "AUD",
					'currency_symbol' => "&#36;",
				];
			}
		} else if ($code == "AW") {
			$timezone = [
				'timezone' => "America/Aruba",
				'currency' => "AWG",
				'currency_symbol' => "&#402;",
			];
		} else if ($code == "AX") {
			$timezone = [
				'timezone' => "Europe/Mariehamn",
				'currency' => "EUR",
				'currency_symbol' => "&#8364;",
			];
		} else if ($code == "AZ") {
			$timezone = [
				'timezone' => "Asia/Baku",
				'currency' => "AZN",
				'currency_symbol' => "&#1084;&#1072;&#1085;",
			];
		} else if ($code == "BA") {
			$timezone = [
				'timezone' => "Europe/Sarajevo",
				'currency' => "BAM",
				'currency_symbol' => "&#75;&#77;",
			];
		} else if ($code == "BB") {
			$timezone = [
				'timezone' => "America/Barbados",
				'currency' => "BBD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "BD") {
			$timezone = [
				'timezone' => "Asia/Dhaka",
				'currency' => "BDT",
				'currency_symbol' => "&#2547;",
			];
		} else if ($code == "BE") {
			$timezone = [
				'timezone' => "Europe/Brussels",
				'currency' => "EUR",
				'currency_symbol' => "&#8364;",
			];
		} else if ($code == "BF") {
			$timezone = [
				'timezone' => "Africa/Ouagadougou",
				'currency' => "XOF",
				'currency_symbol' => "CFA", // currency symbol
			];
		} else if ($code == "BG") {
			$timezone = [
				'timezone' => "Europe/Sofia",
				'currency' => "BGN",
				'currency_symbol' => "&#1083;&#1074;",
			];
		} else if ($code == "BH") {
			$timezone = [
				'timezone' => "Asia/Bahrain",
				'currency' => "BHD",
				'currency_symbol' => ".&#1583;.&#1576;",
			];
		} else if ($code == "BI") {
			$timezone = [
				'timezone' => "Africa/Bujumbura",
				'currency' => "BIF",
				'currency_symbol' => "&#70;&#66;&#117;",
			];
		} else if ($code == "BJ") {
			$timezone = [
				'timezone' => "Africa/Porto-Novo",
				'currency' => "XOF",
				'currency_symbol' => "CFA", // currency symbol
			];
		} else if ($code == "BL") {
			$timezone = [
				'timezone' => "America/St_Barthelemy",
				'currency' => "Euro",
				'currency_symbol' => "&#8364;",
			];
		} else if ($code == "BM") {
			$timezone = [
				'timezone' => "Atlantic/Bermuda",
				'currency' => "BMD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "BN") {
			$timezone = [
				'timezone' => "Asia/Brunei",
				'currency' => "BND",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "BO") {
			$timezone = [
				'timezone' => "America/La_Paz",
				'currency' => "BOB",
				'currency_symbol' => "&#36;&#98;",
			];
		} else if ($code == "BQ") {
			$timezone = [
				'timezone' => "America/Curacao",
				'currency' => "USD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "BR") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "America/Rio_Branco",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "America/Maceio",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "America/Manaus",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "America/Bahia",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "America/Fortaleza",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "America/Campo_Grande",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "America/Belem",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "America/Cuiaba",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "America/Belem",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "America/Recife",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "America/Fortaleza",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "America/Recife",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "America/Porto_Velho",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "America/Boa_Vista",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "27") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "28") {
				$timezone = [
					'timezone' => "America/Maceio",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "29") {
				$timezone = [
					'timezone' => "America/Sao_Paulo",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "30") {
				$timezone = [
					'timezone' => "America/Recife",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "America/Araguaina",
					'currency' => "BRL",
					'currency_symbol' => "&#82;&#36;",
				];
			}
		} else if ($code == "BS") {
			$timezone = [
				'timezone' => "America/Nassau",
				'currency' => "BSD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "BT") {
			$timezone = [
				'timezone' => "Asia/Thimphu",
				'currency' => "BBD",
				'currency_symbol' => "&#78;&#117;&#46;",
			];
		} else if ($code == "BW") {
			$timezone = [
				'timezone' => "Africa/Gaborone",
				'currency' => "BWP",
				'currency_symbol' => "&#80;",
			];
		} else if ($code == "BY") {
			$timezone = [
				'timezone' => "Europe/Minsk",
				'currency' => "BYR",
				'currency_symbol' => "&#112;&#46;",
			];
		} else if ($code == "BZ") {
			$timezone = [
				'timezone' => "America/Belize",
				'currency' => "BZD",
				'currency_symbol' => "&#66;&#90;&#36;",
			];
		} else if ($code == "CA") {
			if ($region == "AB") {
				$timezone = [
					'timezone' => "America/Edmonton",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "BC") {
				$timezone = [
					'timezone' => "America/Vancouver",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "MB") {
				$timezone = [
					'timezone' => "America/Winnipeg",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "NB") {
				$timezone = [
					'timezone' => "America/Halifax",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "NL") {
				$timezone = [
					'timezone' => "America/St_Johns",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "NS") {
				$timezone = [
					'timezone' => "America/Halifax",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "NT") {
				$timezone = [
					'timezone' => "America/Yellowknife",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "NU") {
				$timezone = [
					'timezone' => "America/Rankin_Inlet",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "ON") {
				$timezone = [
					'timezone' => "America/Rainy_River",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "PE") {
				$timezone = [
					'timezone' => "America/Halifax",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "QC") {
				$timezone = [
					'timezone' => "America/Montreal",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "SK") {
				$timezone = [
					'timezone' => "America/Regina",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			} else if ($region == "YT") {
				$timezone = [
					'timezone' => "America/Whitehorse",
					'currency' => "CAD",
					'currency_symbol' => "&#36;",
				];
			}
		} else if ($code == "CC") {
			$timezone = [
				'timezone' => "Indian/Cocos",
				'currency' => "AUD",
				'currency_symbol' => "&#36;",
			];
		} else if ($code == "CD") {
			if ($region == "02") {
				$timezone = [
					'timezone' => "Africa/Kinshasa",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Africa/Lubumbashi",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Africa/Kinshasa",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Africa/Kinshasa",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Africa/Lubumbashi",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Africa/Lubumbashi",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Africa/Lubumbashi",
					'currency' => "CDF",
					'currency_symbol' => "&#70;&#67;",
				];
			}
		} else if ($code == "CF") {
			$timezone = [
				'timezone' => "Africa/Bangui",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "CG") {
			$timezone = [
				'timezone' => "Africa/Brazzaville",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "CH") {
			$timezone = [
				'timezone' => "Europe/Zurich",
				'currency' => 'CHF',
				'currency_symbol' => '&#67;&#72;&#70;',
			];
		} else if ($code == "CI") {
			$timezone = [
				'timezone' => "Africa/Abidjan",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "CK") {
			$timezone = [
				'timezone' => "Pacific/Rarotonga",
				'currency' => 'NZD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "CL") {
			$timezone = [
				'timezone' => "Chile/Continental",
				'currency' => 'CLP',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "CM") {
			$timezone = [
				'timezone' => "Africa/Lagos",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "CN") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Asia/Harbin",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Asia/Harbin",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Urumqi",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "Asia/Harbin",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "Asia/Harbin",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "Asia/Harbin",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "28") {
				$timezone = [
					'timezone' => "Asia/Shanghai",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "29") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "30") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "32") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			} else if ($region == "33") {
				$timezone = [
					'timezone' => "Asia/Chongqing",
					'currency' => 'CNY',
					'currency_symbol' => '&#165;',
				];
			}
		} else if ($code == "CO") {
			$timezone = [
				'timezone' => "America/Bogota",
				'currency' => 'COP',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "CR") {
			$timezone = [
				'timezone' => "America/Costa_Rica",
				'currency' => 'CRC',
				'currency_symbol' => '&#8353;',
			];
		} else if ($code == "CU") {
			$timezone = [
				'timezone' => "America/Havana",
				'currency' => 'CUP',
				'currency_symbol' => '&#8396;',
			];
		} else if ($code == "CV") {
			$timezone = [
				'timezone' => "Atlantic/Cape_Verde",
				'currency' => 'CVE',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "CX") {
			$timezone = [
				'timezone' => "Indian/Christmas",
				'currency' => 'AUD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "CY") {
			$timezone = [
				'timezone' => "Asia/Nicosia",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "CZ") {
			$timezone = [
				'timezone' => "Europe/Prague",
				'currency' => 'CZK',
				'currency_symbol' => '&#75;&#269;',
			];
		} else if ($code == "DE") {
			$timezone = [
				'timezone' => "Europe/Berlin",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "DJ") {
			$timezone = [
				'timezone' => "Africa/Djibouti",
				'currency' => 'DJF',
				'currency_symbol' => '&#70;&#100;&#106;',
			];
		} else if ($code == "DK") {
			$timezone = [
				'timezone' => "Europe/Copenhagen",
				'currency' => 'DKK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "DM") {
			$timezone = [
				'timezone' => "America/Dominica",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "DO") {
			$timezone = [
				'timezone' => "America/Santo_Domingo",
				'currency' => 'DOP',
				'currency_symbol' => '&#82;&#68;&#36;',
			];
		} else if ($code == "DZ") {
			$timezone = [
				'timezone' => "Africa/Algiers",
				'currency' => 'DZD',
				'currency_symbol' => '&#1583;&#1580;',
			];
		} else if ($code == "EC") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Pacific/Galapagos",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "America/Guayaquil",
					'currency' => 'ECS',
					'currency_symbol' => 'ECS',
				];
			}
		} else if ($code == "EE") {
			$timezone = [
				'timezone' => "Europe/Tallinn",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "EG") {
			$timezone = [
				'timezone' => "Africa/Cairo",
				'currency' => 'EGP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "EH") {
			$timezone = [
				'timezone' => "Africa/El_Aaiun",
				'currency' => 'MAD',
				'currency_symbol' => '&#1583;.&#1605;.',
			];
		} else if ($code == "ER") {
			$timezone = [
				'timezone' => "Africa/Asmera",
				'currency' => 'ERN',
				'currency_symbol' => 'Nfk',
			];
		} else if ($code == "ES") {
			if ($region == "07") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "27") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "29") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "32") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "34") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "39") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "51") {
				$timezone = [
					'timezone' => "Africa/Ceuta",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "52") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "53") {
				$timezone = [
					'timezone' => "Atlantic/Canary",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "54") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "55") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "56") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "57") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "58") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "59") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "60") {
				$timezone = [
					'timezone' => "Europe/Madrid",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			}
		} else if ($code == "ET") {
			$timezone = [
				'timezone' => "Africa/Addis_Ababa",
				'currency' => 'ETB',
				'currency_symbol' => '&#66;&#114;',
			];
		} else if ($code == "FI") {
			$timezone = [
				'timezone' => "Europe/Helsinki",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "FJ") {
			$timezone = [
				'timezone' => "Pacific/Fiji",
				'currency' => 'FJD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "FK") {
			$timezone = [
				'timezone' => "Atlantic/Stanley",
				'currency' => 'FKP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "FO") {
			$timezone = [
				'timezone' => "Atlantic/Faeroe",
				'currency' => 'DKK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "FR") {
			$timezone = [
				'timezone' => "Europe/Paris",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "GA") {
			$timezone = [
				'timezone' => "Africa/Libreville",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "GB") {
			$timezone = [
				'timezone' => "Europe/London",
				'currency' => 'GBP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "GD") {
			$timezone = [
				'timezone' => "America/Grenada",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "GE") {
			$timezone = [
				'timezone' => "Asia/Tbilisi",
				'currency' => 'GEL',
				'currency_symbol' => '&#4314;',
			];
		} else if ($code == "GF") {
			$timezone = [
				'timezone' => "America/Cayenne",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "GG") {
			$timezone = [
				'timezone' => "Europe/Guernsey",
				'currency' => 'GGP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "GH") {
			$timezone = [
				'timezone' => "Africa/Accra",
				'currency' => 'GHS',
				'currency_symbol' => '&#162;',
			];
		} else if ($code == "GI") {
			$timezone = [
				'timezone' => "Europe/Gibraltar",
				'currency' => 'GIP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "GL") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "America/Thule",
					'currency' => 'DKK',
					'currency_symbol' => '&#107;&#114;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "America/Godthab",
					'currency' => 'DKK',
					'currency_symbol' => '&#107;&#114;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "America/Godthab",
					'currency' => 'DKK',
					'currency_symbol' => '&#107;&#114;',
				];
			}
		} else if ($code == "GM") {
			$timezone = [
				'timezone' => "Africa/Banjul",
				'currency' => 'GMD',
				'currency_symbol' => '&#68;',
			];
		} else if ($code == "GN") {
			$timezone = [
				'timezone' => "Africa/Conakry",
				'currency' => 'GNF',
				'currency_symbol' => '&#70;&#71;',
			];
		} else if ($code == "GP") {
			$timezone = [
				'timezone' => "America/Guadeloupe",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "GQ") {
			$timezone = [
				'timezone' => "Africa/Malabo",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "GR") {
			$timezone = [
				'timezone' => "Europe/Athens",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "GS") {
			$timezone = [
				'timezone' => "Atlantic/South_Georgia",
				'currency' => 'GBP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "GT") {
			$timezone = [
				'timezone' => "America/Guatemala",
				'currency' => 'GTQ',
				'currency_symbol' => '&#81;',
			];
		} else if ($code == "GU") {
			$timezone = [
				'timezone' => "Pacific/Guam",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "GW") {
			$timezone = [
				'timezone' => "Africa/Bissau",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "GY") {
			$timezone = [
				'timezone' => "America/Guyana",
				'currency' => 'GYD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "HK") {
			$timezone = [
				'timezone' => "Asia/Hong_Kong",
				'currency' => 'HKD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "HN") {
			$timezone = [
				'timezone' => "America/Tegucigalpa",
				'currency' => 'HNL',
				'currency_symbol' => '&#76;',
			];
		} else if ($code == "HR") {
			$timezone = [
				'timezone' => "Europe/Zagreb",
				'currency' => 'HRK',
				'currency_symbol' => '&#107;&#110;',
			];
		} else if ($code == "HT") {
			$timezone = [
				'timezone' => "America/Port-au-Prince",
				'currency' => 'HTG',
				'currency_symbol' => '&#71;',
			];
		} else if ($code == "HU") {
			$timezone = [
				'timezone' => "Europe/Budapest",
				'currency' => 'HUF',
				'currency_symbol' => '&#70;&#116;',
			];
		} else if ($code == "ID") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Asia/Pontianak",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Asia/Jayapura",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Asia/Pontianak",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "Asia/Pontianak",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "Asia/Pontianak",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "Asia/Pontianak",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "30") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "Asia/Makassar",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			} else if ($region == "33") {
				$timezone = [
					'timezone' => "Asia/Jakarta",
					'currency' => 'IDR',
					'currency_symbol' => '&#82;&#112;',
				];
			}
		} else if ($code == "IE") {
			$timezone = [
				'timezone' => "Europe/Dublin",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "IL") {
			$timezone = [
				'timezone' => "Asia/Jerusalem",
				'currency' => 'ILS',
				'currency_symbol' => '&#8362;',
			];
		} else if ($code == "IM") {
			$timezone = [
				'timezone' => "Europe/Isle_of_Man",
				'currency' => 'GBP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "IN") {
			$timezone = [
				'timezone' => "Asia/Calcutta",
				'currency' => 'INR',
				'currency_symbol' => '&#8377;',
			];
		} else if ($code == "IO") {
			$timezone = [
				'timezone' => "Indian/Chagos",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "IQ") {
			$timezone = [
				'timezone' => "Asia/Baghdad",
				'currency' => 'IQD',
				'currency_symbol' => '&#1593;.&#1583;',
			];
		} else if ($code == "IR") {
			$timezone = [
				'timezone' => "Asia/Tehran",
				'currency' => 'IRR',
				'currency_symbol' => '&#65020;',
			];
		} else if ($code == "IS") {
			$timezone = [
				'timezone' => "Atlantic/Reykjavik",
				'currency' => 'ISK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "IT") {
			$timezone = [
				'timezone' => "Europe/Rome",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "JE") {
			$timezone = [
				'timezone' => "Europe/Jersey",
				'currency' => 'GBP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "JM") {
			$timezone = [
				'timezone' => "America/Jamaica",
				'currency' => 'JMD',
				'currency_symbol' => '&#74;&#36;',
			];
		} else if ($code == "JO") {
			$timezone = [
				'timezone' => "Asia/Amman",
				'currency' => 'JOD',
				'currency_symbol' => '&#74;&#68;',
			];
		} else if ($code == "JP") {
			$timezone = [
				'timezone' => "Asia/Tokyo",
				'currency' => 'JPY',
				'currency_symbol' => '&#165;',
			];
		} else if ($code == "KE") {
			$timezone = [
				'timezone' => "Africa/Nairobi",
				'currency' => 'KES',
				'currency_symbol' => '&#75;&#83;&#104;',
			];
		} else if ($code == "KG") {
			$timezone = [
				'timezone' => "Asia/Bishkek",
				'currency' => 'KGS',
				'currency_symbol' => '&#1083;&#1074;',
			];
		} else if ($code == "KH") {
			$timezone = [
				'timezone' => "Asia/Phnom_Penh",
				'currency' => 'KHR',
				'currency_symbol' => '&#6107;',
			];
		} else if ($code == "KI") {
			$timezone = [
				'timezone' => "Pacific/Tarawa",
				'currency' => 'AUD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "KM") {
			$timezone = [
				'timezone' => "Indian/Comoro",
				'currency' => 'KMF',
				'currency_symbol' => '&#67;&#70;',
			];
		} else if ($code == "KN") {
			$timezone = [
				'timezone' => "America/St_Kitts",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "KP") {
			$timezone = [
				'timezone' => "Asia/Pyongyang",
				'currency' => 'KPW',
				'currency_symbol' => '&#8361;',
			];
		} else if ($code == "KR") {
			$timezone = [
				'timezone' => "Asia/Seoul",
				'currency' => 'KRW',
				'currency_symbol' => '&#8361;',
			];
		} else if ($code == "KW") {
			$timezone = [
				'timezone' => "Asia/Kuwait",
				'currency' => 'KWD',
				'currency_symbol' => '&#1583;.&#1603;',
			];
		} else if ($code == "KY") {
			$timezone = [
				'timezone' => "America/Cayman",
				'currency' => 'KYD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "KZ") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Asia/Almaty",
					'currency' => '',
					'currency_symbol' => '',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Almaty",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Asia/Aqtobe",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Asia/Aqtau",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Asia/Oral",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Asia/Aqtau",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Asia/Almaty",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Aqtobe",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Qyzylorda",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Asia/Almaty",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Asia/Aqtobe",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "Asia/Almaty",
					'currency' => 'KZT',
					'currency_symbol' => '&#1083;&#1074;',
				];
			}
		} else if ($code == "LA") {
			$timezone = [
				'timezone' => "Asia/Vientiane",
				'currency' => 'LAK',
				'currency_symbol' => '&#8365;',
			];
		} else if ($code == "LB") {
			$timezone = [
				'timezone' => "Asia/Beirut",
				'currency' => 'LBP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "LC") {
			$timezone = [
				'timezone' => "America/St_Lucia",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "LI") {
			$timezone = [
				'timezone' => "Europe/Vaduz",
				'currency' => 'CHF',
				'currency_symbol' => '&#67;&#72;&#70;',
			];
		} else if ($code == "LK") {
			$timezone = [
				'timezone' => "Asia/Colombo",
				'currency' => 'LKR',
				'currency_symbol' => '&#8360;',
			];
		} else if ($code == "LR") {
			$timezone = [
				'timezone' => "Africa/Monrovia",
				'currency' => 'LRD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "LS") {
			$timezone = [
				'timezone' => "Africa/Maseru",
				'currency' => 'LSL',
				'currency_symbol' => '&#76;',
			];
		} else if ($code == "LT") {
			$timezone = [
				'timezone' => "Europe/Vilnius",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "LU") {
			$timezone = [
				'timezone' => "Europe/Luxembourg",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "LV") {
			$timezone = [
				'timezone' => "Europe/Riga",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "LY") {
			$timezone = [
				'timezone' => "Africa/Tripoli",
				'currency' => 'LYD',
				'currency_symbol' => '&#1604;.&#1583;',
			];
		} else if ($code == "MA") {
			$timezone = [
				'timezone' => "Africa/Casablanca",
				'currency' => 'MAD',
				'currency_symbol' => '&#1583;.&#1605;.',
			];
		} else if ($code == "MC") {
			$timezone = [
				'timezone' => "Europe/Monaco",
				'currency' => '',
				'currency_symbol' => '',
			];
		} else if ($code == "MD") {
			$timezone = [
				'timezone' => "Europe/Chisinau",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "ME") {
			$timezone = [
				'timezone' => "Europe/Podgorica",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "MF") {
			$timezone = [
				'timezone' => "America/Marigot",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "MG") {
			$timezone = [
				'timezone' => "Indian/Antananarivo",
				'currency' => 'MGF',
				'currency_symbol' => 'Ar',
			];
		} else if ($code == "MK") {
			$timezone = [
				'timezone' => "Europe/Skopje",
				'currency' => 'MKD',
				'currency_symbol' => '&#1076;&#1077;&#1085;',
			];
		} else if ($code == "ML") {
			$timezone = [
				'timezone' => "Africa/Bamako",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "MM") {
			$timezone = [
				'timezone' => "Asia/Rangoon",
				'currency' => 'MMK',
				'currency_symbol' => '&#75;',
			];
		} else if ($code == "MN") {
			$timezone = [
				'timezone' => "Asia/Choibalsan",
				'currency' => 'MNT',
				'currency_symbol' => '&#8366;',
			];
		} else if ($code == "MO") {
			$timezone = [
				'timezone' => "Asia/Macao",
				'currency' => 'MOP',
				'currency_symbol' => 'MOP$',
			];
		} else if ($code == "MP") {
			$timezone = [
				'timezone' => "Pacific/Saipan",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "MQ") {
			$timezone = [
				'timezone' => "America/Martinique",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "MR") {
			$timezone = [
				'timezone' => "Africa/Nouakchott",
				'currency' => 'MRO',
				'currency_symbol' => '&#85;&#77;',
			];
		} else if ($code == "MS") {
			$timezone = [
				'timezone' => "America/Montserrat",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "MT") {
			$timezone = [
				'timezone' => "Europe/Malta",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "MU") {
			$timezone = [
				'timezone' => "Indian/Mauritius",
				'currency' => 'MUR',
				'currency_symbol' => '&#8360;',
			];
		} else if ($code == "MV") {
			$timezone = [
				'timezone' => "Indian/Maldives",
				'currency' => 'MVR',
				'currency_symbol' => '.&#1923;',
			];
		} else if ($code == "MW") {
			$timezone = [
				'timezone' => "Africa/Blantyre",
				'currency' => 'MWK',
				'currency_symbol' => '&#77;&#75;',
			];
		} else if ($code == "MX") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => '',
					'currency_symbol' => '',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "America/Tijuana",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "America/Hermosillo",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "America/Merida",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "America/Chihuahua",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "America/Monterrey",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "America/Mazatlan",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "America/Mazatlan",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "America/Chihuahua",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "America/Mazatlan",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "America/Monterrey",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "America/Cancun",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "America/Mazatlan",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "America/Hermosillo",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "27") {
				$timezone = [
					'timezone' => "America/Merida",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "28") {
				$timezone = [
					'timezone' => "America/Monterrey",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "29") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "30") {
				$timezone = [
					'timezone' => "America/Mexico_City",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "America/Merida",
					'currency' => 'MXN',
					'currency_symbol' => '',
				];
			} else if ($region == "32") {
				$timezone = [
					'timezone' => "America/Monterrey",
					'currency' => 'MXN',
					'currency_symbol' => '&#36;',
				];
			}
		} else if ($code == "MY") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Asia/Kuching",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Kuala_Lumpur",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Asia/Kuching",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Asia/Kuching",
					'currency' => 'MYR',
					'currency_symbol' => '&#82;&#77;',
				];
			}
		} else if ($code == "MZ") {
			$timezone = [
				'timezone' => "Africa/Maputo",
				'currency' => 'MZN',
				'currency_symbol' => '&#77;&#84;',
			];
		} else if ($code == "NA") {
			$timezone = [
				'timezone' => "Africa/Windhoek",
				'currency' => 'NAD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "NC") {
			$timezone = [
				'timezone' => "Pacific/Noumea",
				'currency' => 'XPF',
				'currency_symbol' => '&#70;',
			];
		} else if ($code == "NE") {
			$timezone = [
				'timezone' => "Africa/Niamey",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "NF") {
			$timezone = [
				'timezone' => "Pacific/Norfolk",
				'currency' => 'AUD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "NG") {
			$timezone = [
				'timezone' => "Africa/Lagos",
				'currency' => 'NGN',
				'currency_symbol' => '&#8358;',
			];
		} else if ($code == "NI") {
			$timezone = [
				'timezone' => "America/Managua",
				'currency' => 'NIO',
				'currency_symbol' => '&#67;&#36;',
			];
		} else if ($code == "NL") {
			$timezone = [
				'timezone' => "Europe/Amsterdam",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "NO") {
			$timezone = [
				'timezone' => "Europe/Oslo",
				'currency' => 'NOK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "NP") {
			$timezone = [
				'timezone' => "Asia/Katmandu",
				'currency' => 'NPR',
				'currency_symbol' => '&#8360;',
			];
		} else if ($code == "NR") {
			$timezone = [
				'timezone' => "Pacific/Nauru",
				'currency' => 'AUD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "NU") {
			$timezone = [
				'timezone' => "Pacific/Niue",
				'currency' => 'NZD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "NZ") {
			if ($region == "85") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "E7") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "E8") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "E9") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F1") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F2") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F3") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F4") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F5") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F7") {
				$timezone = [
					'timezone' => "Pacific/Chatham",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F8") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "F9") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "G1") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "G2") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "G3") {
				$timezone = [
					'timezone' => "Pacific/Auckland",
					'currency' => 'NZD',
					'currency_symbol' => '&#36;',
				];
			}
		} else if ($code == "OM") {
			$timezone = [
				'timezone' => "Asia/Muscat",
				'currency' => '',
				'currency_symbol' => '',
			];
		} else if ($code == "PA") {
			$timezone = [
				'timezone' => "America/Panama",
				'currency' => 'PAB',
				'currency_symbol' => '&#66;&#47;&#46;',
			];
		} else if ($code == "PE") {
			$timezone = [
				'timezone' => "America/Lima",
				'currency' => 'PEN',
				'currency_symbol' => '&#83;&#47;&#46;',
			];
		} else if ($code == "PF") {
			$timezone = [
				'timezone' => "Pacific/Marquesas",
				'currency' => 'XPF',
				'currency_symbol' => '&#70;',
			];
		} else if ($code == "PG") {
			$timezone = [
				'timezone' => "Pacific/Port_Moresby",
				'currency' => 'PGK',
				'currency_symbol' => '&#75;',
			];
		} else if ($code == "PH") {
			$timezone = [
				'timezone' => "Asia/Manila",
				'currency' => 'PHP',
				'currency_symbol' => '&#8369;',
			];
		} else if ($code == "PK") {
			$timezone = [
				'timezone' => "Asia/Karachi",
				'currency' => 'PKR',
				'currency_symbol' => '&#8360;',
			];
		} else if ($code == "PL") {
			$timezone = [
				'timezone' => "Europe/Warsaw",
				'currency' => 'PLN',
				'currency_symbol' => '&#122;&#322;',
			];
		} else if ($code == "PM") {
			$timezone = [
				'timezone' => "America/Miquelon",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "PN") {
			$timezone = [
				'timezone' => "Pacific/Pitcairn",
				'currency' => 'NZD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "PR") {
			$timezone = [
				'timezone' => "America/Puerto_Rico",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "PS") {
			$timezone = [
				'timezone' => "Asia/Gaza",
				'currency' => 'ILS',
				'currency_symbol' => '&#8362;',
			];
		} else if ($code == "PT") {
			if ($region == "02") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => '',
					'currency_symbol' => '',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Atlantic/Madeira",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "Europe/Lisbon",
					'currency' => 'EUR',
					'currency_symbol' => '&#8364;',
				];
			}
		} else if ($code == "PW") {
			$timezone = [
				'timezone' => "Pacific/Palau",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "PY") {
			$timezone = [
				'timezone' => "America/Asuncion",
				'currency' => 'PYG',
				'currency_symbol' => '&#71;&#115;',
			];
		} else if ($code == "QA") {
			$timezone = [
				'timezone' => "Asia/Qatar",
				'currency' => 'QAR',
				'currency_symbol' => '&#65020;',
			];
		} else if ($code == "RE") {
			$timezone = [
				'timezone' => "Indian/Reunion",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "RO") {
			$timezone = [
				'timezone' => "Europe/Bucharest",
				'currency' => 'RON',
				'currency_symbol' => '&#108;&#101;&#105;',
			];
		} else if ($code == "RS") {
			$timezone = [
				'timezone' => "Europe/Belgrade",
				'currency' => 'RSD',
				'currency_symbol' => '&#1044;&#1080;&#1085;&#46;',
			];
		} else if ($code == "RU") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Novokuznetsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Asia/Novosibirsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Asia/Vladivostok",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Asia/Anadyr",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "Asia/Krasnoyarsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "Europe/Kaliningrad",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "Asia/Kamchatka",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "27") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "28") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "29") {
				$timezone = [
					'timezone' => "Asia/Novokuznetsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "30") {
				$timezone = [
					'timezone' => "Asia/Vladivostok",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "31") {
				$timezone = [
					'timezone' => "Asia/Krasnoyarsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "32") {
				$timezone = [
					'timezone' => "Asia/Omsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "33") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "34") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "35") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "36") {
				$timezone = [
					'timezone' => "Asia/Anadyr",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "37") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "38") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "39") {
				$timezone = [
					'timezone' => "Asia/Krasnoyarsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "40") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "41") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "42") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "43") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "44") {
				$timezone = [
					'timezone' => "Asia/Magadan",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "45") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "46") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "47") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "48") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "49") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "50") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "51") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "52") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "53") {
				$timezone = [
					'timezone' => "Asia/Novosibirsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "54") {
				$timezone = [
					'timezone' => "Asia/Omsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "55") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "56") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "57") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "58") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "59") {
				$timezone = [
					'timezone' => "Asia/Vladivostok",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "60") {
				$timezone = [
					'timezone' => "Europe/Kaliningrad",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "61") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "62") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "63") {
				$timezone = [
					'timezone' => "Asia/Yakutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "64") {
				$timezone = [
					'timezone' => "Asia/Sakhalin",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "65") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "66") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "67") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "68") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "69") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "70") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "71") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "72") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "73") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "74") {
				$timezone = [
					'timezone' => "Asia/Krasnoyarsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "75") {
				$timezone = [
					'timezone' => "Asia/Novosibirsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "76") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "77") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "78") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "79") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "80") {
				$timezone = [
					'timezone' => "Asia/Yekaterinburg",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "81") {
				$timezone = [
					'timezone' => "Europe/Samara",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "82") {
				$timezone = [
					'timezone' => "Asia/Irkutsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "83") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "84") {
				$timezone = [
					'timezone' => "Europe/Volgograd",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "85") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "86") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "87") {
				$timezone = [
					'timezone' => "Asia/Novosibirsk",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "88") {
				$timezone = [
					'timezone' => "Europe/Moscow",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			} else if ($region == "89") {
				$timezone = [
					'timezone' => "Asia/Vladivostok",
					'currency' => 'RUB',
					'currency_symbol' => '&#1088;&#1091;&#1073;',
				];
			}
		} else if ($code == "RW") {
			$timezone = [
				'timezone' => "Africa/Kigali",
				'currency' => 'RWF',
				'currency_symbol' => '&#1585;.&#1587;',
			];
		} else if ($code == "SA") {
			$timezone = [
				'timezone' => "Asia/Riyadh",
				'currency' => 'SAR',
				'currency_symbol' => '&#65020;',
			];
		} else if ($code == "SB") {
			$timezone = [
				'timezone' => "Pacific/Guadalcanal",
				'currency' => 'SBD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "SC") {
			$timezone = [
				'timezone' => "Indian/Mahe",
				'currency' => 'SCR',
				'currency_symbol' => '&#8360;',
			];
		} else if ($code == "SD") {
			$timezone = [
				'timezone' => "Africa/Khartoum",
				'currency' => 'SDG',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "SE") {
			$timezone = [
				'timezone' => "Europe/Stockholm",
				'currency' => 'SEK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "SG") {
			$timezone = [
				'timezone' => "Asia/Singapore",
				'currency' => 'SGD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "SH") {
			$timezone = [
				'timezone' => "Atlantic/St_Helena",
				'currency' => 'SHP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "SI") {
			$timezone = [
				'timezone' => "Europe/Ljubljana",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "SJ") {
			$timezone = [
				'timezone' => "Arctic/Longyearbyen",
				'currency' => 'NOK',
				'currency_symbol' => '&#107;&#114;',
			];
		} else if ($code == "SK") {
			$timezone = [
				'timezone' => "Europe/Bratislava",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "SL") {
			$timezone = [
				'timezone' => "Africa/Freetown",
				'currency' => 'SLL',
				'currency_symbol' => '&#76;&#101;',
			];
		} else if ($code == "SM") {
			$timezone = [
				'timezone' => "Europe/San_Marino",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "SN") {
			$timezone = [
				'timezone' => "Africa/Dakar",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "SO") {
			$timezone = [
				'timezone' => "Africa/Mogadishu",
				'currency' => 'SOS',
				'currency_symbol' => '&#83;',
			];
		} else if ($code == "SR") {
			$timezone = [
				'timezone' => "America/Paramaribo",
				'currency' => 'SRD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "ST") {
			$timezone = [
				'timezone' => "Africa/Sao_Tome",
				'currency' => 'STD',
				'currency_symbol' => '&#68;&#98;',
			];
		} else if ($code == "SV") {
			$timezone = [
				'timezone' => "America/El_Salvador",
				'currency' => 'SVC',
				'currency_symbol' => '&#36',
			];
		} else if ($code == "SY") {
			$timezone = [
				'timezone' => "Asia/Damascus",
				'currency' => 'SYP',
				'currency_symbol' => '&#163;',
			];
		} else if ($code == "SZ") {
			$timezone = [
				'timezone' => "Africa/Mbabane",
				'currency' => 'SZL',
				'currency_symbol' => '&#76;',
			];
		} else if ($code == "TC") {
			$timezone = [
				'timezone' => "America/Grand_Turk",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "TD") {
			$timezone = [
				'timezone' => "Africa/Ndjamena",
				'currency' => 'XAF',
				'currency_symbol' => '&#70;&#67;&#70;&#65;',
			];
		} else if ($code == "TF") {
			$timezone = [
				'timezone' => "Indian/Kerguelen",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "TG") {
			$timezone = [
				'timezone' => "Africa/Lome",
				'currency' => 'XOF',
				'currency_symbol' => 'CFA',
			];
		} else if ($code == "TH") {
			$timezone = [
				'timezone' => "Asia/Bangkok",
				'currency' => 'THB',
				'currency_symbol' => '&#3647;',
			];
		} else if ($code == "TJ") {
			$timezone = [
				'timezone' => "Asia/Dushanbe",
				'currency' => 'TJS',
				'currency_symbol' => '&#84;&#74;&#83;',
			];
		} else if ($code == "TK") {
			$timezone = [
				'timezone' => "Pacific/Fakaofo",
				'currency' => 'NZD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "TL") {
			$timezone = [
				'timezone' => "Asia/Dili",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "TM") {
			$timezone = [
				'timezone' => "Asia/Ashgabat",
				'currency' => 'TMT',
				'currency_symbol' => '&#109;',
			];
		} else if ($code == "TN") {
			$timezone = [
				'timezone' => "Africa/Tunis",
				'currency' => 'TND',
				'currency_symbol' => '&#1583;.&#1578;',
			];
		} else if ($code == "TO") {
			$timezone = [
				'timezone' => "Pacific/Tongatapu",
				'currency' => 'TOP',
				'currency_symbol' => '&#84;&#36;',
			];
		} else if ($code == "TR") {
			$timezone = [
				'timezone' => "Asia/Istanbul",
				'currency' => 'TRY',
				'currency_symbol' => '&#8356;',
			];
		} else if ($code == "TT") {
			$timezone = [
				'timezone' => "America/Port_of_Spain",
				'currency' => 'TTD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "TV") {
			$timezone = [
				'timezone' => "Pacific/Funafuti",
				'currency' => 'AUD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "TW") {
			$timezone = [
				'timezone' => "Asia/Taipei",
				'currency' => 'TWD',
				'currency_symbol' => '&#78;&#84;&#36;',
			];
		} else if ($code == "TZ") {
			$timezone = [
				'timezone' => "Africa/Dar_es_Salaam",
				'currency' => 'TZS',
				'currency_symbol' => 'TSh',
			];
		} else if ($code == "UA") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "04") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "05") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Europe/Simferopol",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "11") {
				$timezone = [
					'timezone' => "Europe/Simferopol",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "15") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "16") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "17") {
				$timezone = [
					'timezone' => "Europe/Simferopol",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "18") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "19") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "20") {
				$timezone = [
					'timezone' => "Europe/Simferopol",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "21") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "22") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "23") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "24") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "25") {
				$timezone = [
					'timezone' => "Europe/Uzhgorod",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "26") {
				$timezone = [
					'timezone' => "Europe/Zaporozhye",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			} else if ($region == "27") {
				$timezone = [
					'timezone' => "Europe/Kiev",
					'currency' => 'UAH',
					'currency_symbol' => '&#8372;',
				];
			}
		} else if ($region == "UG") {
			$timezone = [
				'timezone' => "Africa/Kampala",
				'currency' => 'UGX',
				'currency_symbol' => '&#85;&#83;&#104;',
			];
		} else if ($code == "US") {
			if ($region == "AK") {
				$timezone = [
					'timezone' => "America/Anchorage",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "AL") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "AR") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "AZ") {
				$timezone = [
					'timezone' => "America/Phoenix",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "CA") {
				$timezone = [
					'timezone' => "America/Los_Angeles",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "CO") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "CT") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "DC") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "DE") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "FL") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "GA") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "HI") {
				$timezone = [
					'timezone' => "Pacific/Honolulu",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "IA") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "ID") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "IL") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "IN") {
				$timezone = [
					'timezone' => "America/Indianapolis",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "KS") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "KY") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "LA") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MA") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MD") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "ME") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MI") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MN") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MO") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MS") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "MT") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NC") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "ND") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NE") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NH") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NJ") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NM") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NV") {
				$timezone = [
					'timezone' => "America/Los_Angeles",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "NY") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "OH") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "OK") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "OR") {
				$timezone = [
					'timezone' => "America/Los_Angeles",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "PA") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "RI") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "SC") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "SD") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "TN") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "TX") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "UT") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "VA") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "VT") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "WA") {
				$timezone = [
					'timezone' => "America/Los_Angeles",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "WI") {
				$timezone = [
					'timezone' => "America/Chicago",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "WV") {
				$timezone = [
					'timezone' => "America/New_York",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			} else if ($region == "WY") {
				$timezone = [
					'timezone' => "America/Denver",
					'currency' => 'USD',
					'currency_symbol' => '&#36;',
				];
			}
		} else if ($code == "UY") {
			$timezone = [
				'timezone' => "America/Montevideo",
				'currency' => 'UYU',
				'currency_symbol' => '&#36;&#85;',
			];
		} else if ($code == "UZ") {
			if ($region == "01") {
				$timezone = [
					'timezone' => "Asia/Tashkent",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "02") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "03") {
				$timezone = [
					'timezone' => "Asia/Tashkent",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "06") {
				$timezone = [
					'timezone' => "Asia/Tashkent",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "07") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "08") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "09") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "10") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "12") {
				$timezone = [
					'timezone' => "Asia/Samarkand",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "13") {
				$timezone = [
					'timezone' => "Asia/Tashkent",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			} else if ($region == "14") {
				$timezone = [
					'timezone' => "Asia/Tashkent",
					'currency' => 'UZS',
					'currency_symbol' => '&#1083;&#1074;',
				];
			}
		} else if ($code == "VA") {
			$timezone = [
				'timezone' => "Europe/Vatican",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "VC") {
			$timezone = [
				'timezone' => "America/St_Vincent",
				'currency' => 'XCD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "VE") {
			$timezone = [
				'timezone' => "America/Caracas",
				'currency' => 'VEF',
				'currency_symbol' => '&#66;&#115;',
			];
		} else if ($code == "VG") {
			$timezone = [
				'timezone' => "America/Tortola",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "VI") {
			$timezone = [
				'timezone' => "America/St_Thomas",
				'currency' => 'USD',
				'currency_symbol' => '&#36;',
			];
		} else if ($code == "VN") {
			$timezone = [
				'timezone' => "Asia/Phnom_Penh",
				'currency' => 'VND',
				'currency_symbol' => '&#8363;',
			];
		} else if ($code == "VU") {
			$timezone = [
				'timezone' => "Pacific/Efate",
				'currency' => 'VUV',
				'currency_symbol' => '&#86;&#84;',
			];
		} else if ($code == "WF") {
			$timezone = [
				'timezone' => "Pacific/Wallis",
				'currency' => 'XPF',
				'currency_symbol' => '&#70;',
			];
		} else if ($code == "WS") {
			$timezone = [
				'timezone' => "Pacific/Samoa",
				'currency' => 'WST',
				'currency_symbol' => '&#87;&#83;&#36;',
			];
		} else if ($code == "YE") {
			$timezone = [
				'timezone' => "Asia/Aden",
				'currency' => 'YER',
				'currency_symbol' => '&#65020;',
			];
		} else if ($code == "YT") {
			$timezone = [
				'timezone' => "Indian/Mayotte",
				'currency' => 'EUR',
				'currency_symbol' => '&#8364;',
			];
		} else if ($code == "ZA") {
			$timezone = [
				'timezone' => "Africa/Johannesburg",
				'currency' => 'ZAR',
				'currency_symbol' => '&#82;',
			];
		} else if ($code == "ZM") {
			$timezone = [
				'timezone' => "Africa/Lusaka",
				'currency' => 'ZMW',
				'currency_symbol' => 'ZK',
			];
		} else if ($code == "ZW") {
			$timezone = [
				'timezone' => "Africa/Harare",
				'currency' => 'ZWD',
				'currency_symbol' => '&#36;',
			];
		}
		return $timezone;

	}

}
