<?php
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	include '../app.php';
	$app=new app();
	include 'nexus_parser.php';
	$nexus=new nexus_parser();
	$dizi=$nexus->parser($file_name,$dataType,$ploidy_of_the_data);
?>
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
