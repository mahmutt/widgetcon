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
<?php for($i=0;$i<$dizi['header']['maxSeqLength']; $i++): //lokus isimleri oluşturacak?>
Locus_<?= ($i+1); //lokus isimleri arasında 2 tab boşluk olacak?><?="\t"?><?= "\t" ?>
<?php endfor; //lokus isimlerini alt alta yazacak?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($dataType=='snp'):?>
<?php if($ploidy_of_the_data=='haploid'): //haploid ise?>
<?= $value['SeqName'];?><?="\t"?>1<?="\t"?><?= implode(' ',explode(',',$app->structure_format_convert_snp($value['SeqData']['dataString'])));?><?= "\r\n" ?>
<?php else: //haploid değilse?>
<?= $value['SeqName'];?><?="\t"?>1<?="\t"?><?= implode(' ',explode(',',$app->structure_format_convert_snp($value['SeqData']['dataString1'])));?><?= "\r\n"?>
<?= $value['SeqName'];?><?="\t"?>1<?="\t"?><?= implode(' ',explode(',',$app->structure_format_convert_snp($value['SeqData']['dataString2'])));?><?= "\r\n"?>
<?php endif; //ploidy endif?>
<?php else: //SNP değilse?>
<?='ONLY SNP DATA'?>
<?php endif;?>
<?php endforeach; ?>




  


