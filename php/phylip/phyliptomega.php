<?php 
	$file_name							=$_POST['file_name'];
	$dataType							=$_POST['dataType'];
	$ploidy_of_the_data					=$_POST['ploidy_of_the_data'];
	$what_type_of_data					=$_POST['what_type_of_data'];//molecular or distance
	$specify_format_distance_matrix		=$_POST['specify_format_distance_matrix'];//molecular or distance
	include '../app.php';
	$app=new app();
	include 'phylip_parser.php';
	$phylip=new phylip_parser();
	$dizi=$phylip->parser($file_name,$dataType,$ploidy_of_the_data,$what_type_of_data);
?>
<?php if(count($dizi['header']['errors'])>0)://Eğer Hata varsa çeviri yapmayacak hata basacak?>
<?php foreach($dizi['header']['errors'] as $e=>$error):?>
<?="#"?><?=$error;?><?= "\r\n" ?>
<?php endforeach;?>
<?php else: //errors?>
<?php if($dataType=='distance'): //veri tipi distance ise?>
<?= "#Mega" ?>
<?= "\r\n" ?>
<?= "!Title"?><?="\t"?><?=$dizi['header']['Title'];?><?=";"?>
<?= "\r\n" ?>
<?= "!Format"?><?="\t"?><?="DataType="?><?=$app->label($dataType)?><?="\t"?><?="DataFormat="?><?=$specify_format_distance_matrix?><?="\t"?><?="NTaxa="?><?=count($dizi['Data'])?><?="\t"?>
<?= "\r\n" ?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= "#".$app->mega_format_individual_name($value['SeqName']);?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php $arr=explode(" ",trim(preg_replace('/\s++/', ' ', $value['SeqData']['dataString1'])));?>
<?= implode(" ",array_slice($arr,0,$key));?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php else: //veri tipi distance değilse?>
<?= "#Mega" ?>
<?= "\r\n" ?>
<?= "!Title"?><?="\t"?><?=$dizi['header']['Title'];?><?=";"?>
<?= "\r\n" ?>
<?= "!Format"?><?="\t"?><?="DataType="?><?=$app->label($dataType)?><?="\t"?><?="Indel="?><?=$dizi['header']['gap']?><?="\t"?><?="Missing=".$dizi['header']['missingData']?><?=";"?>
<?= "\r\n" ?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= "#".$app->mega_format_individual_name($value['SeqName']);?>
<?= "\r\n" ?>
<?= wordwrap($value['SeqData']['dataString1'],60, "\r\n",true)?>
<?= "\r\n" ?>
<?php $fark=$dizi['header']['maxSeqLength']-strlen($value['SeqData']['dataString1'])?>
<?=str_repeat($dizi['header']['gap'], $fark)?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php endif;?>
<?php endif; //errors?>