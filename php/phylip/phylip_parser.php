<?php
Class phylip_parser
{
    public function parser($file_name,$dataType,$specify_format_of_data,$what_type_of_data)
	{
		$populasyon_sayisi		=0;
		$sekans_sayisi			=0;
		$matching_symbol		=".";
		$new_individual			=true;
		$phylip=array(
            'header'=>array(
                'Title'=>'default title',#"any string within double quotes",
                'DataType'=>$dataType,#MICROSAT,DNA,RFLP,STANDART,FREQUENY
				'LociList'=>array(),
				'maxindchar'=>'',
				'ploidy'=>'1',
				'gap'=>'-',
				'missingData'=>'?',
				'maxSeqLength'=>0,
                'maxSeqNameLength'=>0,
				'errors'=>array(),
            ),
            'Data'=>array(
                /*
				array(
                    'SeqName'=>'name_82',
                    'SeqData'=>array(
						'dataString1'=>'q',
						'dataString2'=>'q',
                    ),
                ),
                array(
                    'SeqName'=>'name_82',
                    'SeqData'=>array(
						'dataString1'=>'q',
						'dataString2'=>'q',
                    ),
                ),
                 .........
                */
            ),
        );
		$file=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name;
        $okunan_dosya=file($file);
        /**
        * Dosyadan satýr satýr okumaya baþlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			if($dataType=='distance'){//phylip distance data tipi ise
				//$line=trim($line);
				/*
				*	phylip distance dosya formatýnda ilk satýr zorunlu ve rakamdan oluþur.
				*	5   gibi...  birey sayýsýdýr.
				*/
				if(!empty($line)){
					if($sira==0){
						$count_of_individual	=trim($line);//ilk parça birey sayýsý
						for($i=0;$i<$count_of_individual;$i++){//birey sayýsý kadar ana diziye alt dizi ekliyoruz.
							array_push($phylip['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
						}
						$new_individual=true;//ilk satýrdan sonra birey adý ile baþlayan sekans gelecek
						
						//En uzun birey isminin uzunluðu
						$phylip['header']['maxSeqNameLength']=10;
						
					}
					else{
						if(preg_match("/[a-zA-Z]/", $line))//satýr içinde harf içerenler varsa yeni birey var demektir.
						{
							$new_individual=true;
							$individual_name 		= trim(substr($line, 0, 10));
							$individual_data 		= trim(substr($line, 10));
							$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
							$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
							$sekans_sayisi++;
							
						}
						else//satýr birey adý ile baþlamýyorsa önceki bireye verileri eklemeye devam edelim.
						{
							$new_individual=false;
							//satýr distance ile baþlýyorsa bir önceki sekansa veri eklemeye devam edecek
							$phylip['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].='  '.trim($line);
						}
					}
				}
			}
			else// pyhlip distance data tipi deðilse
			{
				//$line=trim($line);
				/*
				*	phylip dosya formatýnda ilk satýr zorunlu ve rakamlardan oluþur.
				*	5 350   gibi...  ilk sayý birey sayýsýdýr(veya sekans sayýsý olarak da ifade edilir).ikinci sayý her bireyin sahip olduðu nükleotid ya da *	  amino asid sayýsýdýr.
				*/
				if(!empty($line)){
					if($sira==0){
						$line					=preg_split('/[\s]+/',trim($line));// ilk satýrý whitespace karakterlerden parçalara böleceðiz.
						$count_of_individual	=$line[0];//ilk parça birey sayýsý
						$sequence_length		=$line[1];//ikinci parça sekansdaki nükleotid ya da amino asid sayýsý
						for($i=0;$i<$count_of_individual;$i++){//birey sayýsý kadar ana diziye alt dizi ekliyoruz.
							array_push($phylip['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
						}
						$new_individual=true;//ilk satýrdan sonra birey adý ile baþlayan sekans gelecek
						//En uzun sekansýn karakter sayýsý
						$phylip['header']['maxSeqLength']=$sequence_length;
						
						//En uzun birey isminin uzunluðu
						$phylip['header']['maxSeqNameLength']=10;
						
					}else{
						if($specify_format_of_data=='sequential'){//sekans formatý ise
							if($new_individual==true){//birey adý ile baþlayan sekans ise
								$individual_name 		= trim(substr($line, 0, 10));
								$individual_data 		= substr($line, 10); 
								$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));
								if(strlen($individual_data)<$sequence_length){//ayný birey için alt satýrlarda sekans okumaya devam, sekans dolmadý
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$new_individual==false;//yeni bireyin sekansýný okumaya devam edecek
								}else if(strlen($individual_data)==$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$new_individual==true;//yeni bireyin sekansýna geçecek
									$sekans_sayisi++;
								}else{
									$new_individual==true;//yeni bireyin sekansýna geçecek
									$sekans_sayisi++;
								}
							}else{//sekans birey adý ile baþlamayacaksa
								$individual_data 		= preg_replace('/\s++/', '', trim($line));
								$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
								
								if($total_sequence_length<$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
									$new_individual==false;//yeni bireyin sekansýný okumaya devam edecek
								}else if($total_sequence_length==$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
									$new_individual==true;//yeni bireyin sekansýna geçecek
									$sekans_sayisi++;
								}else{
									$new_individual==true;//yeni bireyin sekansýna geçecek
									$sekans_sayisi++;
								}
							}
							
						}else{//interleaved formatý ise
							
							if($new_individual==true){//birey adý ile baþlayan sekans ise
								$individual_name 		= trim(substr($line, 0, 10));//satýrýn ilk 10 karakterini birey adý olarak alýyoruz.
								$individual_data 		= substr($line, 10); //Satýrýn 10. karakterinden sonra birey verileri gelecek
								$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));//bireyin verilerinde ki tüm boþluklarý temizliyoruz.
								$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
								
								if($total_sequence_length<=$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$sekans_sayisi++;//Veriyi ekledikten sonra sekans sayýsýný 1 artýrýyoruz.
									if($sekans_sayisi==$count_of_individual){//sekans sayýsý, birey sayýsýna eþit olunca artýk sekanslar birey adý olmadan baþlayacak.
										$new_individual=false;
									}
								}
							}else{//sekans birey adý ile baþlamayacaksa
								$key					= $sekans_sayisi%$count_of_individual;
								$individual_data 		= preg_replace('/\s++/', '', trim($line));
								$total_sequence_length	= strlen($phylip['Data'][$key]['SeqData']['dataString1'])+strlen($individual_data);
								if($total_sequence_length<=$sequence_length){
									$phylip['Data'][$key]['SeqData']['dataString1'].=$individual_data;
									$sekans_sayisi++;
								}
							}
							
						}
					}
				}
			}
		}
		if($dataType=="distance"){
			if(count($phylip['Data'])!==$sekans_sayisi){
				array_push($phylip['header']['errors'],"Individual number in first line(".count($phylip['Data']).") are not correspond to individual size(".$sekans_sayisi.") in your input file!");
			}
		}
		return $phylip;
	}
}