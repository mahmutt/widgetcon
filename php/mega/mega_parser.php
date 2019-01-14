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
        * Dosyadan sat�r sat�r okumaya ba�layacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			$line=trim($line);
			if(!empty($line)){
				/**
				* sat�r !TITLE veya TITLE kelimesi ile ba�l�yorsa
				*/
				if(preg_match('/^!TITLE/i',$line))
				{
					$title=substr($line, 6);//Okunan sat�r�n 6.karakterinden sonra ki k�sm� al
					$title=rtrim($title,';');//Sonunda ki noktal� virg�l� (;) temizle
					$title=ltrim($title,':');//Ba��ndaki iki nokta �st�steyi (:) temizle
					$mega['header']['Title']=trim($title);//Sa� ve solundaki bo�luklar� temizle
					//echo $title.'</br>';
				}
				if(preg_match('/^TITLE/i',$line))
				{
					$title=substr($line, 5);//Okunan sat�r�n 5.karakterinden sonra ki k�sm� al
					$title=rtrim($title,';');//Sonunda ki noktal� virg�l� (;) temizle
					$title=ltrim($title,':');//Ba��ndaki iki nokta �st�steyi (:) temizle
					$mega['header']['Title']=trim($title);//Sa� ve solundaki bo�luklar� temizle
					//echo $title.'</br>';
				}
				/**
				* sat�r !FORMAT veya FORMAT kelimesi ile ba�l�yorsa
				*/
				if(preg_match('/^!FORMAT/i',$line) || preg_match('/^FORMAT/i',$line))
				{
					$format_baslangic=true;
				}
				/**
				* sat�r !DESCRIPTION veya  DESCRIPTION kelimesi ile ba�l�yorsa
				*/
				if(preg_match('/^!DESCRIPTION/i',$line) || preg_match('/^DESCRIPTION/i',$line))
				{
					$description_baslangic=true;
				}
				if($format_baslangic==true){
					$mega['header']['format'].=$line;
					//echo $mega['header']['format'].'<br>';
					/**
					* sat�r ; ile sonlan�yorsa
					*/
					if(preg_match('/\;$/i',trim($line))){
						$format_baslangic=false;
					}
				}
				if($description_baslangic==true){
					$mega['header']['description'].=$line;
					//echo $mega['header']['description'].'<br>';
					/**
					* sat�r ; ile sonlan�yorsa
					*/
					if(preg_match('/\;$/i',trim($line))){
						$description_baslangic=false;
					}
				}
				if($dataType=='distance'){//distance veri tipi ise
					if($sira!==0){ //ilk sat�r de�ilse
						if(preg_match('/^#/i',$line))//diez i�areti (#) ile ba�l�yorsa
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
							if(!preg_match("/[a-zA-Z]/", $line)){//sat�r i�i harf i�ermiyorsa, distance de�erleri ise
								
								$mega['Data'][$sekans_sayisi+1]['SeqData']['dataString1']=trim($line);//mega dosyas�nda ilk bireyin verisi olmad���ndan sonraki bireyin isminden distance verilerini eklemeye ba�lar�z.
								$sekans_sayisi++;
							}
						}
					}
				}
				else//distance veri tipi de�ilse
				{
					if($specify_format_of_data=='sequential'){//sekans format� ise(noninterleaved)
					
						if(preg_match('/^#/i',$line) && $sira!==0)//diez i�areti (#) ile ba�l�yorsa ve ilk sat�r de�ilse
						{
							$new_individual=true;//data ba�layacak
							array_push($mega['Data'],array(
								'SeqName'=>'',
								'SeqData'=>array(
									'dataString1'=>'',
									'dataString2'=>'',
								),
							));
							$sekans_sayisi++;
							if(preg_match('/\\s/',$line)){//birey ismi ile ayn� sat�rda sekans verisi ba�l�yorsa, sat�r i�inde whitespace karakter varsa 
								$lineArray 			= preg_split ("/[\s]+/", $line,2);//sat�r� ilk whitespace karakterden 2 par�aya b�l�yoruz
								$individual_name	=ltrim($lineArray[0],'#');
								$individual_data 	= preg_replace('/\s++/', '', $lineArray[1]);
								$mega['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
								$mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
								
							}else{//okunan sat�rda sadece birey ad� varsa
								$individual_name=ltrim($line,'#');
								$mega['Data'][$sekans_sayisi-1]['SeqName']=$individual_name;
							}
							
						}
						if(!preg_match('/^#/i',$line) && $new_individual==true)//okunan sat�r diez (#) i�areti ile ba�lam�yor ve data ba�lam��sa
						{
							$individual_data = preg_replace('/\s++/', '', $line);
							$mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$individual_data;
						}
					}else{//interleaved format� ise
						if(preg_match('/^#/i',$line) && $sira!==0)//diez i�areti (#) ile ba�l�yorsa ve ilk sat�r de�ilse
						{
							if(preg_match('/\\s/',$line)){//birey ismi ile ayn� sat�rda sekans verisi ba�l�yorsa, sat�r i�inde whitespace karakter varsa 
								$lineArray 			= preg_split ("/[\s]+/", $line,2);//sat�r� ilk whitespace karakterden 2 par�aya b�l�yoruz
								$individual_name=ltrim($lineArray[0],'#');//�lk par�an�n ba��ndaki diez (#) i�aretini temizle ve birey ismi olarak ata
								$individual_data = preg_replace('/\s++/', '', $lineArray[1]);//�kinci par�ada ki t�m bo�luklar� sil ve sekans verisi olarak ata
							}
							
							if (in_array($individual_name, $birey_isimleri))//Interleaved formatta daha �nce ayn� bireyin sekans verisi varsa
							{
								$key = array_search($individual_name, $birey_isimleri);//daha �nceki bireyin dizideki s�ras� bulunacak
								$mega['Data'][$key]['SeqData']['dataString1'].=$individual_data;//�nceki sekans verisine ekleme yap�lacak
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
					//En uzun sekans�n karakter say�s�
					if(strlen($mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1'])>$mega['header']['maxSeqLength']){
						$mega['header']['maxSeqLength']=strlen($mega['Data'][$sekans_sayisi-1]['SeqData']['dataString1']);
					}
					//En uzun birey isminin uzunlu�u
					if(strlen($mega['Data'][$sekans_sayisi-1]['SeqName'])>$mega['header']['maxSeqNameLength']){
						$mega['header']['maxSeqNameLength']=strlen($mega['Data'][$sekans_sayisi-1]['SeqName']);
					}
				}
			}
		}
		if($dataType!=='distance'){
			/*
			*Noktal� olan verileri ilk dizi olan referans dizisine g�re tekrar d�zenleyece�iz.
			*/
			$referans	=str_split($mega['Data'][0]['SeqData']['dataString1']);//Dizinin ilk referans eleman� harflere par�alan�r.
			for($i=1;$i<$sekans_sayisi;$i++){
				
				$degisecek	=str_split($mega['Data'][$i]['SeqData']['dataString1']);
				foreach($degisecek as $key=>$value){
					if($value==$matching_symbol){
						$degisecek[$key]=$referans[$key];
						//echo $referans[$key];
					}
				}
				$mega['Data'][$i]['SeqData']['dataString1']=implode('',$degisecek);//implode ile dizideki elemanlar� birle�tirip string elde ederiz.
			}
		}
		
		return $mega;
	}
}