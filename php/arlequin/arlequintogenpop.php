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
<?=$dizi['header']['Title']?><?= "\r\n" ?>
<?php for($i=1;$i<=$dizi['header']['LocusSize'];$i++): ?>
<?= 'Locus_'.$i;?><?= "\r\n" ?>
<?php endfor; ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?= 'POP '.$value['SampleName']; ?><?= "\r\n" ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php #Eğer Birey tekrar sayısı 1 den büyükse tekrarlanacak start ?>
<?= $v['individual'].', ' ?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php if($dizi['header']['GenotypicData']==0): //GenotypicData sı 0 ise?>
<?= $app->genpop_format_convert_value($v['data']['dataString1'][$i],"?",0,0,0);?><?=str_repeat(" ", 1)?>
<?php else: //GenotypicData sı 1 ise?>
<?= $app->genpop_format_convert_value($v['data']['dataString1'][$i],"?",0,0,0);?><?= $app->genpop_format_convert_value($v['data']['dataString2'][$i],"?",0,0,0);?><?=str_repeat(" ", 1)?>
<?php endif; //GenotypicData bitiş?>
<?php endfor; ?>
<?= "\r\n" ?>
<?php endforeach; ?>
<?php endforeach; ?>