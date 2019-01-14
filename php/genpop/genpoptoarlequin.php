<?php 
	$file_name		=$_POST['file_name'];
	$input_format	=$_POST['input_format'];
	$output_format	=$_POST['output_format'];
	$dataType		=$_POST['dataType'];
	$dataStyle		=$_POST['dataStyle'];
	$repeatSize		=$_POST['repeatSize'];;
	include '../app.php';
	$app=new app();
	include 'genpop_parser.php';
	$genpop=new genpop_parser();
	$dizi=$genpop->parser($file_name,$dataType,$dataStyle,$repeatSize);
	function pop_size($dizi,$name){
		$size=0;
		foreach ($dizi['Data'] as $key=>$value){
			if($value['PopName']==$name){
				$size++;
			}
		}
		return $size;
	}
?>
[Profile]
  Title = "<?= $dizi['header']['Title']?>"<?= "\r\n" ?>
  NbSamples = <?=count($dizi['header']['PopNameList'])?><?= "\r\n" ?>
  DataType = <?=$app->label($dataType)?><?= "\r\n" ?>
  GenotypicData = <?= $dizi['header']['ploidy']?><?= "\r\n" ?>
<?php if(in_array($dataType,['dna','rna','protein'])):?>
  LocusSeparator = NONE<?= "\r\n" ?>
<?php else:?>
  LocusSeparator = WHITESPACE<?= "\r\n" ?>
<?php endif;?>
  MissingData = "?"<?= "\r\n" ?>
  GameticPhase = 0<?= "\r\n" ?>
  RecessiveData = 0<?= "\r\n" ?>


[Data]
<?php foreach ($dizi['header']['PopNameList'] as $pop=>$name): ?>
  [[Samples]]
    SampleName = "<?= trim($name) ?>"<?= "\r\n" ?>
    SampleSize = <?= pop_size($dizi,$name)."\r\n" ?>
    SampleData = {<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($name==$value['PopName']):?>
<?=$app->arlequin_format_convert_value(json_encode($value['PopData']['dataArray']),$dizi['header']['max_individual_name_length'],$dizi['header']['ploidy'],$value['IndividualName'],$value['PopNumber'],$how_microsat_coded,$repeatSize)?>
<?php endif; ?>
<?php endforeach; ?>
    }
<?php endforeach; ?>


