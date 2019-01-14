<?php 
	$file_name		=$_POST['file_name'];
	$input_format	=$_POST['input_format'];
	$output_format	=$_POST['output_format'];
	$dataType		=$_POST['dataType'];
	$data_read		='read';
	$relaxed_format =$_POST['relaxed_format'];
	include '../app.php';
	$app=new app();
	include 'arlequin_parser.php';
	$arlequin=new arlequin_parser();
	$dizi=$arlequin->parser($file_name,$data_read,$dataType);
	function ind_number($dizi){
		$number=0;
		foreach ($dizi['Data'] as $key=>$value){
			foreach ($value['SampleData'] as $k=>$v){
				$number++;
			}
		}
		return $number;
	}
?>
<?=str_repeat(" ", 3)?><?=ind_number($dizi)?><?=str_repeat(" ", 3)?><?=$dizi['header']['LocusSize']?><?="\r\n"?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?= $app->phylip_format_individual_name($v['individual'],$relaxed_format);?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$v['data']['dataString1'][$i];?>
<?php endfor; ?>
<?=$data1;?>
<?= "\r\n" ?>
<?php endforeach;?>
<?php endforeach;?>
