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
        * Dosyadan sat�r sat�r okumaya ba�layacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			if($dataType=='distance'){//phylip distance data tipi ise
				//$line=trim($line);
				/*
				*	phylip distance dosya format�nda ilk sat�r zorunlu ve rakamdan olu�ur.
				*	5   gibi...  birey say�s�d�r.
				*/
				if(!empty($line)){
					if($sira==0){
						$count_of_individual	=trim($line);//ilk par�a birey say�s�
						for($i=0;$i<$count_of_individual;$i++){//birey say�s� kadar ana diziye alt dizi ekliyoruz.
							array_push($phylip['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
						}
						$new_individual=true;//ilk sat�rdan sonra birey ad� ile ba�layan sekans gelecek
						
						//En uzun birey isminin uzunlu�u
						$phylip['header']['maxSeqNameLength']=10;
						
					}
					else{
						if(preg_match("/[a-zA-Z]/", $line))//sat�r i�inde harf i�erenler varsa yeni birey var demektir.
						{
							$new_individual=true;
							$individual_name 		= trim(substr($line, 0, 10));
							$individual_data 		= trim(substr($line, 10));
							$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
							$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
							$sekans_sayisi++;
							
						}
						else//sat�r birey ad� ile ba�lam�yorsa �nceki bireye verileri eklemeye devam edelim.
						{
							$new_individual=false;
							//sat�r distance ile ba�l�yorsa bir �nceki sekansa veri eklemeye devam edecek
							$phylip['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].='  '.trim($line);
						}
					}
				}
			}
			else// pyhlip distance data tipi de�ilse
			{
				//$line=trim($line);
				/*
				*	phylip dosya format�nda ilk sat�r zorunlu ve rakamlardan olu�ur.
				*	5 350   gibi...  ilk say� birey say�s�d�r(veya sekans say�s� olarak da ifade edilir).ikinci say� her bireyin sahip oldu�u n�kleotid ya da *	  amino asid say�s�d�r.
				*/
				if(!empty($line)){
					if($sira==0){
						$line					=preg_split('/[\s]+/',trim($line));// ilk sat�r� whitespace karakterlerden par�alara b�lece�iz.
						$count_of_individual	=$line[0];//ilk par�a birey say�s�
						$sequence_length		=$line[1];//ikinci par�a sekansdaki n�kleotid ya da amino asid say�s�
						for($i=0;$i<$count_of_individual;$i++){//birey say�s� kadar ana diziye alt dizi ekliyoruz.
							array_push($phylip['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
						}
						$new_individual=true;//ilk sat�rdan sonra birey ad� ile ba�layan sekans gelecek
						//En uzun sekans�n karakter say�s�
						$phylip['header']['maxSeqLength']=$sequence_length;
						
						//En uzun birey isminin uzunlu�u
						$phylip['header']['maxSeqNameLength']=10;
						
					}else{
						if($specify_format_of_data=='sequential'){//sekans format� ise
							if($new_individual==true){//birey ad� ile ba�layan sekans ise
								$individual_name 		= trim(substr($line, 0, 10));
								$individual_data 		= substr($line, 10); 
								$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));
								if(strlen($individual_data)<$sequence_length){//ayn� birey i�in alt sat�rlarda sekans okumaya devam, sekans dolmad�
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$new_individual==false;//yeni bireyin sekans�n� okumaya devam edecek
								}else if(strlen($individual_data)==$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$new_individual==true;//yeni bireyin sekans�na ge�ecek
									$sekans_sayisi++;
								}else{
									$new_individual==true;//yeni bireyin sekans�na ge�ecek
									$sekans_sayisi++;
								}
							}else{//sekans birey ad� ile ba�lamayacaksa
								$individual_data 		= preg_replace('/\s++/', '', trim($line));
								$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
								
								if($total_sequence_length<$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
									$new_individual==false;//yeni bireyin sekans�n� okumaya devam edecek
								}else if($total_sequence_length==$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'].=$individual_data;
									$new_individual==true;//yeni bireyin sekans�na ge�ecek
									$sekans_sayisi++;
								}else{
									$new_individual==true;//yeni bireyin sekans�na ge�ecek
									$sekans_sayisi++;
								}
							}
							
						}else{//interleaved format� ise
							
							if($new_individual==true){//birey ad� ile ba�layan sekans ise
								$individual_name 		= trim(substr($line, 0, 10));//sat�r�n ilk 10 karakterini birey ad� olarak al�yoruz.
								$individual_data 		= substr($line, 10); //Sat�r�n 10. karakterinden sonra birey verileri gelecek
								$individual_data 		= preg_replace('/\s++/', '', trim($individual_data));//bireyin verilerinde ki t�m bo�luklar� temizliyoruz.
								$total_sequence_length	= strlen($phylip['Data'][$sekans_sayisi]['SeqData']['dataString1'])+strlen($individual_data);
								
								if($total_sequence_length<=$sequence_length){
									$phylip['Data'][$sekans_sayisi]['SeqName']=$individual_name;
									$phylip['Data'][$sekans_sayisi]['SeqData']['dataString1']=$individual_data;
									$sekans_sayisi++;//Veriyi ekledikten sonra sekans say�s�n� 1 art�r�yoruz.
									if($sekans_sayisi==$count_of_individual){//sekans say�s�, birey say�s�na e�it olunca art�k sekanslar birey ad� olmadan ba�layacak.
										$new_individual=false;
									}
								}
							}else{//sekans birey ad� ile ba�lamayacaksa
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