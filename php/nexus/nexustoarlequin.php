<?php 
	$file_name				=$_POST['file_name'];
	$dataType				=$_POST['dataType'];
	$specify_format_of_data	=$_POST['specify_format_of_data'];//nexus formatında sekans ya da interleaved format
	include '../app.php';
	$app=new app();
	include 'nexus_parser.php';
	$nexus=new nexus_parser();
	$dizi=$nexus->parser($file_name,$dataType,$specify_format_of_data);
?>
[Profile]
  Title = "<?= $dizi['header']['Title']?>"<?= "\r\n" ?>
  NbSamples = 1<?= "\r\n" ?>
  DataType = <?= $app->label($dizi['header']['DataType']) ?><?= "\r\n" ?>
  GenotypicData = 0<?= "\r\n" ?>
  LocusSeparator = NONE<?= "\r\n" ?>
  MissingData = "<?=$dizi['header']['missingData']?>"<?= "\r\n" ?>
  GameticPhase = 0<?= "\r\n" ?>
  RecessiveData = 0<?= "\r\n" ?>


[Data]
  [[Samples]]
    SampleName = "pop_1"<?= "\r\n" ?>
    SampleSize = <?= count($dizi['Data'])."\r\n" ?>
    SampleData = {<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
	<?= $app->distance($value['SeqName'],$dizi['header']['maxSeqNameLength'])."\t".(1)."\t"?><?= $value['SeqData']['dataString1'] ?><?= "\r\n" ?>
<?php endforeach; ?>
    }
