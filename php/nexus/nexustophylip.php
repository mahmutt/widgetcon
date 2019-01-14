<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	$kind_of_file			=$_POST['kind_of_file'];
	$relaxed_format			=$_POST['relaxed_format'];
	include '../app.php';
	$app=new app();
	include 'nexus_parser.php';
	$nexus=new nexus_parser();
	$dizi=$nexus->parser($file_name,$dataType,$ploidy_of_the_data);
?>
<?=str_repeat(" ", 3)?><?=sizeOf($dizi['Data'])?><?=str_repeat(" ", 3)?><?=strlen($dizi['Data'][0]['SeqData']['dataString1'])?><?="\r\n"?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($relaxed_format=="no"):?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?= wordwrap(wordwrap($value['SeqData']['dataString1'],10," ",true),50, "\r\n".str_repeat(" ", 10),true)?>
<?php else:?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?=$value['SeqData']['dataString1']?>
<?php endif;?>
<?= "\r\n" ?>
<?php endforeach;?>
