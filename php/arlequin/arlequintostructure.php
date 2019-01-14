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
<?php for($i=1;$i<=$dizi['header']['LocusSize'];$i++): ?>
<?= 'Locus_'.$i."\t"."\t";?>
<?php endfor; ?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php if($dizi['header']['GenotypicData']==0): //GenotypicData sı 0 ise?>
<?= $v['individual']."\t".($key+1)."\t" ?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?= $v['data']['dataString1'][$i].' '?>
<?php endfor; ?>
<?php else: //GenotypicData sı 1 ise?>
<?= $v['individual']."\t".($key+1)."\t" ?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?= $v['data']['dataString1'][$i].' '?>
<?php endfor; ?>
<?= "\r\n" ?>
<?= $v['individual']."\t".($key+1)."\t" ?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?= $v['data']['dataString2'][$i].' '?>
<?php endfor; ?>
<?php endif; //GenotypicData bitiş?>
<?= "\r\n" ?>
<?php endforeach; ?>
<?php endforeach; ?>



  


