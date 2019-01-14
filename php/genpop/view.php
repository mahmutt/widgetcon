<?php 
		$file_name="genpop_6.txt";
		$dataType="microsat";
		$how_microsat_coded="";
		$missing_data_value_code="0";
		$populasyon_sayisi=0;
		$lokus_saymaya_devamet=true;
		$birey_sayisi=0;
		$maxindchar=0;//max birey isminin uzunluğu
		$haploid=true;
		$kayip_isim=0;
		$genpop=array(
            'header'=>array(
                'Title'=>'default title',#"any string within double quotes",
                'DataType'=>$dataType,#MICROSAT,DNA,RFLP,STANDART,FREQUENY
				'LociList'=>array(),
				'PopNameList'=>array(),
				'maxindchar'=>'',
				'missing_data_value_code'=>$missing_data_value_code,
				'max_individual_name_length'=>0,
				'ploidy'=>'',
				'errors'=>array(),
            ),
            'Data'=>array(
                /*
				array(
                    'PopName'=>'name_82',
                    'IndividualName'=>'',
                    'PopData'=>array(
						'dataArray1'=>'q',
						'dataArray2'=>'q',
                    ),
                ),
                array(
                    'PopName'=>'name_82',
					'IndividualName'=>'',
                    'PopData'=>array(
						'dataArray1'=>'q',
						'dataArray2'=>'q',
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
			/**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satırlar boş olmadığı sürece okumaya devam et 
            */
			$line = trim($line);
			if(!empty($line)) 
			{ 
				if($sira==0){
					$genpop['header']['Title']=$line;//İlk satır açıklama satırı olacak
				}else{
					
					//pop kelimesi buluncaya kadar lokus saymaya devam et
					if($lokus_saymaya_devamet==true)
					{
						//lokus sayarken,satır virgül içeriyorsa, virgülle parçala ve lokus dizisine at
						if(preg_match("/,/", $line))
						{
							$lociArray=explode(',',trim($line));
							foreach($lociArray as $i=>$oneLocus)
							{
								array_push($genpop['header']['LociList'],$oneLocus);
							}
						}
						else
						{
							//lokus isimleri ardışık satırlar da ise satır satır diziye ata
							array_push($genpop['header']['LociList'],trim($line));
						}
						$lokus_saymaya_devamet=false;	
					}else{
						if(preg_match('/^POP/i',$line))
						{
							//pop kelimesi görünce lokus saymayı bırak ve her pop kelimesinde populasyon sayısını 1 artır.Dizi içine populasyon için yer aç
							$lokus_saymaya_devamet=false;
							
							//Pop geçen satırda populasyon ismi varsa bunu diziye eklemeliyiz, explode ile boşluktan 2 ye ayırıp ikinci kısmı varsa
							//populasyon adı olarak diziye ekliyoruz.
							$PopSatir=explode(' ',$line,2);
							if(count($PopSatir)>1){
								$PopName=trim($PopSatir[1]);
							}else{
								$PopName='';
							}
							array_push($genpop['header']['PopNameList'],$PopName);
							$populasyon_sayisi++;
						}
					
					
						//lokuslar bitti eğer satırlar okunmaya devam ediyorsa ve pop kelimesi ile başlamıyorsa birey sayısını artır
						if(!preg_match('/^POP/i',$line) && $lokus_saymaya_devamet==false)
						{
							
							//satır pop ve virgül içeriyor ve lokus sayma bitmişse
							if(preg_match("/,/", $line))
							{
								
								//bütün boşluk türlerini tek ya da daha fazla boşlukları tek boşluğa çevir
								$line			= preg_replace('/\s+/', ' ', $line);
								//satırı virgül ile ikiye böl ve ilk kısmını birey adı olarak al
								$satir_parcala	=explode(',',$line,2);
								$individual		=trim($satir_parcala[0]);
								$dataArray1		=trim($satir_parcala[1]);
								//bilgiler içinde virgül kaldıysa silmeliyiz
								$dataArray1 	= str_replace(',','',$dataArray1 );
								//genotipik veriler içinde çok uzun boşlukları standart olarak tek boşluk haline çevirebiliyoruz.
								$dataArray1 	=trim(preg_replace('/\\s++/', ' ', $dataArray1));
								//bilgisi adında bir dizi haline çevirebiliriz.
								
								$dataArray1		=explode(' ',$dataArray1);
								
								//diziye birey eklenecek
								array_push($genpop['Data'],array(
									'PopName'=>$PopName,
									'IndividualName'=>$individual,
									'PopData'=>array(
										'dataArray1'=>$dataArray1,
										'dataArray2'=>[],
									),
								));
								//satır virgül içeriyorsa yeni birey var demektir.
								$birey_sayisi++;
							}
							else
							{
								//satır pop ve virgül içermiyorsa üst satırın devamı demektir ve bilgileri üst bireyin
								//bilgilerine ekleyeceğiz
								$bilgiler_altsatir=explode(' ',$line);
								array_merge($genpop['Data'][$birey_sayisi-1]['PopData']['dataArray1'],$bilgiler_altsatir);
							}
						}
					}
				}
			} 
		}
		foreach($genpop['header']['LociList'] as $key=>$value){
			echo $value.'<br>';
		}
		echo $genpop['Data'][0]['PopName'].'<br>';
		echo $genpop['Data'][0]['PopData']['dataArray1'][5].'<br>';
?>