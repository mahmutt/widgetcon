<?php
$item=urlencode($_GET["file"]); 
$item=str_replace("%2F","",$item); 
$item=str_replace("%5C","",$item); 
if(is_file($item)){
 header("Content-Disposition: attachment; filename=$item");

 readfile($item); 

}else{
 echo urldecode($item)." Bu Dosya Bulunamadi!"; 
}
?>