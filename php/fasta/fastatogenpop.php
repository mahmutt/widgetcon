<?php 
	$input_format	=$_POST['input_format'];
	$output_format	=$_POST['output_format'];
	$file_name		=$_POST['file_name'];
	$dataType		=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	include '../app.php';
	$app=new app();
	include 'fasta_parser.php';
	$fasta=new fasta_parser();
	$dizi=$fasta->parser($file_name,$dataType,$ploidy_of_the_data);
?>
<?= "Title line:"?><?='"'?>Fasta to Genpop via widgetcon<?='"'?><?= "\r\n" ?>
<?php for($i=0;$i<$dizi['header']['maxSeqLength']; $i++): //lokus isimleri oluşturacak?>
Locus_<?= ($i+1);?><?= "\r\n" ?>
<?php endfor; //lokus isimlerini alt alta yazacak?>
<?= 'POP_1'; ?><?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($dataType=='snp'):?>
<?php if($ploidy_of_the_data=='haploid'): //haploid ise?>
<?= $value['SeqName'];?>,<?="\t"?><?= implode(' ',explode(',',$app->genpop_format_convert_snp($value['SeqData']['dataString'])));?><?= "\r\n" ?>
<?php else: //diploid ise?>
<?php $data_string_array=explode(',',$value['SeqData']['dataString']);//string değeri harflerine bölecek?>
<?php $data_string1_array=explode(',',$value['SeqData']['dataString1']);//string1 değeri harflerine bölecek?>
<?php $data_string2_array=explode(',',$value['SeqData']['dataString2']);//string2 değeri harflerine bölecek?>
<?= $value['SeqName'];?>,<?="\t"?>
<?php foreach($data_string_array as $d=> $la):?>
<?= $app->snp_convert_letter_to_numeric($data_string1_array[$d]).$app->snp_convert_letter_to_numeric($data_string2_array[$d]);?><?=str_repeat(" ", 1);?>
<?php endforeach;?><?= "\r\n" ?>
<?php endif; //endif haploid?>
<?php else:?>
<?='ONLY SNP DATA'?>
<?php endif;?>
<?php endforeach; ?>

