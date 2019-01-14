<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	$kind_of_data			=$_POST['kind_of_data'];//sequence_data or distance_matrix
	include '../app.php';
	$app=new app();
	include 'fasta_parser.php';
	$fasta=new fasta_parser();
	$dizi=$fasta->parser($file_name,$dataType,$ploidy_of_the_data);
?>
<?= "#Mega" ?>
<?= "\r\n" ?>
<?= "!Title"?><?="\t"?>Fasta to Mega via widgetcon<?=";"?>
<?= "\r\n" ?>
<?= "!Format"?><?="\t"?><?="DataType="?><?=$app->label($dataType)?><?="\t"?>Indel-<?="\t"?>Missing=?;
<?= "\r\n" ?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= "#".$app->mega_format_individual_name($value['SeqName']);?><?= "\r\n" ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= implode('',explode(',',$value['SeqData']['dataString']));?>
<?= "\r\n" ?>
<?php else: //SNP değilse?>
<?php $fark=$dizi['header']['maxSeqLength']-strlen($value['SeqData']['dataString'])?>
<?= wordwrap(($value['SeqData']['dataString'].str_repeat($dizi['header']['gap'], $fark)),60, "\r\n",true); //eksik olan nükleotid yerine - yazdık. MEGA programı böyle kabul ediyor?>
<?= "\r\n" ?>
<?= "\r\n" ?>
<?php endif;//endif dataType?>
<?php endforeach;?>