<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$ploidy_of_the_data		=$_POST['ploidy_of_the_data'];
	include '../app.php';
	$app=new app();
	include 'fasta_parser.php';
	$fasta=new fasta_parser();
	$dizi=$fasta->parser($file_name,$dataType,$ploidy_of_the_data);
?>
#NEXUS
BEGIN TAXA;
<?="\t"?>DIMENSIONS NTAX=<?=sizeOf($dizi['Data'])?>;
<?="\t"?>TAXLABELS
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($value['SeqName'],$dizi['header']['maxSeqNameLength']);?><?= "\r\n" ?>
<?php endforeach;?>
<?="\t"?><?="\t"?>;
END;
BEGIN CHARACTERS;
<?="\t"?>DIMENSIONS NCHAR=<?=strlen($dizi['Data'][0]['SeqData']['dataString'])?>;
<?="\t"?>FORMAT  separator=/
<?="\t"?><?="\t"?>DATATYPE=<?=$app->label($dataType)?><?= "\r\n" ?>
<?="\t"?><?="\t"?>MISSING=<?=$dizi['header']['missingData']?>;
<?="\t"?><?="\t"?>GAP=<?=$dizi['header']['gap']?>;
<?="\t"?>MATRIX
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($dataType=='snp'):?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($value['SeqName'],$dizi['header']['maxSeqNameLength']);?><?="\t"?>
<?php if($ploidy_of_the_data=='haploid'): //haploid ise?>
<?=implode(' ',explode(',',$value['SeqData']['dataString']))?>
<?php else: //haploid değilse?>
<?php $data_string_array=explode(',',$value['SeqData']['dataString']);//string değeri harflerine bölecek?>
<?php foreach($data_string_array as $la):?>
<?= $app->getAmbiquityBase($la)[0].'/'.$app->getAmbiquityBase($la)[1];?><?=str_repeat(" ", 1);?>
<?php endforeach;?>
<?php endif; //ploidy endif?>
<?php else: //else SNP?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($value['SeqName'],$dizi['header']['maxSeqNameLength']);?><?="\t"?><?= $value['SeqData']['dataString'];?>
<?php endif;?>
<?= "\r\n" ?>
<?php endforeach;?>
<?="\t"?><?="\t"?>;
END;
