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
        * Dosyadan satýr satýr okumaya baþlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			/**
            * Satýrýn($line) baþýndan ve sonundan boþluklarý sildikten sonra
            * satýrlar boþ olmadýðý sürece okumaya devam et 
            */
			$line = trim($line);
			if(!empty($line)) 
			{ 
				if($sira==0){
					$genpop['header']['Title']=$line;//Ýlk satýr açýklama satýrý olacak
				}else{
					
					//pop kelimesi buluncaya kadar lokus saymaya devam et
					if($lokus_saymaya_devamet==true && !preg_match('/^POP/i',$line))
					{
						//lokus sayarken,satýr virgül içeriyorsa, POP ile baþlamamýþ ise, virgülle parçala ve lokus dizisine at
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
							//lokus isimleri ardýþýk satýrlar da ise satýr satýr diziye ata
							array_push($genpop['header']['LociList'],trim($line));
						}
					}else{
						if(preg_match('/^POP/i',$line))
						{
							//pop kelimesi görünce lokus saymayý býrak ve her pop kelimesinde populasyon sayýsýný 1 artýr.Dizi içine populasyon için yer aç
							$lokus_saymaya_devamet=false;
							
							//Pop geçen satýrda populasyon ismi varsa bunu diziye eklemeliyiz, explode ile boþluktan 2 ye ayýrýp ikinci kýsmý varsa
							//populasyon adý olarak diziye ekliyoruz.
							$PopSatir=explode(' ',$line,2);
							if(count($PopSatir)>1){
								$PopName=trim($PopSatir[1]);
							}else{
								$PopName='POP_'.($populasyon_sayisi+1);
							}
							array_push($genpop['header']['PopNameList'],$PopName);
							$populasyon_sayisi++;
						}
					
					
						//lokuslar bitti eðer satýrlar okunmaya devam ediyorsa ve pop kelimesi ile baþlamýyorsa birey sayýsýný artýr
						if(!preg_match('/^POP/i',$line) && $lokus_saymaya_devamet==false)
						{
							
							//POP ile baþlamamýþ virgül içeriyor ve lokus sayma bitmiþse
							if(preg_match("/,/", $line))
							{
								
								//bütün boþluk türlerini tek ya da daha fazla boþluklarý tek boþluða çevir
								$line			= preg_replace('/\s+/', ' ', $line);
								//satýrý virgül ile ikiye böl ve ilk kýsmýný birey adý olarak al
								$satir_parcala	=explode(',',$line,2);
								$individual		=trim($satir_parcala[0]);
								$dataArray		=trim($satir_parcala[1]);
								//bilgiler içinde virgül kaldýysa silmeliyiz
								$dataArray 	= str_replace(',','',$dataArray );
								//genotipik veriler içinde çok uzun boþluklarý standart olarak tek boþluk haline çevirebiliyoruz.
								$dataArray 	=trim(preg_replace('/\\s++/', ' ', $dataArray));
								//bilgisi adýnda bir dizi haline çevirebiliriz.
								
								$dataArray		=explode(' ',$dataArray);
								//Eðer tek veri uzunluðu 3 ten büyükse dosyayý diploid olarak alacaðýz 01 veya 010->haploid, 0101->diploid
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
								//satýr virgül içeriyorsa yeni birey var demektir.
								$birey_sayisi++;
							}
							else
							{
								//satýr pop ve virgül içermiyorsa üst satýrýn devamý demektir ve bilgileri üst bireyin
								//bilgilerine ekleyeceðiz
								$bilgiler_altsatir=explode(' ',$line);
								//Eðer tek veri uzunluðu  3 ten büyükse dosyayý diploid olarak alacaðýz 01 veya 010->haploid, 0101->diploid
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