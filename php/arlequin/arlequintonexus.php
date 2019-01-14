<?php 
	$file_name		=$_POST['file_name'];
	$input_format	=$_POST['input_format'];
	$output_format	=$_POST['output_format'];
	$dataType		=$_POST['dataType'];
	$data_read		='read';
	include '../app.php';
	$app=new app();
	include 'arlequin_parser.php';
	$arlequin=new arlequin_parser();
	$dizi=$arlequin->parser($file_name,$data_read,$dataType);

?>
#NEXUS
BEGIN TAXA;
<?="\t"?>DIMENSIONS NTAX=<?=sizeOf($dizi['Data'])?>;
<?="\t"?>TAXLABELS
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php #Eğer Birey tekrar sayısı 1 den büyükse tekrarlanacak start ?>
<?php if($v['repetition']>1):?>
<?php for($m=1;$m<=$v['repetition'];$m++): ?>
<?php if($m==1):?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'],$dizi['header']['maxIndividualNameLength']);?><?= "\r\n" ?>
<?php else: //m!==1?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'].'_'.$m,$dizi['header']['maxIndividualNameLength']);?><?= "\r\n" ?>
<?php endif;//m==1?>
<?php endfor;?>
<?php else: //if repetition>1 değilse?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'],$dizi['header']['maxIndividualNameLength']);?><?= "\r\n" ?>
<?php endif; ?>
<?php endforeach;?>
<?php endforeach;?>
<?="\t"?><?="\t"?>;
END;
BEGIN CHARACTERS;
<?="\t"?>DIMENSIONS NCHAR=;
<?="\t"?>FORMAT  separator=/
<?="\t"?><?="\t"?>DATATYPE=<?=$app->label($dataType)?><?= "\r\n" ?>
<?="\t"?><?="\t"?>MISSING=?;
<?="\t"?><?="\t"?>GAP=-;
<?="\t"?>MATRIX
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php #Eğer Birey tekrar sayısı 1 den büyükse tekrarlanacak start ?>
<?php if($dizi['header']['GenotypicData']==0): //GenotypicData sı 0 ise?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'],$dizi['header']['maxIndividualNameLength']);?><?="\t"?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$v['data']['dataString1'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data1;?><?= "\r\n" ?>
<?php else: //SNP değilse?>
<?= $data1;?><?= "\r\n" ?>
<?php endif; //SNP bitiş?>
<?php else: //GenotypicData sı 1 ise?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'],$dizi['header']['maxIndividualNameLength']);?><?="\t"?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$v['data']['dataString1'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data1;?><?= "\r\n" ?>
<?php else: //SNP değilse?>
<?= $data1;?><?= "\r\n" ?>
<?php endif; //SNP bitiş?>
<?="\t"?><?="\t"?><?= $app->nexus_format_individual_name($v['individual'],$dizi['header']['maxIndividualNameLength']);?><?="\t"?>
<?php $data2="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data2.=$v['data']['dataString2'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data2;?><?= "\r\n" ?>
<?php else: //SNP değilse?>
<?= $data2;?><?= "\r\n" ?>
<?php endif; //SNP bitiş?>
<?php endif; //GenotypicData bitiş?>
<?= "\r\n" ?>
<?php endforeach; ?>
<?php endforeach; ?>
END;