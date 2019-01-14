<?php
Class genpop_parser
{
    public function parser(
		$file_name,
		$dataType,
		$how_microsat_coded,
		$repeatSize
	)
	{
		$populasyon_sayisi=0;
		$lokus_saymaya_devamet=true;
		$birey_sayisi=0;
		$genpop=array(
            'header'=>array(
                'Title'=>'default title',#"any string within double quotes",
                'DataType'=>$dataType,#MICROSAT,DNA,RFLP,STANDART,FREQUENY
				'LociList'=>array(),
				'PopNameList'=>array(),
				'maxindchar'=>'',
				'missing_data_value_code'=>'',
				'max_individual_name_length'=>0,
				'ploidy'=>0,
				'errors'=>array(),
            ),
            'Data'=>array(
                /*
				array(
                    'PopName'=>'name_82',
                    'PopNumber'=>'',
                    'IndividualName'=>'',
                    'PopData'=>array(
						'dataArray'=>'q',
                    ),
                ),
                array(
                    'PopName'=>'name_82',
                    'PopNumber'=>'name_82',
					'IndividualName'=>'',
                    'PopData'=>array(
						'dataArray'=>'q',
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
			/**
            * Sat�r�n($line) ba��ndan ve sonundan bo�luklar� sildikten sonra
            * sat�rlar bo� olmad��� s�rece okumaya devam et 
            */
			$line = trim($line);
			if(!empty($line)) 
			{ 
				if($sira==0){
					$genpop['header']['Title']=$line;//�lk sat�r a��klama sat�r� olacak
				}else{
					
					//pop kelimesi buluncaya kadar lokus saymaya devam et
					if($lokus_saymaya_devamet==true && !preg_match('/^POP/i',$line))
					{
						//lokus sayarken,sat�r virg�l i�eriyorsa, POP ile ba�lamam�� ise, virg�lle par�ala ve lokus dizisine at
						if(preg_match("/,/", $line))
						{
							$lociArray=explode(',',trim($line));
							foreach($lociArray as $i=>$oneLocus)
							{
								array_push($genpop['header']['LociList'],$oneLocus);
							}
							$lokus_saymaya_devamet=false;	
						}
						else
						{
							//lokus isimleri ard���k sat�rlar da ise sat�r sat�r diziye ata
							array_push($genpop['header']['LociList'],trim($line));
						}
					}else{
						if(preg_match('/^POP/i',$line))
						{
							//pop kelimesi g�r�nce lokus saymay� b�rak ve her pop kelimesinde populasyon say�s�n� 1 art�r.Dizi i�ine populasyon i�in yer a�
							$lokus_saymaya_devamet=false;
							
							//Pop ge�en sat�rda populasyon ismi varsa bunu diziye eklemeliyiz, explode ile bo�luktan 2 ye ay�r�p ikinci k�sm� varsa
							//populasyon ad� olarak diziye ekliyoruz.
							$PopSatir=explode(' ',$line,2);
							if(count($PopSatir)>1){
								$PopName=trim($PopSatir[1]);
							}else{
								$PopName='POP_'.($populasyon_sayisi+1);
							}
							array_push($genpop['header']['PopNameList'],$PopName);
							$populasyon_sayisi++;
						}
					
					
						//lokuslar bitti e�er sat�rlar okunmaya devam ediyorsa ve pop kelimesi ile ba�lam�yorsa birey say�s�n� art�r
						if(!preg_match('/^POP/i',$line) && $lokus_saymaya_devamet==false)
						{
							
							//POP ile ba�lamam�� virg�l i�eriyor ve lokus sayma bitmi�se
							if(preg_match("/,/", $line))
							{
								
								//b�t�n bo�luk t�rlerini tek ya da daha fazla bo�luklar� tek bo�lu�a �evir
								$line			= preg_replace('/\s+/', ' ', $line);
								//sat�r� virg�l ile ikiye b�l ve ilk k�sm�n� birey ad� olarak al
								$satir_parcala	=explode(',',$line,2);
								$individual		=trim($satir_parcala[0]);
								$dataArray		=trim($satir_parcala[1]);
								//bilgiler i�inde virg�l kald�ysa silmeliyiz
								$dataArray 	= str_replace(',','',$dataArray );
								//genotipik veriler i�inde �ok uzun bo�luklar� standart olarak tek bo�luk haline �evirebiliyoruz.
								$dataArray 	=trim(preg_replace('/\\s++/', ' ', $dataArray));
								//bilgisi ad�nda bir dizi haline �evirebiliriz.
								
								$dataArray		=explode(' ',$dataArray);
								//E�er tek veri uzunlu�u 3 ten b�y�kse dosyay� diploid olarak alaca��z 01 veya 010->haploid, 0101->diploid
								foreach($dataArray as $i=>$oneData)
								{
									if(strlen($oneData)>3)
									{
										$genpop['header']['ploidy']=1;
									}
								}
								
								//diziye birey eklenecek
								array_push($genpop['Data'],array(
									'PopName'=>$PopName,
									'PopNumber'=>$populasyon_sayisi,
									'IndividualName'=>$individual,
									'PopData'=>array(
										'dataArray'=>$dataArray,
										'dataArray2'=>[],
									),
								));
								//sat�r virg�l i�eriyorsa yeni birey var demektir.
								$birey_sayisi++;
							}
							else
							{
								//sat�r pop ve virg�l i�ermiyorsa �st sat�r�n devam� demektir ve bilgileri �st bireyin
								//bilgilerine ekleyece�iz
								$bilgiler_altsatir=explode(' ',$line);
								//E�er tek veri uzunlu�u  3 ten b�y�kse dosyay� diploid olarak alaca��z 01 veya 010->haploid, 0101->diploid
								foreach($bilgiler_altsatir as $i=>$oneData)
								{
									if(strlen($oneData)>3)
									{
										$genpop['header']['ploidy']=1;
									}
								}
								$genpop['Data'][$birey_sayisi-1]['PopData']['dataArray']=array_merge($genpop['Data'][$birey_sayisi-1]['PopData']['dataArray'],$bilgiler_altsatir);
							}
						}
					}
				}
			} 
		}
		if(!empty($repeatSize)){
			$repeatSize=explode(",",$repeatSize);
			if(count($repeatSize)!==1 && count($repeatSize)!==count($genpop['header']['LociList'])){
				array_push($genpop['header']['errors'],"loci numbers are not correspond to repeated size in your input file!");
			}
		}
		return $genpop;
	}
}