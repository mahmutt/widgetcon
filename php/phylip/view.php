<?php
		$file_name				="phylip-2-s.py";
		$specify_format_of_data	='sequential';
		$populasyon_sayisi		=0;
		$sekans_sayisi			=0;
		$matching_symbol		=".";
		$new_individual			=false;
		$sequence_continue		=true;
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
		$file=$_SERVER['DOCUMENT_ROOT'].'/converter/uploads/'.$file_name;
        $okunan_dosya=file($file);
        /**
        * Dosyadan satır satır okumaya başlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			$line=trim($line);
			/*
			phylip dosya formatında ilk satır zorunlu ve rakamlardan oluşur.
			5 350   gibi...  ilk sayı birey sayısıdır(veya sekans sayısı olarak da ifade edilir).ikinci sayı her bireyin sahip olduğu nükleotid ya da amino asid sayısıdır.
			*/
			if(!empty($line)){
				if($sira==0){
					$line					=preg_split('/[\s]+/',trim($line));// ilk satırı whitespace karakterlerden parçalara böleceğiz.
					$count_of_individual	=$line[0];//ilk parça birey sayısı
					$sequence_length		=$line[1];//ikinci parça sekansdaki nükleotid ya da amino asid sayısı
					for($i=0;$i<$count_of_individual;$i++){//birey sayısı kadar ana diziye alt dizi ekliyoruz.
						array_push($phylip['Data'],array(
							'SeqName'=>'',
							'SeqData'=>array(
								'dataString1'=>'',
								'dataString2'=>'',
							),
						));
					}
					$new_individual=true;//ilk satırdan sonra birey adı ile başlayan sekans gelecek
				}else{
					if($specify_format_of_data=='sequential'){//sekans formatı ise
						if($new_individual==true){//birey adı ile başlayan sekans ise
							$individual_name 		= trim(substr($line, 0, 10));
							$individual_data 		= substr($line, 10); 
							$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));
							if(strlen($individual_data)<$sequence_length){//aynı birey için alt satırlarda sekans okumaya devam, sekans dolmadı
								$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
								$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
								$new_individual==false;//yeni bireyin sekansını okumaya devam edecek
							}else if(strlen($individual_data)==$sequence_length){
								$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
								$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
								$new_individual==true;//yeni bireyin sekansına geçecek
								$sekans_sayisi++;
							}else{
								$new_individual==true;//yeni bireyin sekansına geçecek
								$sekans_sayisi++;
							}
						}else{//sekans birey adı ile başlamayacaksa
							$individual_data 		= preg_replace('/\s++/', '', trim($line));
							$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
							
							if($total_sequence_length<$sequence_length){
								$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
								$new_individual==false;//yeni bireyin sekansını okumaya devam edecek
							}else if($total_sequence_length==$sequence_length){
								$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
								$new_individual==true;//yeni bireyin sekansına geçecek
								$sekans_sayisi++;
							}else{
								$new_individual==true;//yeni bireyin sekansına geçecek
								$sekans_sayisi++;
							}
						}
						
					}else{//interleaved formatı ise
						
						if($new_individual==true){//birey adı ile başlayan sekans ise
							$individual_name 		= trim(substr($line, 0, 10));//satırın ilk 10 karakterini birey adı olarak alıyoruz.
							$individual_data 		= substr($line, 10); //Satırın 10. karakterinden sonra birey verileri gelecek
							$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));//bireyin verilerinde ki tüm boşlukları temizliyoruz.
							$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
							
							if($total_sequence_length<=$sequence_length){
								$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
								$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
								$sekans_sayisi++;//Veriyi ekledikten sonra sekans sayısını 1 artırıyoruz.
								if($sekans_sayisi==$count_of_individual){//sekans sayısı, birey sayısına eşit olunca artık sekanslar birey adı olmadan başlayacak.
									$new_individual=false;
								}
							}
						}else{//sekans birey adı ile başlamayacaksa
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
		echo $phylip['Data'][0]['SeqName'].'<br>';
		echo $phylip['Data'][0]['SeqData']['dataString1'];
		
