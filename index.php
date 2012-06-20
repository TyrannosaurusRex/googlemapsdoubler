<?php
include_once("config.php");
//array_implode taken from php.net/implode
function array_implode( $glue, $separator, $array ) {
    if ( ! is_array( $array ) ) return $array;
    $string = array();
    foreach ( $array as $key => $val ) {
        if ( is_array( $val ) )
            $val = implode( ',', $val );
        $string[] = "{$key}{$glue}{$val}";
        
    }
    return implode( $separator, $string );
    
}
$db = new PDO("mysql:dbname=$dbname;host=$host",$dbusername,$password);
if($_GET["save"]){
 
//ini_set('display_errors', true);

$query = $db->prepare("
   insert into maplocations
   (latlng1, latlng2, zoom1, zoom2, name)
   values(?,?,?,?,?)
");
$query->execute(array(
  $_REQUEST["latlng1"],
  $_REQUEST["latlng2"],
  $_REQUEST["zoom1"],
  $_REQUEST["zoom2"],
  $_REQUEST["name"])
);
unset($_GET["save"]);
$url = array_implode("=","&",$_GET);
header("Location:?$url");
exit;
} else if($_GET["random"]){
  $query = $db->query("
    select * from maplocations order by rand() limit 1
    ");
  $record = $query->fetch(PDO::FETCH_ASSOC);
  $url = array_implode("=","&",$record);
  header("Location:?$url");
  exit;
}
include("googlemapsdoubler.html");
?>
