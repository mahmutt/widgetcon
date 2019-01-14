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
<?= "#Mega" ?>
<?= "\r\n" ?>
<?= "!Title"?><?="\t"?>Arlequin to Mega via widgetcon<?=";"?>
<?= "\r\n" ?>
<?= "!Format"?><?="\t"?><?="DataType="?><?=$app->label($dataType);?><?="\t"?>Indel-<?="\t"?>Missing=?;
<?= "\r\n" ?>
<?= "\r\n" ?>
<?php foreach ($dizi['Data'] as $key=>$value): ?>
<?php foreach ($value['SampleData'] as $k=>$v): ?>
<?php if($dizi['header']['GenotypicData']==0): //GenotypicData sı 0 ise?>
#<?= $app->mega_format_individual_name($v['individual']);?><?= "\r\n" ?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$v['data']['dataString1'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data1;?>
<?= "\r\n" ?>
<?php else: //SNP değilse?>
<?php $fark=$dizi['header']['LocusSize']-strlen($data1)?>
<?= wordwrap(($data1.str_repeat('-', $fark)),60, "\r\n",true); //eksik olan nükleotid yerine - yazdık. MEGA programı böyle kabul ediyor?>
<?= "\r\n" ?>
<?php endif; //SNP bitiş?>
<?php else: //GenotypicData sı 1 ise?>
#<?= $app->mega_format_individual_name($v['individual']);?><?= "\r\n" ?>
<?php $data1="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data1.=$v['data']['dataString1'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data1;?>
<?= "\r\n" ?>
<?php else: //SNP değilse?>
<?php $fark=$dizi['header']['LocusSize']-strlen($data1)?>
<?= wordwrap(($data1.str_repeat('-', $fark)),60, "\r\n",true); //eksik olan nükleotid yerine - yazdık. MEGA programı böyle kabul ediyor?>
<?= "\r\n" ?>
<?php endif; //SNP bitiş?>
#<?= $app->mega_format_individual_name($v['individual']);?><?= "\r\n" ?>
<?php $data2="";?>
<?php for($i=0;$i<$dizi['header']['LocusSize'];$i++): ?>
<?php $data2.=$v['data']['dataString2'][$i];?>
<?php endfor; ?>
<?php if($dataType=='snp'): //SNP ise?>
<?= $data2;?>
<?= "\r\n" ?>
<?php else: //SNP değilse?>
<?php $fark=$dizi['header']['LocusSize']-strlen($data2)?>
<?= wordwrap(($data2.str_repeat('-', $fark)),60, "\r\n",true); //eksik olan nükleotid yerine - yazdık. MEGA programı böyle kabul ediyor?>
<?= "\r\n" ?>
<?php endif; //SNP bitiş?>
<?php endif; //GenotypicData bitiş?>
<?= "\r\n" ?>
<?php endforeach; ?>
<?php endforeach; ?>

