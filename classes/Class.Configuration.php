<?php
/* SMPL Configuration Class
// 
//
//*/


class Configuration
{
    private static $database = array(
        'type' => 'MySql',
        'host' => 'localhost',
        'name' => 'smpl',
        'username' => 'root',
        'password' => 'root',
        'prefix' => ''
        );
        
    private static $modRewrite = false;
    private static $sslCertificate = false;


    public static function Site($domainOnly = false)                         // [MUSTCHANGE]
    {

        $host = (Configuration::SslCertificate()) ? 'https://': 'http://';
        $host .= $_SERVER['HTTP_HOST'];
        $directory = dirname($_SERVER['SCRIPT_NAME']);
        $website = ($directory == '/') ? $host.'/': $host.$directory.'/';
        
        if ($domainOnly)
            return $host.'/';
        else
            return $website;
    }
    
    // Return database configuration information
    public static function Database($item = null)
    {
        if (null === $item)
            return self::$database;
        else
            return self::$database[$item];
    }
    
    // Return data from the settings DB table
    public static function Get($settingName)
    {
        $database = Database::Connect();
        $result = $database->Retrieve()
            ->UsingTable("settings")
            ->Item("value-field")
            ->Match("name-hidden", $settingName)
            ->Execute();
        
        $value = $result->Fetch();
        if(is_null($value))
            throw new WarningException("Could not find setting '{$value}'");
        return $value['value-field'];
    }
    
    public static function ModRewrite()
    {
        return self::$modRewrite;
    }
    
    
    public static function SslCertificate()
    {
        return self::$sslCertificate;
    }
      
}

?>