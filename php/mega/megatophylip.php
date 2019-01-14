<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$specify_format_of_data	=$_POST['specify_format_of_data'];
	$kind_of_file			=$_POST['kind_of_file'];
	$relaxed_format			=$_POST['relaxed_format'];
	include '../app.php';
	$app=new app();
	include 'mega_parser.php';
	$mega=new mega_parser();
	$dizi=$mega->parser($file_name,$dataType,$specify_format_of_data);
?>
<?php if($dataType=='distance'): //veri tipi distance ise?>
<?=str_repeat(" ", 3)?><?=sizeOf($dizi['Data'])?><?="\r\n"?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?=$value['SeqData']['dataString1']?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php else: //veri tipi distance değilse?>
<?=str_repeat(" ", 3)?><?=sizeOf($dizi['Data'])?><?=str_repeat(" ", 3)?><?=strlen($dizi['Data'][0]['SeqData']['dataString1'])?><?="\r\n"?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?=$value['SeqData']['dataString1']?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php endif;?>

