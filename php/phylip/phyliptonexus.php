<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	$what_type_of_data		=$_POST['what_type_of_data'];//molecular or distance
	include '../app.php';
	$app=new app();
	include 'phylip_parser.php';
	$phylip=new phylip_parser();
	$dizi=$phylip->parser($file_name,$dataType,$ploidy_of_the_data,$what_type_of_data);
?>
<?='#NEXUS'?>
<?= "\r\n" ?>
<?='BEGIN DATA;'?>
<?= "\r\n" ?>
<?="\t"?><?="Dimensions"?><?="\t"?><?="\t"?><?="NTax="?><?=sizeOf($dizi['Data'])?><?="\t"?><?="NChar="?><?=strlen($dizi['Data'][0]['SeqData']['dataString1'])?>
<?= "\r\n" ?>
<?="\t"?><?="Format DataType="?><?=$app->label($dataType)?><?="\t"?><?="Interleave="?><?="no"?><?="\t"?><?="Gap="?><?=$dizi['header']['gap']?><?="\t"?><?="Missing="?><?=$dizi['header']['missingData']?>
<?= "\r\n" ?>
<?="\t"?><?="Matrix"?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= $app->nexus_format_individual_name($value['SeqName'],$dizi['header']['maxSeqNameLength']);?><?="\t"?><?= $value['SeqData']['dataString1'];?>
<?= "\r\n" ?>
<?php endforeach;?>
<?= ";" ?>
<?= "\r\n" ?>
<?= "End;" ?>