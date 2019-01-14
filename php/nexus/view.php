<?php
$file=$_SERVER['DOCUMENT_ROOT'].'/converter/uploads/'."AtoS9vJ0NLdEGHX.meg";
$linecount = 0;
$handle = fopen($file, "r");
while(!feof($handle)){
  $line = fgets($handle);
  $linecount++;
}

fclose($handle);

echo $linecount;