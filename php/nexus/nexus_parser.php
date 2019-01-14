<?php
Class nexus_parser
{
    public function parser($file_name,$dataType,$specify_format_of_data)
	{
		$sekans_sayisi			=0;
		$matching_symbol		=".";
		$format_baslangic		=false;
		$description_baslangic	=false;
		$new_individual			=false;
		$birey_isimleri			=array();
		$nexus=array(
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
		$satir_sayisi=count($file);
		if($satir_sayisi<2){
			array_push($nexus['header']['errors'],'Your input file has 1 line, we can not read...Please check in.');
		}
        $okunan_dosya=file($file);
        /**
        * Dosyadan satýr satýr okumaya baþlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			$line=trim($line);//satýrýn saðýndaki ve solundaki boþluklarý silecek
			if(!empty($line)){//eðer boþ satýr deðise
				if(preg_match('/;/i',$line) || preg_match('/end/i',$line) )//satýr içinde ; veya end varsa burasý data deðil
				{
					$data_baslangic=false;
				}
				if($data_baslangic==true){
					if($specify_format_of_data=='sequential'){//sekans formatý ise(noninterleaved)
						if(preg_match('/\\s/',$line) && !preg_match('/\[|\]/',$line)){//satýr içinde whitespace karakter varsa veya "[" veya "]" karakterleri yoksa oku
							$lineArray 			= preg_split ("/[\s]+/", $line,2);//satýrý ilk whitespace karakterden 2 parçaya bölüyoruz
							$individual_name	= $lineArray[0];
							$individual_data 	= preg_replace('/\s++/', '', $lineArray[1]);//ikinci parçada boþluk olmayacak.
							array_push($nexus['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
							$sekans_sayisi++;
							$nexus['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
							$nexus['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
						}
					}
					else{
						if(preg_match('/\\s/',$line) && !preg_match('/\[|\]/',$line)){//satýr içinde boþluk, tab varsa veya "[" veya "]" karakterleri yoksa oku
							$lineArray 			= preg_split ("/[\s]+/", $line,2);//satýrý ilk whitespace karakterden 2 parçaya bölüyoruz
							$individual_name	= $lineArray[0];
							$individual_data 	= preg_replace('/\s++/', '', $lineArray[1]);//ikinci parçada boþluk olmayacak.
							if (in_array($individual_name, $birey_isimleri))
							{
								$key = array_search($individual_name, $birey_isimleri);
								$nexus['Data'][$key]['SeqData']['dataString1'].=$individual_data;
							}
							else
							{
								array_push($nexus['Data'],array(
									'SeqName'=>'',
									'SeqData'=>array(
										'dataString1'=>'',
										'dataString2'=>'',
									),
								));
								$sekans_sayisi++;
								$nexus['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
								$nexus['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
								array_push($birey_isimleri,$individual_name);
							}
						}
					}
					//En uzun sekansýn karakter sayýsý
					if(strlen($nexus['Data'][$sekans_sayisi-1]['SeqData']['dataString1'])>$nexus['header']['maxSeqLength']){
						$nexus['header']['maxSeqLength']=strlen($nexus['Data'][$sekans_sayisi-1]['SeqData']['dataString1']);
					}
					//En uzun birey isminin uzunluðu
					if(strlen($nexus['Data'][$sekans_sayisi-1]['SeqName'])>$nexus['header']['maxSeqNameLength']){
						$nexus['header']['maxSeqNameLength']=strlen($nexus['Data'][$sekans_sayisi-1]['SeqName']);
					}
				}
				/**
				* satýr içinde matrix kelimesi geçiyorsa bir sonraki satýrda data baþlayacak demektir.
				*/
				if(preg_match('/Matrix/i',$line))
				{
					$data_baslangic=true;
				}
			}
		}
		/*
		*Noktalý olan verileri ilk dizi olan referans dizisine göre tekrar düzenleyeceðiz.
		*/
		$referans	=str_split($nexus['Data'][0]['SeqData']['dataString1']);//Dizinin ilk referans elemaný harflere parçalanýr.
		for($i=1;$i<$sekans_sayisi;$i++){
			
			$degisecek	=str_split($nexus['Data'][$i]['SeqData']['dataString1']);
			foreach($degisecek as $key=>$value){
				if($value==$matching_symbol){
					$degisecek[$key]=$referans[$key];
					//echo $referans[$key];
				}
			}
			$nexus['Data'][$i]['SeqData']['dataString1']=implode('',$degisecek);//implode ile dizideki elemanlarý birleþtirip string elde ederiz.
		}
		return $nexus;
	}
}