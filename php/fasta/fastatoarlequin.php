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
<?php if($dataType=='snp'):?>
<?php if($ploidy_of_the_data=='haploid'): //haploid ise?>
<?="\t"?><?= $app->distance($value['SeqName'],$dizi['header']['maxSeqNameLength'])."\t".(1)."\t"?><?= implode(' ',explode(',',$value['SeqData']['dataString']));?><?= "\r\n" ?>
<?php else: //diploid ise?>
<?="\t"?><?= $app->distance($value['SeqName'],$dizi['header']['maxSeqNameLength'])."\t".(1)."\t"?><?= implode(' ',explode(',',$value['SeqData']['dataString1']));?><?= "\r\n" ?><?=str_repeat("\t", 4)?><?= implode(' ',explode(',',$value['SeqData']['dataString2']));?><?= "\r\n" ?>
<?php endif; //endif haploid?>
<?php else: //else snp?>
<?="\t"?><?= $app->distance($value['SeqName'],$dizi['header']['maxSeqNameLength'])."\t".(1)."\t"?><?= $value['SeqData']['dataString'] ?><?= "\r\n" ?>
<?php endif; //endif snp?>
<?php endforeach; ?>
	}