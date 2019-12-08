<?php
/**
 *  ... Please MODIFY this file ...
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	"localhost");				// hostname
 define("DB_USER", 	"-Please Enter Username-");		// database username
 define("DB_PASSWORD", 	"-Please Enter Password-");		// database password
 define("DB_NAME", 	"-Please Enter Database Name-");	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional)", "etc...");
 */
 
 $cryptobox_private_keys = array();




 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys);
 
 

	/* A. Function payment_history()
	*
	* Returns array with history payment details of any of your users / orders / etc. (except unrecognised payments) for custom period - $period
	* It includes -
	* paymentID 	 	- current record id in the table crypto_payments.
	* boxID 	 		- your cryptobox id, the same as on gourl.io member page
	* boxType			- 'paymentbox' or 'captchabox'
	* orderID			- your order id / page name / etc.
	* userID 	 		- your user identifier
	* countryID 	 	- your user's location (country) , 3 letter ISO country code
	* coinLabel 	 	- cryptocurrency label
	* amount 		 	- paid cryptocurrency amount
	* amountUSD 	 	- approximate paid amount in USD with exchange rate on datetime of payment made
	* addr			 	- your internal wallet address on gourl.io which received this payment
	* txID 				- transaction id
	* txDate 			- transaction date (GMT time)
	* txConfirmed		- 0 - unconfirmed transaction/payment or 1 - confirmed transaction/payment with 6+ confirmations
	* 					  you can use function is_confirmed() above, it will connect with payment server and get transaction status (confirmed/unconfirmed)
	* processed			- true/false. True if you called function set_status_processed() before
	* processedDate		- GMT time when you called function set_status_processed()
	* recordCreated		- GMT time a payment record was created in your database
	*/
	function payment_history($boxID = "", $orderID = "", $userID = "", $countryID = "", $boxType = "", $period = "7 DAY")
	{
		if ($boxID 		&& (!is_numeric($boxID) || $boxID < 1 || round($boxID) != $boxID))		return false;
		if ($orderID 	&& preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $orderID) != $orderID) 		return false;
		if ($userID  	&& preg_replace('/[^A-Za-z0-9\.\_\-\@]/', '', $userID)  != $userID)  		return false;
		if ($countryID  && (preg_replace('/[^A-Za-z]/', '', $countryID)  != $countryID || strlen($countryID) != 3)) return false;
		if ($boxType 	&& !in_array($boxType, array('paymentbox','captchabox')))  				return false;
		if ($period  	&& preg_replace('/[^A-Za-z0-9\ ]/', '', $period)  	!= $period)  		return false;
		
		$res = run_sql("SELECT paymentID, boxID, boxType, orderID, userID, countryID, coinLabel, amount, amountUSD, addr, txID, txDate, txConfirmed, processed, processedDate, recordCreated       
						FROM crypto_payments WHERE unrecognised = 0 ".($boxID?" && boxID = $boxID":"").($orderID?" && orderID = '$orderID'":"").($userID?" && userID='$userID'":"").($countryID?" && countryID='".strtoupper($countryID)."'":"").($period?" && recordCreated > DATE_SUB('".gmdate("Y-m-d H:i:s")."', INTERVAL $period)":"")." ORDER BY txDate DESC LIMIT 10000");
	
		if ($res && !is_array($res)) $res = array($res);
		
		return $res;
	}
	

	
	
	
	/* B. Function payment_unrecognised()
	*
	* Returns array with unrecognised payments for custom period - $period.
	* (users paid wrong amount to your internal wallet address). 
	* You will need to process unrecognised payments manually.
	*
	* We forward you ALL coins received to your internal wallet address 
	* including all possible incorrect amount/unrecognised payments 
	* automatically every 30 minutes. 
	* 
	* Therefore if your user contacts us, regarding the incorrect sent payment,
	* we will forward your user to you (because our system forwards all received payments
	* to your wallet automatically every 30 minutes). We provide a payment gateway only.
	* You need to deal with your user directly to resolve the situation or return the incorrect
	* payment back to your user. In unrecognised payments statistics table you will see the
	* original payment sum and transaction ID - when you click on that transaction's ID
	* it will open external blockchain explorer website with wallet address/es showing
	* that payment coming in. You can tell your user about your return of that incorrect
	* payment to one of their sending address (which will protect you from bad claims).
	*
	* You will have a copy of the statistics on your gourl.io member page
	* with details of incorrect received payments.
	* 
	* It includes -
	* paymentID 	 	- current record id in the table crypto_payments.
	* boxID 	 		- your cryptobox id, the same as on gourl.io member page
	* boxType			- 'paymentbox' or 'captchabox'
	* coinLabel 	 	- cryptocurrency label
	* amount 		 	- paid cryptocurrency amount
	* amountUSD 	 	- approximate paid amount in USD with exchange rate on datetime of payment made
	* addr			 	- your internal wallet address on gourl.io which received this payment
	* txID 				- transaction id
	* txDate 			- transaction date (GMT time)
	* recordCreated		- GMT time a payment record was created in your database
	*/
	function payment_unrecognised($boxID = "", $period = "7 DAY")
	{
		if ($boxID && (!is_numeric($boxID) || $boxID < 1 || round($boxID) != $boxID))	return false;
		if ($period && preg_replace('/[^A-Za-z0-9\ ]/', '', $period) != $period) return false;
			
		$res = run_sql("SELECT paymentID, boxID, boxType, coinLabel, amount, amountUSD, addr, txID, txDate, recordCreated
						FROM crypto_payments WHERE unrecognised = 1 ".($boxID?" && boxID = $boxID":"").($period?" && recordCreated > DATE_SUB('".gmdate("Y-m-d H:i:s")."', INTERVAL $period)":"")." ORDER BY txDate DESC LIMIT 10000");
	
		if ($res && !is_array($res)) $res = array($res);
		
		return $res;
	}

	
	
	
	
	/* C. Function cryptobox_sellanguage($default = "en")
	 *
	 *  Get cryptobox current selected language by user (english, spanish, etc)
	 */
	function cryptobox_sellanguage($default = "en")
	{
		$default 		= strtolower($default);
	    $localisation 	= json_decode(CRYPTOBOX_LOCALISATION, true); // List of available languages
	    $id 	 		= (defined("CRYPTOBOX_LANGUAGE_HTMLID")) ? CRYPTOBOX_LANGUAGE_HTMLID : "gourlcryptolang";
	     
	    if(defined("CRYPTOBOX_LANGUAGE"))
	    {
	        if (!isset($localisation[CRYPTOBOX_LANGUAGE])) die("Invalid lanuage value '".CRYPTOBOX_LANGUAGE."' in CRYPTOBOX_LANGUAGE; function cryptobox_language()");
	        else return CRYPTOBOX_LANGUAGE;
	    }

	    if (isset($_GET[$id]) && in_array($_GET[$id], array_keys($localisation)) && !defined("CRYPTOBOX_LANGUAGE_HTMLID_IGNORE")) { $lan = $_GET[$id]; setcookie($id, $lan, time()+7*24*3600, "/"); }
	    elseif (isset($_COOKIE[$id]) && in_array($_COOKIE[$id], array_keys($localisation)) && !defined("CRYPTOBOX_LANGUAGE_HTMLID_IGNORE")) $lan = $_COOKIE[$id];
	    elseif (in_array($default, array_keys($localisation))) $lan = $default;
	    else 	$lan = "en";
	    
	    define("CRYPTOBOX_LANGUAGE", $lan);
	    
	    return $lan;
	}
	
	
	
	
	
	/* D. Function cryptobox_selcoin()
	 *
	 * Get cryptobox current selected coin by user (bitcoin, dogecoin, etc. - for multiple coin payment boxes)
	 */
	function cryptobox_selcoin($coins = array(), $default = "")
	{
	    static $current = "";

	    $default 			= strtolower($default);
	    $available_payments = json_decode(CRYPTOBOX_COINS, true); // List of available crypto currencies
	    $id 	 			= (defined("CRYPTOBOX_COINS_HTMLID")) ? CRYPTOBOX_COINS_HTMLID : "gourlcryptocoin";

	    if ($default && !in_array($default, $coins)) $coins[] = $default;
	    if (!$default && $coins) $default = array_values($coins)[0];
	     
	    
	    if($current)
	    {
	        if (!in_array($current, $available_payments)) $current = $default;
	        else return $current;
	    }
	     
	    
	    // Current Selected Coin
	    if (isset($_GET[$id]) && in_array($_GET[$id], $available_payments) && in_array($_GET[$id], $coins)) { $coinName = $_GET[$id]; setcookie($id, $coinName, time()+7*24*3600, "/"); }
	    elseif (isset($_COOKIE[$id]) && in_array($_COOKIE[$id], $available_payments) && in_array($_COOKIE[$id], $coins)) $coinName = $_COOKIE[$id];
	    else $coinName = $default;
	
	    $current =  $coinName;
	     
	    return $coinName;
	}
	
	
	
	
	    
	/* E. Function display_language_box()
	 * 
	 * Language selection dropdown list for cryptocoin payment box<br>
	 * $no_bootstrap = false - use dropdown list in bootstrap
	 */
	function display_language_box($default = "en", $anchor = "gourlcryptolang", $no_bootstrap = true)
	{
	    
		$default 		= strtolower($default);
		$localisation 	= json_decode(CRYPTOBOX_LOCALISATION, true);
		$id 	 		= (defined("CRYPTOBOX_LANGUAGE_HTMLID")) ? CRYPTOBOX_LANGUAGE_HTMLID : "gourlcryptolang";
		$arr 	 		= $_GET;
		if (isset($arr[$id])) unset($arr[$id]);
		
		$lan = cryptobox_sellanguage($default);
		
		$url = $_SERVER["REQUEST_URI"];
		if (mb_strpos($url, "?")) $url = mb_substr($url, 0, mb_strpos($url, "?"));
		
		// <select> html tag list
		if ($no_bootstrap)
		{
    		$tmp  = "<select name='$id' id='$id' onchange='window.open(\"//".$_SERVER["HTTP_HOST"].$url."?".http_build_query($arr).($arr?"&amp;":"").$id."=\"+this.options[this.selectedIndex].value+\"#".$anchor."\",\"_self\")' style='width:130px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666;border-radius:5px;-moz-border-radius:5px;border: #ccc 1px solid;margin:0;padding:3px 0 3px 6px;white-space:nowrap;overflow:hidden;display:inline;'>";
    		foreach ($localisation as $k => $v) $tmp .= "<option ".($k==$lan?"selected":"")." value='$k'>".$v["name"]."</option>";
    		$tmp .= "</select>";
		}
		else
		// bootstrap4
		{
		    $tmp  = "<div class='dropdown-menu'>";
		    foreach ($localisation as $k => $v) $tmp .= "<a href='//".$_SERVER["HTTP_HOST"].$url."?".http_build_query($arr).($arr?"&amp;":"").$id."=".$k."#".$anchor."' class='dropdown-item".($lan==$k?"  active":"")."'>".$v["name"]."</a>";
		    $tmp  .= "</div>";
		}
				
		return $tmp; 
	}
	
	
	

	
	/* F. Function display_currency_box()
	 *
	* Multiple crypto currency selection list. You can accept payments in multiple crypto currencies
	* For example you can accept payments in bitcoin, bitcoincash, bitcoinsv, litecoin, etc and use the same price in USD
	*/
	function display_currency_box($coins = array(), $def_coin = "", $def_language = "en", $iconWidth = 50, $style = "width:350px; margin: 10px 0 10px 320px", $directory = "images", $anchor = "gourlcryptocoins", $jquery = false)
	{
		if (!$coins) return "";

		$directory          = rtrim($directory, "/");
		$def_coin 			= strtolower($def_coin);
		$def_language 			= strtolower($def_language);
		$available_payments = json_decode(CRYPTOBOX_COINS, true);
		$localisation       = json_decode(CRYPTOBOX_LOCALISATION, true);
		$arr 	 			= $_GET;
		$id 	 			= (defined("CRYPTOBOX_COINS_HTMLID")) ? CRYPTOBOX_COINS_HTMLID : "gourlcryptocoin";
		
		if (!in_array($def_coin, $available_payments)) die("Invalid your default value '$def_coin' in display_currency_box()");
		if (!in_array($def_coin, $coins)) $coins[] = $def_coin; 
		
		$coins = array_map('strtolower', $coins);
		$coins = array_unique($coins);
		if (count($coins) <= 1) return "";
		
		
		// Current Coin
		$coinName = cryptobox_selcoin($coins, $def_coin);
		
		
		// Url for Change Coin
		$coin_url = $_SERVER["REQUEST_URI"];
		if (mb_strpos($coin_url, "?")) $coin_url = mb_substr($coin_url, 0, mb_strpos($coin_url, "?"));
		if (isset($arr[$id])) unset($arr[$id]);
		$coin_url = "//".$_SERVER["HTTP_HOST"].$coin_url."?".http_build_query($arr).($arr?"&amp;":"").$id."=";
		
		// Current Language
		$lan = cryptobox_sellanguage($def_language);
		$localisation = $localisation[$lan];
		
		
		$tmp = '<div'.($anchor=="gourlcryptocoins"?" id='$anchor'":"").' style="'.trim(trim(htmlspecialchars($style, ENT_COMPAT), "; ")."; text-align:center", "; ").'"><div style="margin-bottom:15px"><b>'.$localisation["payment"].' -</b></div>';
		foreach ($coins as $v)
		{
			$v = trim(strtolower($v));
			if (!in_array($v, $available_payments)) die("Invalid your submitted value '$v' in display_currency_box()");
			if (strpos(CRYPTOBOX_PRIVATE_KEYS, ucfirst($v)."77") === false) die("Please add your Private Key for '$v' in variable \$cryptobox_private_keys, file cryptobox.config.php");
			$url = $coin_url.$v."#".$anchor;
			
			if ($jquery) $tmp .= "<input type='radio' class='aradioimage' data-title='".str_replace("%coinName%", ucfirst($v), $localisation["pay_in"])."' ".($coinName==$v?"checked":"")." data-url='$url' data-width='$iconWidth' data-alt='".str_replace("%coinName%", $v, $localisation["pay_in"])."' data-image='".$directory."/".$v.($iconWidth>70?"2":"").".png' name='aradioname' value='$v'>&#160; ".($iconWidth>70 || count($coins)<4?"&#160; ":"");
			else $tmp .= "<a href='".$url."' onclick=\"location.href='".$url."';\"><img style='box-shadow:none;margin:".round($iconWidth/10)."px ".round($iconWidth/6)."px;border:0;display:inline;' width='$iconWidth' title='".str_replace("%coinName%", ucfirst($v), $localisation["pay_in"])."' alt='".str_replace("%coinName%", $v, $localisation["pay_in"])."' src='".$directory."/".$v.($iconWidth>70?"2":"").".png'></a>";
		}
		$tmp .= "</div>";
		
		return $tmp;
	}
	

	
	

	/* G. Function get_country_name()
	 * 
	 * Get country name by country code
	 */
	function get_country_name($countryID, $reverse = false)
	{
		$arr = array("AFG"=>"Afghanistan", "ALA"=>"Aland Islands", "ALB"=>"Albania", "DZA"=>"Algeria", "ASM"=>"American Samoa", "AND"=>"Andorra", "AGO"=>"Angola", "AIA"=>"Anguilla", "ATA"=>"Antarctica", "ATG"=>"Antigua and Barbuda", "ARG"=>"Argentina", "ARM"=>"Armenia", "ABW"=>"Aruba", "AUS"=>"Australia", "AUT"=>"Austria", "AZE"=>"Azerbaijan", "BHS"=>"Bahamas", "BHR"=>"Bahrain", "BGD"=>"Bangladesh", "BRB"=>"Barbados", "BLR"=>"Belarus", "BEL"=>"Belgium", "BLZ"=>"Belize", "BEN"=>"Benin", "BMU"=>"Bermuda", "BTN"=>"Bhutan", "BOL"=>"Bolivia", "BIH"=>"Bosnia and Herzegovina", "BWA"=>"Botswana", "BVT"=>"Bouvet Island", "BRA"=>"Brazil", "IOT"=>"British Indian Ocean Territory", "BRN"=>"Brunei", "BGR"=>"Bulgaria", "BFA"=>"Burkina Faso", "BDI"=>"Burundi", "KHM"=>"Cambodia", "CMR"=>"Cameroon", "CAN"=>"Canada", "CPV"=>"Cape Verde", "BES"=>"Caribbean Netherlands", "CYM"=>"Cayman Islands", "CAF"=>"Central African Republic", "TCD"=>"Chad", "CHL"=>"Chile", "CHN"=>"China", "CXR"=>"Christmas Island", "CCK"=>"Cocos (Keeling) Islands", "COL"=>"Colombia", "COM"=>"Comoros", "COG"=>"Congo", "COD"=>"Congo, Democratic Republic", "COK"=>"Cook Islands", "CRI"=>"Costa Rica", "CIV"=>"Cote d'Ivoire", "HRV"=>"Croatia", "CUB"=>"Cuba", "CUW"=>"Curacao", "CBR"=>"Cyberbunker", "CYP"=>"Cyprus", "CZE"=>"Czech Republic", "DNK"=>"Denmark", "DJI"=>"Djibouti", "DMA"=>"Dominica", "DOM"=>"Dominican Republic", "TMP"=>"East Timor", "ECU"=>"Ecuador", "EGY"=>"Egypt", "SLV"=>"El Salvador", "GNQ"=>"Equatorial Guinea", "ERI"=>"Eritrea", "EST"=>"Estonia", "ETH"=>"Ethiopia", "EUR"=>"European Union", "FLK"=>"Falkland Islands", "FRO"=>"Faroe Islands", "FJI"=>"Fiji Islands", "FIN"=>"Finland", "FRA"=>"France", "GUF"=>"French Guiana", "PYF"=>"French Polynesia", "ATF"=>"French Southern territories", "GAB"=>"Gabon", "GMB"=>"Gambia", "GEO"=>"Georgia", "DEU"=>"Germany", "GHA"=>"Ghana", "GIB"=>"Gibraltar", "GRC"=>"Greece", "GRL"=>"Greenland", "GRD"=>"Grenada", "GLP"=>"Guadeloupe", "GUM"=>"Guam", "GTM"=>"Guatemala", "GGY"=>"Guernsey", "GIN"=>"Guinea", "GNB"=>"Guinea-Bissau", "GUY"=>"Guyana", "HTI"=>"Haiti", "HMD"=>"Heard Island and McDonald Islands", "HND"=>"Honduras", "HKG"=>"Hong Kong", "HUN"=>"Hungary", "ISL"=>"Iceland", "IND"=>"India", "IDN"=>"Indonesia", "IRN"=>"Iran", "IRQ"=>"Iraq", "IRL"=>"Ireland", "IMN"=>"Isle of Man", "ISR"=>"Israel", "ITA"=>"Italy", "JAM"=>"Jamaica", "JPN"=>"Japan", "JEY"=>"Jersey", "JOR"=>"Jordan", "KAZ"=>"Kazakstan", "KEN"=>"Kenya", "KIR"=>"Kiribati", "KWT"=>"Kuwait", "KGZ"=>"Kyrgyzstan", "LAO"=>"Laos", "LVA"=>"Latvia", "LBN"=>"Lebanon", "LSO"=>"Lesotho", "LBR"=>"Liberia", "LBY"=>"Libya", "LIE"=>"Liechtenstein", "LTU"=>"Lithuania", "LUX"=>"Luxembourg", "MAC"=>"Macao", "MKD"=>"Macedonia", "MDG"=>"Madagascar", "MWI"=>"Malawi", "MYS"=>"Malaysia", "MDV"=>"Maldives", "MLI"=>"Mali", "MLT"=>"Malta", "MHL"=>"Marshall Islands", "MTQ"=>"Martinique", "MRT"=>"Mauritania", "MUS"=>"Mauritius", "MYT"=>"Mayotte", "MEX"=>"Mexico", "FSM"=>"Micronesia, Federated States", "MDA"=>"Moldova", "MCO"=>"Monaco", "MNG"=>"Mongolia", "MNE"=>"Montenegro", "MSR"=>"Montserrat", "MAR"=>"Morocco", "MOZ"=>"Mozambique", "MMR"=>"Myanmar", "NAM"=>"Namibia", "NRU"=>"Nauru", "NPL"=>"Nepal", "NLD"=>"Netherlands", "ANT"=>"Netherlands Antilles", "NCL"=>"New Caledonia", "NZL"=>"New Zealand", "NIC"=>"Nicaragua", "NER"=>"Niger", "NGA"=>"Nigeria", "NIU"=>"Niue", "NFK"=>"Norfolk Island", "PRK"=>"North Korea", "MNP"=>"Northern Mariana Islands", "NOR"=>"Norway", "OMN"=>"Oman", "PAK"=>"Pakistan", "PLW"=>"Palau", "PSE"=>"Palestine", "PAN"=>"Panama", "PNG"=>"Papua New Guinea", "PRY"=>"Paraguay", "PER"=>"Peru", "PHL"=>"Philippines", "PCN"=>"Pitcairn", "POL"=>"Poland", "PRT"=>"Portugal", "PRI"=>"Puerto Rico", "QAT"=>"Qatar", "REU"=>"Reunion", "ROM"=>"Romania", "RUS"=>"Russia", "RWA"=>"Rwanda", "BLM"=>"Saint Barthelemy", "SHN"=>"Saint Helena", "KNA"=>"Saint Kitts and Nevis", "LCA"=>"Saint Lucia", "MAF"=>"Saint Martin", "SPM"=>"Saint Pierre and Miquelon", "VCT"=>"Saint Vincent and the Grenadines", "WSM"=>"Samoa", "SMR"=>"San Marino", "STP"=>"Sao Tome and Principe", "SAU"=>"Saudi Arabia", "SEN"=>"Senegal", "SRB"=>"Serbia", "SYC"=>"Seychelles", "SLE"=>"Sierra Leone", "SGP"=>"Singapore", "SXM"=>"Sint Maarten", "SVK"=>"Slovakia", "SVN"=>"Slovenia", "SLB"=>"Solomon Islands", "SOM"=>"Somalia", "ZAF"=>"South Africa", "SGS"=>"South Georgia and the South Sandwich Islands", "KOR"=>"South Korea", "SSD"=>"South Sudan", "ESP"=>"Spain", "LKA"=>"Sri Lanka", "SDN"=>"Sudan", "SUR"=>"Suriname", "SJM"=>"Svalbard and Jan Mayen", "SWZ"=>"Swaziland", "SWE"=>"Sweden", "CHE"=>"Switzerland", "SYR"=>"Syria", "TWN"=>"Taiwan", "TJK"=>"Tajikistan", "TZA"=>"Tanzania", "THA"=>"Thailand", "TGO"=>"Togo", "TKL"=>"Tokelau", "TON"=>"Tonga", "TTO"=>"Trinidad and Tobago", "TUN"=>"Tunisia", "TUR"=>"Turkey", "TKM"=>"Turkmenistan", "TCA"=>"Turks and Caicos Islands", "TUV"=>"Tuvalu", "UGA"=>"Uganda", "UKR"=>"Ukraine", "ARE"=>"United Arab Emirates", "GBR"=>"United Kingdom", "UMI"=>"United States Minor Outlying Islands", "URY"=>"Uruguay", "USA"=>"USA", "UZB"=>"Uzbekistan", "VUT"=>"Vanuatu", "VAT"=>"Vatican (Holy See)", "VEN"=>"Venezuela", "VNM"=>"Vietnam", "VGB"=>"Virgin Islands, British", "VIR"=>"Virgin Islands, U.S.", "WLF"=>"Wallis and Futuna", "ESH"=>"Western Sahara", "XKX"=>"Kosovo", "YEM"=>"Yemen", "ZMB"=>"Zambia", "ZWE"=>"Zimbabwe");
		
		if ($reverse) $result = array_search(ucwords(mb_strtolower($countryID)), $arr);
		elseif (isset($arr[strtoupper($countryID)])) $result = $arr[strtoupper($countryID)];
		
		if (!$result) $result = "";
		
		return $result;
	}
	
	
	
	
	
	/* H. Function convert_currency_live()
	 *
	 * Currency Converter using live exchange rates websites
	 * Example - convert_currency_live("EUR", "USD", 22.37) - convert 22.37euro to usd
	             convert_currency_live("EUR", "BTC", 22.37) - convert 22.37euro to bitcoin
	   optional - currencyconverterapi_key you can get on https://free.currencyconverterapi.com/free-api-key
	 */
	function convert_currency_live($from_Currency, $to_Currency, $amount, $currencyconverterapi_key = "")
	{
	    static $arr = array();
	    
	    $from_Currency = trim(strtoupper(urlencode($from_Currency)));
	    $to_Currency   = trim(strtoupper(urlencode($to_Currency)));
	    
	    if ($from_Currency == "TRL") $from_Currency = "TRY"; // fix for Turkish Lyra
	    if ($from_Currency == "ZWD") $from_Currency = "ZWL"; // fix for Zimbabwe Dollar
	    if ($from_Currency == "RM")  $from_Currency = "MYR"; // fix for Malaysian Ringgit
	    if ($from_Currency == "XBT") $from_Currency = "BTC"; // fix for Bitcoin
	    if ($to_Currency   == "XBT") $to_Currency   = "BTC"; // fix for Bitcoin
	    
	    if ($from_Currency == "RIAL") $from_Currency = "IRR"; // fix for Iranian Rial
	    if ($from_Currency == "IRT") { $from_Currency = "IRR"; $amount = $amount * 10; } // fix for Iranian Toman; 1IRT = 10IRR
	    
	    $key  = $from_Currency."_".$to_Currency;
	    
	    
	    
	    // a. restore saved exchange rate
	    // ----------------
	    if (!isset($arr[$key]) && session_status() === PHP_SESSION_ACTIVE && isset($_SESSION["exch_".$key]) && is_numeric($_SESSION["exch_".$key]) && $_SESSION["exch_".$key] > 0) $arr[$key] = $_SESSION["exch_".$key];
	    
	    if (isset($arr[$key]))
	    {
	        if ($arr[$key] > 0)
	        {
	            $val = $arr[$key];
	            $total = $val*$amount;
	            if ($to_Currency=="BTC" || $total<0.01) $total = sprintf('%.5f', round($total, 5));
	            else $total = round($total, 2);
	            if ($total == 0) $total = sprintf('%.5f', 0.00001);
	            return $total;
	        }
	        else return -1;
	    }
	    
	    
	    $val = 0;
	    if ($from_Currency == $to_Currency)  $val = 1;
	    
	    
	    
	    // b. get BTC rates
	    // ----------------
	    $bitcoinUSD = 0;
	    if (!$val && ($from_Currency == "BTC" || $to_Currency == "BTC"))
	    {
	        $aval = array ('BTC', 'USD', 'AUD', 'BRL', 'CAD', 'CHF', 'CLP', 'CNY', 'DKK', 'EUR', 'GBP', 'HKD', 'INR', 'ISK', 'JPY', 'KRW', 'NZD', 'PLN', 'RUB', 'SEK', 'SGD', 'THB', 'TWD');
	        if (in_array($from_Currency, $aval) && in_array($to_Currency, $aval))
	        {
	            $data = json_decode(get_url_contents("https://blockchain.info/ticker"), true);
	            
	            // rates BTC->...
	            $rates = array("BTC" => 1);
	            if ($data) foreach($data as $k => $v) $rates[$k] = ($v["15m"] > 1000) ? round($v["15m"]) : ($v["last"] > 1000 ? round($v["last"]) : 0);
	            // convert BTC/USD, EUR/BTC, etc.
	            if (isset($rates[$to_Currency]) && $rates[$to_Currency] > 0 && isset($rates[$from_Currency]) && $rates[$from_Currency] > 0) $val = $rates[$to_Currency] / $rates[$from_Currency];
	            if (isset($rates["USD"]) && $rates["USD"] > 0) $bitcoinUSD = $rates["USD"];
	        }
	        
	        if (!$val && $bitcoinUSD < 1000)
	        {
	            $data = json_decode(get_url_contents("https://www.bitstamp.net/api/ticker/"), true);
	            if (isset($data["last"]) && isset($data["volume"]) && $data["last"] > 1000) $bitcoinUSD = round($data["last"]);
	        }
	        
	        if ($from_Currency == "BTC" && $to_Currency == "USD" && $bitcoinUSD > 0) $val  =  $bitcoinUSD;
	        if ($from_Currency == "USD" && $to_Currency == "BTC" && $bitcoinUSD > 0) $val  =  1 / $bitcoinUSD;
	    }
	    
	    
	    
	    // c. get rates from European Central Bank https://www.ecb.europa.eu
	    // ----------------
	    $aval = array ('EUR', 'USD', 'JPY', 'BGN', 'CZK', 'DKK', 'GBP', 'HUF', 'PLN', 'RON', 'SEK', 'CHF', 'ISK', 'NOK', 'HRK', 'RUB', 'TRY', 'AUD', 'BRL', 'CAD', 'CNY', 'HKD', 'IDR', 'ILS', 'INR', 'KRW', 'MXN', 'MYR', 'NZD', 'PHP', 'SGD', 'THB', 'ZAR');
	    if ($bitcoinUSD > 0) $aval[] = "BTC";
	    if (!$val && in_array($from_Currency, $aval) && in_array($to_Currency, $aval))
	    {
	        $xml = simplexml_load_string(get_url_contents("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml"));
	        $json = json_encode($xml);
	        $data = json_decode($json,TRUE);
	        
	        if (isset($data["Cube"]["Cube"]))
	        {
	            $data = $data["Cube"]["Cube"];
	            $time = $data["@attributes"]["time"];
	            
	            // rates EUR->...
	            $rates = array("EUR" => 1);
	            foreach($data["Cube"] as $v) $rates[$v["@attributes"]["currency"]] = floatval($v["@attributes"]["rate"]);
	            if ($bitcoinUSD > 0 && $rates["USD"] > 0) $rates["BTC"] = $rates["USD"] / $bitcoinUSD;
	            
	            // convert USD/JPY, EUR/GBP, etc.
	            if ($rates[$to_Currency] > 0 && $rates[$from_Currency] > 0) $val = $rates[$to_Currency] / $rates[$from_Currency];
	        }
	    }
	    
	    
	    // d. get rates from https://free.currencyconverterapi.com/api/v6/convert?q=BTC_EUR&compact=y
	    // ----------------
	    if (!$val)
	    {
	        $data = json_decode(get_url_contents("https://free.currencyconverterapi.com/api/v6/convert?q=".$key."&compact=ultra&apiKey=".$currencyconverterapi_key, 20, TRUE), TRUE);
	        if (isset($data[$key]) && $data[$key] > 0) $val = $data[$key];
	        elseif(isset($data["error"])) echo "<h1>Error in function convert_currency_live(...)! ". $data["error"] . "</h1>";
	    }
	    
	    
	    // e. result
	    // ------------
	    if ($val > 0)
	    {
	        if (session_status() === PHP_SESSION_ACTIVE) $_SESSION["exch_".$key] = $val;
	        
	        $arr[$key] = $val;
	        $total = $val*$amount;
	        if ($to_Currency=="BTC" || $total<0.01) $total = sprintf('%.5f', round($total, 5));
	        else $total = round($total, 2);
	        if ($total == 0) $total = sprintf('%.5f', 0.00001);
	        return $total;
	    }
	    else
	    {
	        $arr[$key] = -1;
	        return -1;
	    }
	}

	
	
	/*	I. Get URL Data
	*/
	function get_url_contents( $url, $timeout = 20, $ignore_httpcode = false )
	{
	    $ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt ($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko");
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
	    $data 		= curl_exec($ch);
	    $httpcode 	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	
	    return (($httpcode>=200 && $httpcode<300) || $ignore_httpcode) ? $data : false;
	}
	
	
	
	
	/* J. Function validate_gourlkey()
	 *
	* Validate gourl private/public/affiliate keys
	* $key 	 	- gourl payment box key
	* $type 	- public, private, affiliate
	* @return 	- true or false 
	*/
	function validate_gourlkey ( $key, $type )
	{
		if (!$key || !in_array($type, array('public', 'private', 'affiliate'))) return false;
		
		$valid = false;
		if ($type == 'public' && strpos($key, 'AA') && strlen($key) == 50)
		{
			$boxID = substr($key, 0, strpos($key, 'AA'));
			if (preg_replace('/[^A-Za-z0-9]/', '', $key) == $key &&
				$boxID && is_numeric($boxID) &&
				strpos($key, "77") !== false &&
				strpos($key, "PUB")) $valid = true;
		}
		elseif ($type == 'private' && strpos($key, 'AA') && strlen($key) == 50)
		{
			$boxID = substr($key, 0, strpos($key, 'AA'));
			if (preg_replace('/[^A-Za-z0-9]/', '', $key) == $key &&
				$boxID && is_numeric($boxID) &&
				strpos($key, "77") !== false &&
				strpos($key, "PRV")) $valid = true;
		}
		elseif ($type == 'affiliate')
		{
			if (preg_replace('/[^A-Z0-9]/', '', $key) == $key &&
				strpos($key, "DEV") === 0 &&
				strpos($key, "G") &&
				is_numeric(substr($key, -2))) $valid = true;
		}
		
		return $valid;
	}
	
	
	
	
	
	/* K. Function run_sql()
	 *
	 * Run SQL queries and return result in array/object formats
	 */
	function run_sql($sql)
	{
		static $mysqli;
	
		$f = true;
		$g = $x = false;
		$res = array();
	
		if (!$mysqli)
		{
			$dbhost = DB_HOST;
			$port = NULL; $socket = NULL; 
			if (strpos(DB_HOST, ":"))
			{ 
				list($dbhost, $port) = explode(':', DB_HOST);
				if (is_numeric($port)) $port = (int) $port;
				else
				{
					$socket = $port;
					$port = NULL;
				}
			}
			$mysqli = @mysqli_connect($dbhost, DB_USER, DB_PASSWORD, DB_NAME, $port, $socket);			
			$err = (mysqli_connect_errno()) ? mysqli_connect_error() : "";
			if ($err)
			{
				// try SSL connection
				$mysqli = mysqli_init();
				$mysqli->real_connect ($dbhost, DB_USER, DB_PASSWORD, DB_NAME, $port, $socket, MYSQLI_CLIENT_SSL);
			}
			if (mysqli_connect_errno())
			{
				echo "<br /><b>Error. Can't connect to your MySQL server.</b> You need to have PHP 5.2+ and MySQL 5.5+ with mysqli extension activated. <a href='http://crybit.com/how-to-enable-mysqli-extension-on-web-server/'>Instruction &#187;</a>\n";
				if (!CRYPTOBOX_WORDPRESS) echo "<br />Also <b>please check DB username/password in file cryptobox.config.php</b>\n";
				die("<br />Server has returned error - <b>".$err."</b>");
			}
			$mysqli->query("SET NAMES utf8");
		}

		$query = $mysqli->query($sql);

		if ($query === FALSE)
        {
            if (!CRYPTOBOX_WORDPRESS && stripos(str_replace('"', '', str_replace("'", "", $mysqli->error)), "crypto_payments doesnt exist"))
            {
                // Try to create new table - https://github.com/cryptoapi/Payment-Gateway#mysql-table
                $mysqli->query("CREATE TABLE `crypto_payments` (
                              `paymentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
                              `boxID` int(11) unsigned NOT NULL DEFAULT '0',
                              `boxType` enum('paymentbox','captchabox') NOT NULL,
                              `orderID` varchar(50) NOT NULL DEFAULT '',
                              `userID` varchar(50) NOT NULL DEFAULT '',
                              `countryID` varchar(3) NOT NULL DEFAULT '',
                              `coinLabel` varchar(6) NOT NULL DEFAULT '',
                              `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
                              `amountUSD` double(20,8) NOT NULL DEFAULT '0.00000000',
                              `unrecognised` tinyint(1) unsigned NOT NULL DEFAULT '0',
                              `addr` varchar(34) NOT NULL DEFAULT '',
                              `txID` char(64) NOT NULL DEFAULT '',
                              `txDate` datetime DEFAULT NULL,
                              `txConfirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
                              `txCheckDate` datetime DEFAULT NULL,
                              `processed` tinyint(1) unsigned NOT NULL DEFAULT '0',
                              `processedDate` datetime DEFAULT NULL,
                              `recordCreated` datetime DEFAULT NULL,
                              PRIMARY KEY (`paymentID`),
                              KEY `boxID` (`boxID`),
                              KEY `boxType` (`boxType`),
                              KEY `userID` (`userID`),
                              KEY `countryID` (`countryID`),
                              KEY `orderID` (`orderID`),
                              KEY `amount` (`amount`),
                              KEY `amountUSD` (`amountUSD`),
                              KEY `coinLabel` (`coinLabel`),
                              KEY `unrecognised` (`unrecognised`),
                              KEY `addr` (`addr`),
                              KEY `txID` (`txID`),
                              KEY `txDate` (`txDate`),
                              KEY `txConfirmed` (`txConfirmed`),
                              KEY `txCheckDate` (`txCheckDate`),
                              KEY `processed` (`processed`),
                              KEY `processedDate` (`processedDate`),
                              KEY `recordCreated` (`recordCreated`),
                              KEY `key1` (`boxID`,`orderID`),
                              KEY `key2` (`boxID`,`orderID`,`userID`),
                              UNIQUE KEY `key3` (`boxID`, `orderID`, `userID`, `txID`, `amount`, `addr`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");

                $query = $mysqli->query($sql);  // re-run previous query
            }
            if ($query === FALSE) die("MySQL Error: ".$mysqli->error."; SQL: $sql");
        }

		if (is_object($query) && $query->num_rows)
		{
			while($row = $query->fetch_object())
			{
				if ($f)
				{
					if (property_exists($row, "idx")) $x = true;
					$c = count(get_object_vars($row));
					if ($c > 2 || ($c == 2 && !$x)) $g = true;
					elseif (!property_exists($row, "nme")) die("Error in run_sql() - 'nme' not exists! SQL: $sql");
					$f = false;
				}
	
				if (!$g && $query->num_rows == 1 && property_exists($row, "nme")) return $row->nme;
				elseif ($x) $res[$row->idx] = ($g) ? $row : $row->nme;
				else $res[] = ($g) ? $row : $row->nme;
			}
		}
		elseif (stripos($sql, "insert ") !== false) $res = $mysqli->insert_id;

		if (is_object($query)) $query->close();
		if (is_array($res) && count($res) == 1 && isset($res[0]) && is_object($res[0])) $res = $res[0];

		return $res;
	}
	
	

?>