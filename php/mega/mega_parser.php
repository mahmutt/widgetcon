<?php
Class mega_parser
{
    public function parser($file_name,$dataType,$specify_format_of_data)
	{
		$populasyon_sayisi		=0;
		$sekans_sayisi			=0;
		$matching_symbol		=".";
		$format_baslangic		=false;
		$description_baslangic	=false;
		$new_individual			=false;
		$birey_isimleri			=array();
		$mega=array(
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
		$file=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name;
        $okunan_dosya=file($file);
        /**
        * Dosyadan satýr satýr okumaya baþlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			$line=trim($line);
			if(!empty($line)){
				/**
				* satýr !TITLE veya TITLE kelimesi ile baþlýyorsa
				*/
				if(preg_match('/^!TITLE/i',$line))
				{
					$title=substr($line, 6);//Okunan satýrýn 6.karakterinden sonra ki kýsmý al
					$title=rtrim($title,';');//Sonunda ki noktalý virgülü (;) temizle
					$title=ltrim($title,':');//Baþýndaki iki nokta üstüsteyi (:) temizle
					$mega['header']['Title']=trim($title);//Sað ve solundaki boþluklarý temizle
					//echo $title.'</br>';
				}
				if(preg_match('/^TITLE/i',$line))
				{
					$title=substr($line, 5);//Okunan satýrýn 5.karakterinden sonra ki kýsmý al
					$title=rtrim($title,';');//Sonunda ki noktalý virgülü (;) temizle
					$title=ltrim($title,':');//Baþýndaki iki nokta üstüsteyi (:) temizle
					$mega['header']['Title']=trim($title);//Sað ve solundaki boþluklarý temizle
					//echo $title.'</br>';
				}
				/**
				* satýr !FORMAT veya FORMAT kelimesi ile baþlýyorsa
				*/
				if(preg_match('/^!FORMAT/i',$line) || preg_match('/^FORMAT/i',$line))
				{
					$format_baslangic=true;
				}
				/**
				* satýr !DESCRIPTION veya  DESCRIPTION kelimesi ile baþlýyorsa
				*/
				if(preg_match('/^!DESCRIPTION/i',$line) || preg_match('/^DESCRIPTION/i',$line))
				{
					$description_baslangic=true;
				}
				if($format_baslangic==true){
					$mega['header']['format'].=$line;
					//echo $mega['header']['format'].'<br>';
					/**
					* satýr ; ile sonlanýyorsa
					*/
					if(preg_match('/\;$/i',trim($line))){
						$format_baslangic=false;
					}
				}
				if($description_baslangic==true){
					$mega['header']['description'].=$line;
					//echo $mega['header']['description'].'<br>';
					/**
					* satýr ; ile sonlanýyorsa
					*/
					if(preg_match('/\;$/i',trim($line))){
						$description_baslangic=false;
					}
				}
				if($dataType=='distance'){//distance veri tipi ise
					if($sira!==0){ //ilk satýr deðilse
						if(preg_match('/^#/i',$line))//diez iþareti (#) ile baþlýyorsa
						{
							$individual_name	=ltrim($line,'#');
							array_push($mega['Data'],array(
								'SeqName'=>$individual_name,
								'SeqData'=>array(
									'dataString1'=>'',
								),
							));
						}
						else
						{
							if(!preg_match("/[a-zA-Z]/", $line)){//satýr içi harf içermiyorsa, distance deðerleri ise
								
								$mega['Data'][$sekans_sayisi+1]['SeqData']['dataString1']=trim($line);//mega dosyasýnda ilk bireyin verisi olmadýðýndan sonraki bireyin isminden distance verilerini eklemeye baþlarýz.
								$sekans_sayisi++;
							}
						}
					}
				}
				else//distance veri tipi deðilse
				{
					if($specify_format_of_data=='sequential'){//sekans formatý ise(noninterleaved)
					
						if(preg_match('/^#/i',$line) && $sira!==0)//diez iþareti (#) ile baþlýyorsa ve ilk satýr deðilse
						{
							$new_individual=true;//data baþlayacak
							array_push($mega['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
							$sekans_sayisi++;
							if(preg_match('/\\s/',$line)){//birey ismi ile ayný satýrda sekans verisi baþlýyorsa, satýr içinde whitespace karakter varsa 
								$lineArray 			= preg_split ("/[\s]+/", $line,2);//satýrý ilk whitespace karakterden 2 parçaya bölüyoruz
								$individual_name	=ltrim($lineArray[0],'#');
								$individual_data 	= preg_replace('/\s++/', '', $lineArray[1]);
								$mega['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
								$mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
								
							}else{//okunan satýrda sadece birey adý varsa
								$individual_name=ltrim($line,'#');
								$mega['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
							}
							
						}
						if(!preg_match('/^#/i',$line) && $new_individual==true)//okunan satýr diez (#) iþareti ile baþlamýyor ve data baþlamýþsa
						{
							$individual_data = preg_replace('/\s++/', '', $line);
							$mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
						}
					}else{//interleaved formatý ise
						if(preg_match('/^#/i',$line) && $sira!==0)//diez iþareti (#) ile baþlýyorsa ve ilk satýr deðilse
						{
							if(preg_match('/\\s/',$line)){//birey ismi ile ayný satýrda sekans verisi baþlýyorsa, satýr içinde whitespace karakter varsa 
								$lineArray 			= preg_split ("/[\s]+/", $line,2);//satýrý ilk whitespace karakterden 2 parçaya bölüyoruz
								$individual_name=ltrim($lineArray[0],'#');//Ýlk parçanýn baþýndaki diez (#) iþaretini temizle ve birey ismi olarak ata
								$individual_data = preg_replace('/\s++/', '', $lineArray[1]);//Ýkinci parçada ki tüm boþluklarý sil ve sekans verisi olarak ata
							}
							
							if (in_array($individual_name, $birey_isimleri))//Interleaved formatta daha önce ayný bireyin sekans verisi varsa
							{
								$key = array_search($individual_name, $birey_isimleri);//daha önceki bireyin dizideki sýrasý bulunacak
								$mega['Data'][$key]['SeqData']['dataString1'].=$individual_data;//Önceki sekans verisine ekleme yapýlacak
							}
							else
							{
								array_push($mega['Data'],array(
									'SeqName'=>'',
									'SeqData'=>array(
										'dataString1'=>'',
										'dataString2'=>'',
									),
								));
								$sekans_sayisi++;
								$mega['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
								$mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
								array_push($birey_isimleri,$individual_name);
							}
						}
					}
					//En uzun sekansýn karakter sayýsý
					if(strlen($mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'])>$mega['header']['maxSeqLength']){
						$mega['header']['maxSeqLength']=strlen($mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1']);
					}
					//En uzun birey isminin uzunluðu
					if(strlen($mega['Data'][$sekans_sayisi-1]['SeqName'])>$mega['header']['maxSeqNameLength']){
						$mega['header']['maxSeqNameLength']=strlen($mega['Data'][$sekans_sayisi-1]['SeqName']);
					}
				}
			}
		}
		if($dataType!=='distance'){
			/*
			*Noktalý olan verileri ilk dizi olan referans dizisine göre tekrar düzenleyeceðiz.
			*/
			$referans	=str_split($mega['Data'][0]['SeqData']['dataString1']);//Dizinin ilk referans elemaný harflere parçalanýr.
			for($i=1;$i<$sekans_sayisi;$i++){
				
				$degisecek	=str_split($mega['Data'][$i]['SeqData']['dataString1']);
				foreach($degisecek as $key=>$value){
					if($value==$matching_symbol){
						$degisecek[$key]=$referans[$key];
						//echo $referans[$key];
					}
				}
				$mega['Data'][$i]['SeqData']['dataString1']=implode('',$degisecek);//implode ile dizideki elemanlarý birleþtirip string elde ederiz.
			}
		}
		
		return $mega;
	}
}