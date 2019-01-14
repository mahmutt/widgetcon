<?php 
	$input_format						=$_POST['input_format'];
	$output_format						=$_POST['output_format'];
	$file_name							=$_POST['file_name'];
	$how_microsat_coded					=$_POST['how_microsat_coded'];
	$repeatSize							=$_POST['repeatSize'];
	include '../app.php';
	$app=new app();
	include 'genpop_parser.php';
	$genpop=new genpop_parser();
	$dizi=$genpop->parser(
		$file_name,
		$dataType,
		$how_microsat_coded,
		$repeatSize
	);
?>
<?php if(count($dizi['header']['errors'])>0)://Eğer Hata varsa çeviri yapmayacak hata basacak?>
<?php foreach($dizi['header']['errors'] as $e=>$error):?>
<?="#"?><?=$error;?><?= "\r\n" ?>
<?php endforeach;?>
<?php else: //errors?>
<?= "\t" ?>
<?php foreach($dizi['header']['LociList'] as $lociName): //lokus isimleri başlangıç?>
<?= $app->structure_format_loci_name($lociName);//lokus isimleri arasında 2 tab boşluk olacak?><?= "\t" ?><?= "\t" ?>
<?php endforeach; //lokus isimleri bitiş?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): //birey isimlerini çevir-start?>
<?=$app->structure_format_convert_value(json_encode($value['PopData']['dataArray']),$dizi['header']['ploidy'],$value['IndividualName'],$value['PopNumber'],$how_microsat_coded,$repeatSize)?>
<?php endforeach; //birey isimlerini çevir-end?>
<?php endif; //errors?>