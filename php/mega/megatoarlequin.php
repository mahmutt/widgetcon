<?php 
	$file_name						=$_POST['file_name'];
	$dataType						=$_POST['dataType'];
	$specify_format_of_data			=$_POST['specify_format_of_data'];//mega formatında sekans ya da interleaved format
	$save_sequence_on_single_line	=$_POST['save_sequence_on_single_line'];
	include '../app.php';
	$app=new app();
	include 'mega_parser.php';
	$mega=new mega_parser();
	$dizi=$mega->parser($file_name,$dataType,$specify_format_of_data);
?>
[Profile]
  Title = "<?= $dizi['header']['Title']?>"<?= "\r\n" ?>
  NbSamples = 1<?= "\r\n" ?>
  DataType = <?= $app->label($dizi['header']['DataType']) ?><?= "\r\n" ?>
  GenotypicData = <?=$ploidy_of_the_data=='diploid'?'1':'0';?><?= "\r\n" ?>
<?php if(in_array($dataType,['dna','rna','protein'])):?>
  LocusSeparator = NONE<?= "\r\n" ?>
<?php else:?>
  LocusSeparator = WHITESPACE<?= "\r\n" ?>
<?php endif;?>
  MissingData = "?"<?= "\r\n" ?>
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