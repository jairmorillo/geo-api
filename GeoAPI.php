<?php

/**
 * 
 * 
 * @version 1.0.0
 * @author Jair Morillo <jairantoniom@gmail.com>
 */
abstract class GeoAPI{
	

    /**
     * Para obtener la IP del visitante
     *
     * @return string
     */
	public static function getIP ()
	{
		if (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif  (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif  (isset($_SERVER["HTTP_X_FORWARDED"]))
		{
			return $_SERVER["HTTP_X_FORWARDED"];
		}
		elseif  (isset($_SERVER["HTTP_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_FORWARDED_FOR"];
		}
		elseif  (isset($_SERVER["HTTP_FORWARDED"]))
		{
			return $_SERVER["HTTP_FORWARDED"];
		}
		else
		{
			return $_SERVER["REMOTE_ADDR"];
		}
	}


    /**
     * Undocumented function
     *
     * @return void
     */
	private static function dispositivo ()	{
		$tablet_browser = 0;
		$mobile_browser = 0;
		$body_class = 'desktop';
 
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
			$tablet_browser++;
 			$body_class = "tablet";
		}
             
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
			$mobile_browser++;
			$body_class = "mobile";
		}
             
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
		{
			$mobile_browser++;
			$body_class = "mobile";
		}
             
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-'
        );

        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
             
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0)
        {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
           
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua))
            {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0)
        {
            // Si es tablet has lo que necesites
            return 'tablet';
        } else if ($mobile_browser > 0) {
            // Si es dispositivo mobil has lo que necesites
            return 'mobil';
        } 
        else
        {
         // Si es ordenador de escritorio has lo que necesites
            return 'desktop';
        }

    }	


     /**
      * Para obtener la IP del propio servidor
      *
      * @return string
      */
    private static function ownIP (){
        $ip= file_get_contents('http://myip.eu/');
        $ip= substr($ip,strpos($ip,'<font size=5>')+14);
        $ip= substr($ip,0,strpos($ip,'<br'));
        return $ip;
    }



    /**
     * optener navegador del visitante
     *
     * @param string $user_agent
     * @return string
     */
    private static function getBrowser ($user_agent)
    {
        if (strpos($user_agent, 'Maxthon') !== FALSE)
            return "Maxthon";
        elseif (strpos($user_agent, 'SeaMonkey') !== FALSE)
            return "SeaMonkey";
        elseif (strpos($user_agent, 'Vivaldi') !== FALSE)
            return "Vivaldi";
        elseif (strpos($user_agent, 'Arora') !== FALSE)
            return "Arora";
        elseif (strpos($user_agent, 'Avant Browser') !== FALSE)
            return "Avant Browser";
        elseif (strpos($user_agent, 'Beamrise') !== FALSE)
            return "Beamrise";
        elseif (strpos($user_agent, 'Epiphany') !== FALSE)
            return 'Epiphany';
        elseif (strpos($user_agent, 'Chromium') !== FALSE)
            return 'Chromium';
        elseif (strpos($user_agent, 'Iceweasel') !== FALSE)
            return 'Iceweasel';
        elseif (strpos($user_agent, 'Galeon') !== FALSE)
            return 'Galeon';
        elseif (strpos($user_agent, 'Edge') !== FALSE)
            return 'Microsoft Edge';
        elseif (strpos($user_agent, 'Trident') !== FALSE) //IE 11
            return 'Internet Explorer';
        elseif (strpos($user_agent, 'MSIE') !== FALSE)
            return 'Internet Explorer';
        elseif (strpos($user_agent, 'Opera Mini') !== FALSE)
            return "Opera Mini";
        elseif (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
            return "Opera";
        elseif (strpos($user_agent, 'Firefox') !== FALSE)
            return 'Mozilla Firefox';
        elseif (strpos($user_agent, 'Chrome') !== FALSE)
            return 'Google Chrome';
        elseif (strpos($user_agent, 'Safari') !== FALSE)
            return "Safari";
        elseif (strpos($user_agent, 'iTunes') !== FALSE)
            return 'iTunes';
        elseif (strpos($user_agent, 'Konqueror') !== FALSE)
            return 'Konqueror';
        elseif (strpos($user_agent, 'Dillo') !== FALSE)
            return 'Dillo';
        elseif (strpos($user_agent, 'Netscape') !== FALSE)
            return 'Netscape';
        elseif (strpos($user_agent, 'Midori') !== FALSE)
            return 'Midori';
        elseif (strpos($user_agent, 'ELinks') !== FALSE)
            return 'ELinks';
        elseif (strpos($user_agent, 'Links') !== FALSE)
            return 'Links';
        elseif (strpos($user_agent, 'Lynx') !== FALSE)
            return 'Lynx';
        elseif (strpos($user_agent, 'w3m') !== FALSE)
            return 'w3m';
        else
            return 'No hemos podido detectar su navegador';
    }
	
    /**
     * optener sistema operativo
     *
     * @param string $user_agent
     * @return string
     */
	private static function getPlatform ($user_agent)
    {
        if (strpos($user_agent, 'Windows NT 10.0') !== FALSE)
            return "Windows 10";
        elseif (strpos($user_agent, 'Windows NT 6.3') !== FALSE)
            return "Windows 8.1";
        elseif (strpos($user_agent, 'Windows NT 6.2') !== FALSE)
            return "Windows 8";
        elseif (strpos($user_agent, 'Windows NT 6.1') !== FALSE)
            return "Windows 7";
        elseif (strpos($user_agent, 'Windows NT 6.0') !== FALSE)
            return "Windows Vista";
        elseif (strpos($user_agent, 'Windows NT 5.1') !== FALSE)
            return "Windows XP";
        elseif (strpos($user_agent, 'Windows NT 5.2') !== FALSE)
            return 'Windows 2003';
        elseif (strpos($user_agent, 'Windows NT 5.0') !== FALSE)
            return 'Windows 2000';
        elseif (strpos($user_agent, 'Windows ME') !== FALSE)
            return 'Windows ME';
        elseif (strpos($user_agent, 'Win98') !== FALSE)
            return 'Windows 98';
        elseif (strpos($user_agent, 'Win95') !== FALSE)
            return 'Windows 95';
        elseif (strpos($user_agent, 'WinNT4.0') !== FALSE)
            return 'Windows NT 4.0';
        elseif (strpos($user_agent, 'Windows Phone') !== FALSE)
            return 'Windows Phone';
        elseif (strpos($user_agent, 'Windows') !== FALSE)
            return 'Windows';
        elseif (strpos($user_agent, 'iPhone') !== FALSE)
            return 'iPhone';
        elseif (strpos($user_agent, 'iPad') !== FALSE)
            return 'iPad';
        elseif (strpos($user_agent, 'Debian') !== FALSE)
            return 'Debian';
        elseif (strpos($user_agent, 'Ubuntu') !== FALSE)
            return 'Ubuntu';
        elseif (strpos($user_agent, 'Slackware') !== FALSE)
            return 'Slackware';
        elseif (strpos($user_agent, 'Linux Mint') !== FALSE)
            return 'Linux Mint';
        elseif (strpos($user_agent, 'Gentoo') !== FALSE)
            return 'Gentoo';
        elseif (strpos($user_agent, 'Elementary OS') !== FALSE)
            return 'ELementary OS';
        elseif (strpos($user_agent, 'Fedora') !== FALSE)
            return 'Fedora';
        elseif (strpos($user_agent, 'Kubuntu') !== FALSE)
            return 'Kubuntu';
        elseif (strpos($user_agent, 'Android 7.1') !== FALSE)
            return 'Android 7.1  Nougat';
        elseif (strpos($user_agent, 'Android 7.0') !== FALSE)
            return 'Android 7.0  Nougat';
        elseif (strpos($user_agent, 'Android 6.0') !== FALSE)
            return 'Android 6.0 Mashmallow';
        elseif (strpos($user_agent, 'Android 5.1') !== FALSE)
            return 'Android 5.1 Lollipop';
        elseif (strpos($user_agent, 'Android 5.0') !== FALSE)
            return 'Android 5.0 Lollipop';
        elseif (strpos($user_agent, 'Android 4.4') !== FALSE)
            return 'Android 4.4 KitKat';
        elseif (strpos($user_agent, 'Android 4.3') !== FALSE)
            return 'Android 4.3 Jelly Bean';
        elseif (strpos($user_agent, 'Android 4.2') !== FALSE)
            return 'Android 4.2 Jelly Bean';
        elseif (strpos($user_agent, 'Android 4.1') !== FALSE)
            return 'Android 4.1 Jelly Bean';
        elseif (strpos($user_agent, 'Android 4.0') !== FALSE)
            return 'Android 4.0 Ice Cream Sandwich';
        elseif (strpos($user_agent, 'Android 3.2') !== FALSE)
            return 'Android 3.2 Honeycomb';
        elseif (strpos($user_agent, 'Android 3.1') !== FALSE)
            return 'Android 3.1 Honeycomb';
        elseif (strpos($user_agent, 'Android 3.0') !== FALSE)
            return 'Android 3.0 Honeycomb';
        elseif (strpos($user_agent, 'Android') !== FALSE)
            return 'Android';
        elseif (strpos($user_agent, 'FreeBSD') !== FALSE)
            return 'FreeBSD';
        elseif (strpos($user_agent, 'OpenBSD') !== FALSE)
            return 'OpenBSD';
        elseif (strpos($user_agent, 'NetBSD') !== FALSE)
            return 'NetBSD';
        elseif (strpos($user_agent, 'SunOS') !== FALSE)
            return 'Solaris';
        elseif (strpos($user_agent, 'BlackBerry') !== FALSE)
            return 'BlackBerry';
        elseif (strpos($user_agent, 'Mobile') !== FALSE)
            return 'Firefox OS';
        elseif (strpos($user_agent, 'Linux') !== FALSE)
            return 'Linux';
        elseif (strpos($user_agent, 'Mac OS X+') || strpos($user_agent, 'CFNetwork+') !== FALSE)
            return 'Mac OS X';
        elseif (strpos($user_agent, 'Macintosh') !== FALSE)
            return 'Mac OS Classic';
        elseif (strpos($user_agent, 'OS/2') !== FALSE)
            return 'OS/2';
        elseif (strpos($user_agent, 'BeOS') !== FALSE)
            return 'BeOS';
        elseif (strpos($user_agent, 'Nintendo') !== FALSE)
            return 'Nintendo';
        else
            return 'Unknown Platform';
    }


    /**
     * Undocumented function
     *
     * @return string
     */
	public static function locateIp ()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ip         = self::getIP();        
        $os         = self::getPlatform($user_agent);
        $navigator  = self::getBrowser($user_agent);
        $device     = self::device();
        
            // Optener Ubicacion geografica del visitante
        $geodata = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip) );
        
        $data = (object) array (
            'ip'				=>	$ip,
            'city'			    =>	$geodata['geoplugin_city'], 			
            'region'			=>	$geodata['geoplugin_region'] ,			
            'country'			=>	$geodata['geoplugin_countryName'],				
            'countryCode'		=>	$geodata['geoplugin_countryCode'],			
            'continentCode'	    =>	$geodata['geoplugin_continentCode'], 
            'latitud'			=>	$geodata['geoplugin_latitude'] ,			
            'longitude'			=>	$geodata['geoplugin_longitude'],			
            'currencyCode'		=>	$geodata['geoplugin_currencyCode'],
            'currencySymbol'	=>	$geodata['geoplugin_currencySymbol'], 
            'device'	        =>	$device,
            'os'	            =>  $os,
            'navigator'     	=>	$navigator                
        );
                        
        return	$data;
	}

}

?>
