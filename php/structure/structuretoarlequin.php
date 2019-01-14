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
  Title = "Structure to Arlequin via widgetcon"<?= "\r\n" ?>
  NbSamples = <?=count($dizi['header']['PopNameList'])?><?= "\r\n" ?>
  DataType = <?= $app->label($dizi['header']['DataType']) ?><?= "\r\n" ?>
  GenotypicData = <?=$ploidy_of_the_data=='haploid'?'0':'1';?><?= "\r\n" ?>
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
    SampleName = "pop_<?= trim($name) ?>"<?= "\r\n" ?>
    SampleSize = <?= pop_size($dizi,$name)."\r\n" ?>
    SampleData = {<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php if($name==$value['PopName']):?>
<?php if($ploidy_of_the_data!=="haploid"): ?>
	<?= $app->distance($value['IndividualName'],$dizi['header']['max_individual_name_length'])."\t".(1)."\t"?><?= preg_replace("/$missing_data_value_code/","?",implode(' ',$value['PopData']['dataArray1'])) ?><?= "\r\n" ?>
	<?="\t"?><?="\t"?><?= trim(preg_replace("/$missing_data_value_code/","?",implode(' ',$value['PopData']['dataArray2']))) ?><?= "\r\n" ?>
<?php else: ?>
<?php if($dataType=='snp'):?>
	<?= $app->distance($value['IndividualName'],$dizi['header']['max_individual_name_length'])."\t".(1)."\t"?><?= preg_replace("/$missing_data_value_code/","?",implode(' ',$value['PopData']['dataArray1'])) ?><?= "\r\n" ?>
<?php else:?>
	<?= $app->distance($value['IndividualName'],$dizi['header']['max_individual_name_length'])."\t".(1)."\t"?><?= preg_replace("/$missing_data_value_code/","?",implode(' ',$value['PopData']['dataArray1'])) ?><?= "\r\n" ?>
<?php endif;?>
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
    }
<?php endforeach; ?>