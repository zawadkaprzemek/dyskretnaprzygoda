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
$config = Config::getInstance('conf/config.json');

define("AVATAR_PATH",'lib/images/avatars');
$month_names=array('','styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');

function addDots($text, $limit) {

    if (strlen($text) > $limit) {
        return trim(mb_substr($text, 0, $limit,"utf-8")) . '...';
    } else {
        return $text;
    }
}
function sort_date($el1, $el2)
{
    return strcmp($el2['date'], $el1['date']);
}

function nice_data($item,$month_names){
    $date=explode(" ",$item);
    $h=explode(":",$date[1]);
    $hour=$h[0].":".$h[1];
    $today=date('Y-m-d');
    $a=explode("-",$date[0]);
    if($a[2][0]==0){
        $a[2]=$a[2][1];
    }
    if($a[1][0]==0){
        $a[1]=$a[1][1];
    }
    if($date[0]==$today){
        return $hour;
    }else{
        $res = round((strtotime($today) - strtotime($date[0])) / 86400);
        if($res==1){
             return "wczoraj ".$hour;
        }else{
            if($a[0]==date('Y')){
                 return $a[2].' '.$month_names[$a[1]];
            }else{
                 return $a[2].' '.$month_names[$a[1]].' '.$a[0];
            }
        }

    }
}

?>