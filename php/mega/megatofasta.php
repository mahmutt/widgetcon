<?php 
	$file_name						=$_POST['file_name'];
	$dataType						=$_POST['dataType'];
	$specify_format_of_data			=$_POST['specify_format_of_data'];//mega formatında sekans ya da interleaved format
	$save_sequence_on_single_line	=$_POST['save_sequence_on_single_line'];
	include '../app.php';
	$app=new app();
	include 'mega_parser.php';
	$mega=new mega_parser();
	$dizi=$mega->parser($file_name,$dataType,$specify_format_of_data);
?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= ">".$value['SeqName'];?>
<?= "\r\n" ?>
<?php if($save_sequence_on_single_line=="yes"):?>
<?= preg_replace('/[\?\s]/', 'N', $value['SeqData']['dataString1']);?>
<?= "\r\n" ?>
<?php else:?>
<?= wordwrap(preg_replace('/[\?\s]/', 'N', $value['SeqData']['dataString1']),71, "\r\n",true)?>
<?= "\r\n" ?>
<?php endif;?>
<?php endforeach;?>