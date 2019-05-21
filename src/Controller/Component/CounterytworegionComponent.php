<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * UUID component
 *Get user id by uuid
 */
class CounterytworegionComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function region($data) {
		$region = [];
		if ($data == 'AR') {
			$region = [
				"01" => "Buenos Aires",
				"02" => "Catamarca",
				"03" => "Chaco",
				"04" => "Chubut",
				"05" => "Cordoba",
				"06" => "Corrientes",
				"07" => "Distrito Federal",
				"08" => "Entre Rios",
				"09" => "Formosa",
				"10" => "Jujuy",
				"11" => "La Pampa",
				"12" => "La Rioja",
				"13" => "Mendoza",
				"14" => "Misiones",
				"15" => "Neuquen",
				"16" => "Rio Negro",
				"17" => "Salta",
				"18" => "San Juan",
				"19" => "San Luis",
				"20" => "Santa Cruz",
				"21" => "Santa Fe",
				"22" => "Santiago del Estero",
				"23" => "Tierra del Fuego",
				"24" => "Tucuman",
			];
			return $region;

		} elseif ($data == 'AU') {
			$region = [
				"01" => "Australian Capital Territory",
				"02" => "New South Wales",
				"03" => "Northern Territory",
				"04" => "Queensland",
				"05" => "South Australia",
				"06" => "Tasmania",
				"07" => "Victoria",
				"08" => "Western Australia",
			];
			return $region;

		} elseif ($data == 'BR') {
			$region = [
				"01" => "Acre",
				"02" => "Alagoas",
				"03" => "Amapa",
				"04" => "Amazonas",
				"05" => "Bahia",
				"06" => "Ceara",
				"07" => "Distrito Federal",
				"08" => "Espirito Santo",
				"11" => "Mato Grosso do Sul",
				"13" => "Maranhao",
				"14" => "Mato Grosso",
				"15" => "Minas Gerais",
				"16" => "Para",
				"17" => "Paraiba",
				"18" => "Parana",
				"20" => "Piaui",
				"21" => "Rio de Janeiro",
				"22" => "Rio Grande do Norte",
				"23" => "Rio Grande do Sul",
				"24" => "Rondonia",
				"25" => "Roraima",
				"26" => "Santa Catarina",
				"27" => "Sao Paulo",
				"28" => "Sergipe",
				"29" => "Goias",
				"30" => "Pernambuco",
				"31" => "Tocantins",
			];
			return $region;

		} elseif ($data == 'CA') {
			$region = [
				'AB' => "Alberta",
				'BC' => "British Columbia",
				'MB' => "Manitoba",
				'NB' => "New Brunswick",
				'NL' => "Newfoundland",
				'NS' => "Nova Scotia",
				'NT' => "Northwest Territories",
				'NU' => "Nunavut",
				'ON' => "Ontario",
				'PE' => "Prince Edward Island",
				'QC' => "Quebec",
				'SK' => "Saskatchewan",
				'YT' => "Yukon Territory",
			];
			return $region;

		} elseif ($data == 'CD') {
			$region = [
				"01" => "Bandundu",
				"02" => "Equateur",
				"04" => "Kasai-Oriental",
				"05" => "Katanga",
				"06" => "Kinshasa",
				"08" => "Bas-Congo",
				"09" => "Orientale",
				"10" => "Maniema",
				"11" => "Nord-Kivu",
				"12" => "Sud-Kivu",
			];
			return $region;

		} elseif ($data == 'CN') {
			$region = [
				"01" => "Anhui",
				"02" => "Zhejiang",
				"03" => "Jiangxi",
				"04" => "Jiangsu",
				"05" => "Jilin",
				"06" => "Qinghai",
				"07" => "Fujian",
				"08" => "Heilongjiang",
				"09" => "Henan",
				"10" => "Hebei",
				"11" => "Hunan",
				"12" => "Hubei",
				"13" => "Xinjiang",
				"14" => "Xizang",
				"15" => "Gansu",
				"16" => "Guangxi",
				"18" => "Guizhou",
				"19" => "Liaoning",
				"20" => "Nei Mongol",
				"21" => "Ningxia",
				"22" => "Beijing",
				"23" => "Shanghai",
				"24" => "Shanxi",
				"25" => "Shandong",
				"26" => "Shaanxi",
				"28" => "Tianjin",
				"29" => "Yunnan",
				"30" => "Guangdong",
				"31" => "Hainan",
				"32" => "Sichuan",
				"33" => "Chongqing",
			];
			return $region;

		} elseif ($data == 'EC') {
			$region = [
				"01" => "Galapagos",
				"02" => "Azuay",
				"03" => "Bolivar",
				"04" => "Canar",
				"05" => "Carchi",
				"06" => "Chimborazo",
				"07" => "Cotopaxi",
				"08" => "El Oro",
				"09" => "Esmeraldas",
				"10" => "Guayas",
				"11" => "Imbabura",
				"12" => "Loja",
				"13" => "Los Rios",
				"14" => "Manabi",
				"15" => "Morona-Santiago",
				"17" => "Pastaza",
				"18" => "Pichincha",
				"19" => "Tungurahua",
				"20" => "Zamora-Chinchipe",
				"22" => "Sucumbios",
			];
			return $region;

		} elseif ($data == 'ES') {
			$region = [
				"07" => "Islas Baleares",
				"27" => "La Rioja",
				"29" => "Madrid",
				"31" => "Murcia",
				"32" => "Navarra",
				"34" => "Asturias",
				"39" => "Cantabria",
				"51" => "Andalucia",
				"52" => "Aragon",
				"53" => "Canarias",
				"54" => "Castilla-La Mancha",
				"55" => "Castilla y Leon",
				"56" => "Catalonia",
				"57" => "Extremadura",
				"58" => "Galicia",
				"59" => "Pais Vasco",
				"60" => "Comunidad Valenciana",
			];
			return $region;

		} elseif ($data == 'GL') {
			$region = [
				"01" => "Nordgronland",
				"02" => "Ostgronland",
				"03" => "Vestgronland",
			];
			return $region;

		} elseif ($data == 'ID') {
			$region = [
				"01" => "Aceh",
				"02" => "Bali",
				"03" => "Bengkulu",
				"04" => "Jakarta Raya",
				"05" => "Jambi",
				"07" => "Jawa Tengah",
				"08" => "Jawa Timur",
				"10" => "Yogyakarta",
				"11" => "Kalimantan Barat",
				"12" => "Kalimantan Selatan",
				"13" => "Kalimantan Tengah",
				"14" => "Kalimantan Timur",
				"15" => "Lampung",
				"17" => "Nusa Tenggara Barat",
				"18" => "Nusa Tenggara Timur",
				"21" => "Sulawesi Tengah",
				"22" => "Sulawesi Tenggara",
				"24" => "Sumatera Barat",
				"26" => "Sumatera Utara",
				"28" => "Maluku",
				"29" => "Maluku Utara",
				"30" => "Jawa Barat",
				"31" => "Sulawesi Utara",
				"32" => "Sumatera Selatan",
				"33" => "Banten",
			];
			return $region;

		} elseif ($data == 'KZ') {
			$region = [
				"01" => "Almaty",
				"02" => "Almaty City",
				"03" => "Aqmola",
				"04" => "Aqtobe",
				"05" => "Astana",
				"06" => "Atyrau",
				"07" => "West Kazakhstan",
				"08" => "Bayqonyr",
				"09" => "Mangghystau",
				"10" => "South Kazakhstan",
				"11" => "Pavlodar",
				"12" => "Qaraghandy",
				"13" => "Qostanay",
				"14" => "Qyzylorda",
				"15" => "East Kazakhstan",
				"16" => "North Kazakhstan",
				"17" => "Zhambyl",
			];
			return $region;

		} elseif ($data == 'MX') {
			$region = [
				"01" => "Aguascalientes",
				"02" => "Baja California",
				"03" => "Baja California Sur",
				"04" => "Campeche",
				"05" => "Chiapas",
				"06" => "Chihuahua",
				"07" => "Coahuila de Zaragoza",
				"08" => "Colima",
				"09" => "Distrito Federal",
				"10" => "Durango",
				"11" => "Guanajuato",
				"12" => "Guerrero",
				"13" => "Hidalgo",
				"14" => "Jalisco",
				"15" => "Mexico",
				"16" => "Michoacan de Ocampo",
				"17" => "Morelos",
				"18" => "Nayarit",
				"19" => "Nuevo Leon",
				"20" => "Oaxaca",
				"21" => "Puebla",
				"22" => "Queretaro de Arteaga",
				"23" => "Quintana Roo",
				"24" => "San Luis Potosi",
				"25" => "Sinaloa",
				"26" => "Sonora",
				"27" => "Tabasco",
				"28" => "Tamaulipas",
				"29" => "Tlaxcala",
				"30" => "Veracruz-Llave",
				"31" => "Yucatan",
				"32" => "Zacatecas",
			];
			return $region;

		} elseif ($data == 'MY') {
			$region = [
				"01" => "Johor",
				"02" => "Kedah",
				"03" => "Kelantan",
				"04" => "Melaka",
				"05" => "Negeri Sembilan",
				"06" => "Pahang",
				"07" => "Perak",
				"08" => "Perlis",
				"09" => "Pulau Pinang",
				"11" => "Sarawak",
				"12" => "Selangor",
				"13" => "Terengganu",
				"14" => "Kuala Lumpur",
				"15" => "Labuan",
				"16" => "Sabah",
				"17" => "Putrajaya",
			];
			return $region;

		} elseif ($data == 'NZ') {
			$region = [
				"10" => "Chatham Islands",
				"E7" => "Auckland",
				"E8" => "Bay of Plenty",
				"E9" => "Canterbury",
				"F1" => "Gisborne",
				"F2" => "Hawke's Bay",
				"F3" => "Manawatu-Wanganui",
				"F4" => "Marlborough",
				"F5" => "Nelson",
				"F6" => "Northland",
				"F7" => "Otago",
				"F8" => "Southland",
				"F9" => "Taranaki",
				"G1" => "Waikato",
				"G2" => "Wellington",
				"G3" => "West Coast",
			];
			return $region;

		} elseif ($data == 'RU') {
			$region = [
				"01" => "Adygeya, Republic of",
				"02" => "Aginsky Buryatsky AO",
				"03" => "Gorno-Altay",
				"04" => "Altaisky krai",
				"05" => "Amur",
				"06" => "Arkhangel'sk",
				"07" => "Astrakhan'",
				"08" => "Bashkortostan",
				"09" => "Belgorod",
				"10" => "Bryansk",
				"11" => "Buryat",
				"12" => "Chechnya",
				"13" => "Chelyabinsk",
				"14" => "Chita",
				"15" => "Chukot",
				"16" => "Chuvashia",
				"17" => "Dagestan",
				"18" => "Evenk",
				"19" => "Ingush",
				"20" => "Irkutsk",
				"21" => "Ivanovo",
				"22" => "Kabardin-Balkar",
				"23" => "Kaliningrad",
				"24" => "Kalmyk",
				"25" => "Kaluga",
				"26" => "Kamchatka",
				"27" => "Karachay-Cherkess",
				"28" => "Karelia",
				"29" => "Kemerovo",
				"30" => "Khabarovsk",
				"31" => "Khakass",
				"32" => "Khanty-Mansiy",
				"33" => "Kirov",
				"34" => "Komi",
				"36" => "Koryak",
				"37" => "Kostroma",
				"38" => "Krasnodar",
				"39" => "Krasnoyarsk",
				"40" => "Kurgan",
				"41" => "Kursk",
				"42" => "Leningrad",
				"43" => "Lipetsk",
				"44" => "Magadan",
				"45" => "Mariy-El",
				"46" => "Mordovia",
				"47" => "Moskva",
				"48" => "Moscow City",
				"49" => "Murmansk",
				"50" => "Nenets",
				"51" => "Nizhegorod",
				"52" => "Novgorod",
				"53" => "Novosibirsk",
				"54" => "Omsk",
				"55" => "Orenburg",
				"56" => "Orel",
				"57" => "Penza",
				"58" => "Perm'",
				"59" => "Primor'ye",
				"60" => "Pskov",
				"61" => "Rostov",
				"62" => "Ryazan'",
				"63" => "Sakha",
				"64" => "Sakhalin",
				"65" => "Samara",
				"66" => "Saint Petersburg City",
				"67" => "Saratov",
				"68" => "North Ossetia",
				"69" => "Smolensk",
				"70" => "Stavropol'",
				"71" => "Sverdlovsk",
				"72" => "Tambovskaya oblast",
				"73" => "Tatarstan",
				"74" => "Taymyr",
				"75" => "Tomsk",
				"76" => "Tula",
				"77" => "Tver'",
				"78" => "Tyumen'",
				"79" => "Tuva",
				"80" => "Udmurt",
				"81" => "Ul'yanovsk",
				"83" => "Vladimir",
				"84" => "Volgograd",
				"85" => "Vologda",
				"86" => "Voronezh",
				"87" => "Yamal-Nenets",
				"88" => "Yaroslavl'",
				"89" => "Yevrey",
			];
			return $region;

		} elseif ($data == 'RU') {
			$region = [
				"01" => "Cherkas'ka Oblast'",
				"02" => "Chernihivs'ka Oblast'",
				"03" => "Chernivets'ka Oblast'",
				"04" => "Dnipropetrovs'ka Oblast'",
				"05" => "Donets'ka Oblast'",
				"06" => "Ivano-Frankivs'ka Oblast'",
				"07" => "Kharkivs'ka Oblast'",
				"08" => "Khersons'ka Oblast'",
				"09" => "Khmel'nyts'ka Oblast'",
				"10" => "Kirovohrads'ka Oblast'",
				"11" => "Krym",
				"12" => "Kyyiv",
				"13" => "Kyyivs'ka Oblast'",
				"14" => "Luhans'ka Oblast'",
				"15" => "L'vivs'ka Oblast'",
				"16" => "Mykolayivs'ka Oblast'",
				"17" => "Odes'ka Oblast'",
				"18" => "Poltavs'ka Oblast'",
				"19" => "Rivnens'ka Oblast'",
				"20" => "Sevastopol'",
				"21" => "Sums'ka Oblast'",
				"22" => "Ternopil's'ka Oblast'",
				"23" => "Vinnyts'ka Oblast'",
				"24" => "Volyns'ka Oblast'",
				"25" => "Zakarpats'ka Oblast'",
				"26" => "Zaporiz'ka Oblast'",
				"27" => "Zhytomyrs'ka Oblast'",
			];
			return $region;

		} elseif ($data == 'US') {
			$region = [
				"AA" => "Armed Forces Americas",
				"AE" => "Armed Forces Europe, Middle East, & Canada",
				"AK" => "Alaska",
				"AL" => "Alabama",
				"AP" => "Armed Forces Pacific",
				"AR" => "Arkansas",
				"AS" => "American Samoa",
				"AZ" => "Arizona",
				"CA" => "California",
				"CO" => "Colorado",
				"CT" => "Connecticut",
				"DC" => "District of Columbia",
				"DE" => "Delaware",
				"FL" => "Florida",
				"FM" => "Federated States of Micronesia",
				"GA" => "Georgia",
				"GU" => "Guam",
				"HI" => "Hawaii",
				"IA" => "Iowa",
				"ID" => "Idaho",
				"IL" => "Illinois",
				"IN" => "Indiana",
				"KS" => "Kansas",
				"KY" => "Kentucky",
				"LA" => "Louisiana",
				"MA" => "Massachusetts",
				"MD" => "Maryland",
				"ME" => "Maine",
				"MH" => "Marshall Islands",
				"MI" => "Michigan",
				"MN" => "Minnesota",
				"MO" => "Missouri",
				"MP" => "Northern Mariana Islands",
				"MS" => "Mississippi",
				"MT" => "Montana",
				"NC" => "North Carolina",
				"ND" => "North Dakota",
				"NE" => "Nebraska",
				"NH" => "New Hampshire",
				"NJ" => "New Jersey",
				"NM" => "New Mexico",
				"NV" => "Nevada",
				"NY" => "New York",
				"OH" => "Ohio",
				"OK" => "Oklahoma",
				"OR" => "Oregon",
				"PA" => "Pennsylvania",
				"PW" => "Palau",
				"RI" => "Rhode Island",
				"SC" => "South Carolina",
				"SD" => "South Dakota",
				"TN" => "Tennessee",
				"TX" => "Texas",
				"UT" => "Utah",
				"VA" => "Virginia",
				"VI" => "Virgin Islands",
				"VT" => "Vermont",
				"WA" => "Washington",
				"WI" => "Wisconsin",
				"WV" => "West Virginia",
				"WY" => "Wyoming",
			];
			return $region;

		} elseif ($data == 'UZ') {
			$region = [
				"01" => "Andijon",
				"02" => "Bukhoro",
				"03" => "Farghona",
				"04" => "Jizzakh",
				"05" => "Khorazm",
				"06" => "Namangan",
				"07" => "Nawoiy",
				"08" => "Qashqadaryo",
				"09" => "Qoraqalpoghiston",
				"10" => "Samarqand",
				"11" => "Sirdaryo",
				"12" => "Surkhondaryo",
				"13" => "Toshkent",
				"14" => "Toshkent",
			];
			return $region;

		}

	}

}
