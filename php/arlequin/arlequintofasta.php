<?php 
	$file_name						=$_POST['file_name'];
	$input_format					=$_POST['input_format'];
	$output_format					=$_POST['output_format'];
	$dataType						=$_POST['dataType'];
	$save_sequence_on_single_line	=$_POST['save_sequence_on_single_line'];
	$data_read		='read';
	include '../app.php';
	$app=new app();
	include 'arlequin_parser.php';
	$arlequin=new arlequin_parser();
	$dizi=$arlequin->parser($file_name,$data_read,$dataType);
?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php #Eğer Birey tekrar sayısı 1 den büyükse tekrarlanacak start ?>
<?php if($dizi['header']['GenotypicData']==0): //GenotypicData sı 0 ise?>
>ind_<?= $v['individual'];?> | population: <?=$dizi['Data'][$key]['SampleName']?><?= "\r\n" ?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$app->fasta_format_convert_missing_data($v['data']['dataString1'][$i]);?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?=implode(' ',str_split($data1));?>
<?php else: //SNP değilse?>
<?php if($save_sequence_on_single_line=="yes"):?>
<?= $data1;?>
<?= "\r\n" ?>
<?php else:?>
<?= wordwrap($data1,71, "\r\n",true)?>
<?= "\r\n" ?>
<?php endif;?>
<?php endif; //SNP bitiş?>
<?php else: //GenotypicData sı 1 ise?>
<?php $data1="";?>
>ind_<?= $v['individual'];?> | population: <?=$dizi['Data'][$key]['SampleName']?> | read:1<?= "\r\n" ?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$app->fasta_format_convert_missing_data($v['data']['dataString1'][$i]);?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?=implode(' ',str_split($data1));?>
<?php else: //SNP değilse?>
<?php if($save_sequence_on_single_line=="yes"):?>
<?= $data1;?>
<?= "\r\n" ?>
<?php else:?>
<?= wordwrap($data1,71, "\r\n",true)?>
<?= "\r\n" ?>
<?php endif;?>
<?php endif; //SNP bitiş?>
<?= "\r\n" ?>
>ind_<?= $v['individual'];?> | population: <?=$dizi['Data'][$key]['SampleName']?> | read:2<?= "\r\n" ?>
<?php $data2="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data2.=$app->fasta_format_convert_missing_data($v['data']['dataString2'][$i])?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?=implode(' ',str_split($data2));?>
<?php else: //SNP değilse?>
<?php if($save_sequence_on_single_line=="yes"):?>
<?= $data2;?>
<?= "\r\n" ?>
<?php else:?>
<?= wordwrap($data2,71, "\r\n",true)?>
<?= "\r\n" ?>
<?php endif;?>
<?php endif; //SNP bitiş?>
<?php endif; //GenotypicData bitiş?>
<?= "\r\n" ?>
<?php endforeach; ?>
<?php endforeach; ?>
