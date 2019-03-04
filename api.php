<?php 
namespace Api;

Class HeadRequest {

	private static $valid_mac = "([0-9A-F]{2}[:-]){5}([0-9A-F]{2})"; /* patron de Mac Address */
	private static $url = 'http://ip-api.com/json/'; /* Api */

	public function userAgent () {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	public static function getIP () { /* Mostrar Ip Client 192.168.5.1 */
		$server = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED'
		];

		foreach ($server as $value) 
			if (isset($_SERVER[$value])) return $_SERVER[$value];
		
		return $_SERVER["REMOTE_ADDR"]; 
	}

	public function showDataIP ( $ip = null) { /* Mostrar ip y datos de localizacion */
		if ($ip) 
			$data = file_get_contents(self::$url . $ip);
		else 
			$data = file_get_contents(self::$url . self::getIP());
		
		$json = json_decode($data, true);
		return json_encode($json);
	}

	public function getPlatform () { /* Mostrar Sistema Operativo */
		$platforms = [
	      'Windows 10'    => 'Windows NT 10.0+',
	      'Windows 8.1'   => 'Windows NT 6.3+',
	      'Windows 8'     => 'Windows NT 6.2+',
	      'Windows 7'     => 'Windows NT 6.1+',
	      'Windows Vista' => 'Windows NT 6.0+',
	      'Windows XP'    => 'Windows NT 5.1+',
	      'Windows 2003'  => 'Windows NT 5.2+',
	      'Windows Phone' => 'Windows Phone',
	      'Windows'       => 'Windows otros',
	      'iPhone'        => 'iPhone',
	      'iPad'          => 'iPad',
	      'Mac OS X'      => '(Mac OS X+)|(CFNetwork+)',
	      'Mac otros'     => 'Macintosh',
	      'Android Jelly Bean' => 'Android 4.1.2',
	      'Android'       => 'Android',
	      'BlackBerry'    => 'BlackBerry',
	      'Linux '        => 'Linux',
	   ];

	   foreach( $platforms as $platform => $pattern )
	   		if (eregi($pattern, self::userAgent())) return $platform;

	   return 'Otras';
	}

	public static function getBrowser () { /* Mostrar Navegador */
		$browsers = [
			'Maxthon'         => 'Maxthon',
			'SeaMonkey'       => 'SeaMonkey',
			'Vivaldi'         => 'Vivaldi',
			'Arora'           => 'Arora',
			'Avant Browser'   => 'Avant Browser',
			'Beamrise'        => 'Beamrise',
			'Epiphany'        => 'Epiphany',
			'Chromium'        => 'Chromium',
			'Iceweasel'       => 'Iceweasel',
			'Galeon'          => 'Galeon',
			'Edge'            => 'Microsoft Edge',
			'Trident'         => 'Internet Explorer', //IE 11
			'MSIE'            => 'Internet Explorer',
			'Opera Mini'      => 'Opera Mini',
			'Opera'           => 'Opera',
			'OPR'             => 'Opera',
			'Firefox'         => 'Mozilla Firefox',
			'Chrome'          => 'Google Chrome',
			'Safari'          => 'Safari',
			'iTunes'          => 'iTunes',
			'Konqueror'       => 'Konqueror',
			'Dillo'           => 'Dillo',
			'Netscape'        => 'Netscape',
			'Midori'          => 'Midori',
			'ELinks'          => 'ELinks',
			'Links'           => 'Links',
			'Lynx'            => 'Lynx',
			'w3m'             => 'w3m',
			'Browser Unknown' => 'Browser Unknown'
		];

		foreach ($browsers as $key => $value) 
			if (strpos(' ' . self::userAgent(), $key)) return $value;
		
		return $browsers['Browser Unknown'];
	}

	protected static function runCommand($command) { /* ejecuto command */
        return shell_exec($command);
    }

	public static function getCurrentMacAddress () { /* Mostrar Mac Address  */
        $ifconfig = self::runCommand("ifconfig eth0");
        preg_match("/" . self::$valid_mac . "/i", $ifconfig, $ifconfig);
        if (isset($ifconfig[0])) {
            return trim(strtoupper($ifconfig[0]));
        }
        return false;
    }

    public static function headDataRequest () { /* Mostrar datos completos ip, localizacion, navegador, Sistema Operativo y Mac Address */
    	$data = json_decode(self::showDataIP('186.90.129.247'), true);
    	
    	if (!$data) 
    		$data = json_decode(self::showDataIP(), true);
    	
    	$data['ip'] = $data['query'];
    	$data['Browser']    = self::getBrowser();
    	$data['Platform']   = self::getPlatform();
    	$data['MacAddress'] = self::getCurrentMacAddress();
    	unset($data['query']);

    	return json_encode($data);
    }

}
