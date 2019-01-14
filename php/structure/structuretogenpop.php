<?php 
	$input_format						=$_POST['input_format'];
	$output_format						=$_POST['output_format'];
	$file_name							=$_POST['file_name'];
	$dataType							=$_POST['dataType'];
	$ploidy_of_the_data					=$_POST['ploidy_of_the_data'];
	$missing_data_value_code			=$_POST['missing_data_value_code'];
	$marker_names_included				=$_POST['marker_names_included'];
	$individual_name_included			=$_POST['individual_name_included'];
	$how_microsat_coded					=$_POST['how_microsat_coded'];
	$repeatSize							=$_POST['repeatSize'];
	$number_of_markers_in_the_input_file=$_POST['number_of_markers_in_the_input_file'];
	$popdata_present					=$_POST['popdata_present'];
	
	include '../app.php';
	$app=new app();
	include 'structure_parser.php';
	$structure=new structure_parser();
	$dizi=$structure->parser(
		$file_name,
		$dataType,
		$ploidy_of_the_data,
		$missing_data_value_code,
		$marker_names_included,
		$individual_name_included,
		$how_microsat_coded,
		$repeatSize,
		$number_of_markers_in_the_input_file,
		$popdata_present
	);
?>
<?php $letters_array1=[];?>
<?php if(count($dizi['header']['errors'])>0)://Eğer Hata varsa çeviri yapmayacak hata basacak?>
<?php foreach($dizi['header']['errors'] as $e=>$error):?>
<?="#"?><?=$error;?><?= "\r\n" ?>
<?php endforeach;?>
<?php else:?>
<?= "Title line:"?><?='"'?>Structure to Genpop via widgetcon<?='"'?><?= "\r\n" ?>
<?php foreach($dizi['header']['LociList'] as $key=>$value): //lokus isimlerini çevirecek?>
<?= $value;?><?= "\r\n" ?>
<?php endforeach; //lokus isimlerini alt alta yazacak?>
<?php foreach ($dizi['header']['PopNameList'] as $key=>$value): ?>
<?= 'POP '.$value; ?><?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $k=>$v): ?>
<?php if($value==$v['PopName']):?>
<?= $app->genpop_format_individual_name($v['IndividualName'],$dizi['header']['max_individual_name_length']);?>
<?php foreach($v['PopData']['dataArray1'] as $d=>$da):?>
<?php if($ploidy_of_the_data!=="haploid"): //haploid değilse?>
<?php 
$data1=$v['PopData']['dataArray1'][$d]; 
$data2=$v['PopData']['dataArray2'][$d];
?>
<?=$app->genpop_format_convert_value($data1,$missing_data_value_code,$how_microsat_coded,$repeatSize,$d);?><?=$app->genpop_format_convert_value($data2,$missing_data_value_code,$how_microsat_coded,$repeatSize,$d);?><?=str_repeat(" ", 1)?>
<?php else: //haploid ise?>
<?php
$data1=$v['PopData']['dataArray1'][$d]; 
if($dataType=='snp'){//data type snp ise
	if(!is_numeric($data1)){
		$data1=$app->snp_convert_letter_to_numeric($data1);
	}
}else{
	if(!is_numeric($data1)){
		if($data1=="?"){
			$data1=$missing_data_value_code;
		}else{
			if(!in_array($data1,$letters_array1)){
				array_push($letters_array1,$data1);
			}
			$data1=array_search($data1,$letters_array1)+1;
		}
	}
}
?>
<?=$app->genpop_format_convert_value($data1,$missing_data_value_code,$how_microsat_coded,$repeatSize,$d);?><?=str_repeat(" ", 1)?>
<?php endif; ?>
<?php endforeach; //da?>
<?= "\r\n" ?>
<?php endif; ?>
<?php endforeach; //v?>
<?php endforeach; //value?>
<?php endif; //errors?>

