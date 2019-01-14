<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	$kind_of_file			=$_POST['kind_of_file'];
	$relaxed_format			=$_POST['relaxed_format'];
	include '../app.php';
	$app=new app();
	include 'fasta_parser.php';
	$fasta=new fasta_parser();
	$dizi=$fasta->parser($file_name,$dataType,$ploidy_of_the_data);
?>
<?=str_repeat(" ", 3)?><?=sizeOf($dizi['Data'])?><?=str_repeat(" ", 3)?><?=strlen($dizi['Data'][0]['SeqData']['dataString']);?><?=str_repeat(" ", 3)?>s
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($dataType=='snp'):?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?=implode('',explode(',',$value['SeqData']['dataString']))?>
<?php else: //else SNP?>
<?= $app->phylip_format_individual_name($value['SeqName'],$relaxed_format);?><?=$value['SeqData']['dataString']?>
<?php endif;//if SNP end?>
<?= "\r\n" ?>
<?php endforeach;?>

