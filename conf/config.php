<?php
class Config{
    private static $instance;
    private $config;
    protected static $errorReference = [
        0 => 'JSON_ERROR_NONE',
        1 => 'JSON_ERROR_DEPTH',
        2 => 'JSON_ERROR_STATE_MISMATCH',
        3 => 'JSON_ERROR_CTRL_CHAR',
        4 => 'JSON_ERROR_SYNTAX',
        5 => 'JSON_ERROR_UTF8',
    ];

    private function __construct($file) {
        $configFile = fopen($file, "r") or die("Unable to open file!");
        $conf[] = fread($configFile, filesize($file));
        foreach ($conf as $string) {
            $result = json_decode($string, $assoc = false);

            try {
                if ($result) {
                    $this->config=$result;
                } else {
                    throw new  Exception("Nie prawidłowy plik JSON: ".self::$errorReference[json_last_error()]." powód: ".json_last_error_msg()."<br/>");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    private function __clone() {}

    public function getInstance($file) {
        if(self::$instance === null) {
            self::$instance = new Config($file);
        }
        return self::$instance;
    }
    public function getConfig(){
        return $this->config;
    }

}
$config = Config::getInstance(dirname(__FILE__).'/config.json');

?>