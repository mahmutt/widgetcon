<?php
Class arlequin_parser
{
    public function parser($file_name,$data_read,$dataType)
    {
        $samples=0;
        $dataAppend=false;
        $arlequin=array(
            'header'=>array(
                'Title'=>'default title',#"any string within double quotes",
                'NbSamples'=>'',#1-1000 any number
                'DataType'=>'',#MICROSAT,DNA,RFLP,STANDART,FREQUENY
                'GenotypicData'=>'',#1 or 0
                'LocusSeparator'=>'',#WHITESPACE,TAB,NONE
                'MissingData'=>'?',#?
                'GameticPhase'=>'',#0 or 1
                'RecessiveData'=>'',#0 or 1
                'RecessiveAllele'=>'',#xxx
                'LocusSize'=>'',#xxx
                'maxIndividualNameLength'=>'0',#xxx
            ),
            'Data'=>array(
                /*array(
                    'SampleName'=>'pop_82',
                    'SampleSize'=>24,
                    'SampleData'=>array(
                        array(
                            'individual'=>'995',
                            'data'=>array(
                                'dataString1'=>'q',
                                'dataString2'=>'q2'
                            ),
                        ),
                        array(
                            'individual'=>'996',
                            'data'=>array(
                                'dataString1'=>'w',
                                'dataString2'=>'w2'
                            ),
                        )

                    ),
                ),
                array(
                    'SampleName'=>'pop_82',
                    'SampleSize'=>24,
                    'SampleData'=>array(
                        array(
                            'individual'=>'995',
                            'data'=>array(
                                'dataString1'=>'q',
                                'dataString2'=>'q2'
                            ),
                        ),
                        array(
                            'individual'=>'996',
                            'data'=>array(
                                'dataString1'=>'w',
                                'dataString2'=>'w2'
                            ),
                        )

                    ),
                ),
                 .........
                 */
            ),
        );

        
        $file=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name;
        $okunan_dosya=file($file);
        /**
        * Dosyadan satır satır okumaya başlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
        {
            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır Title kelimesi ile başlıyorsa 
            */
            if(preg_match('/^Title/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $Titlearray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->Title nesnesine atanır 
                */
                $arlequin['header']['Title']=preg_replace("/\"/","",$Titlearray[1]);
            }


            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır NbSamples kelimesi ile başlıyorsa 
            */
            if(preg_match('/^NbSamples/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $NbSamplesArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->NbSamples nesnesine atanır 
                */
                $arlequin['header']['NbSamples']=preg_replace("/\"/","",$NbSamplesArray[1]);
            }


            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır DataType kelimesi ile başlıyorsa 
            */
            if(preg_match('/^DataType/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $DataTypeArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->DataType nesnesine atanır 
                */
                $arlequin['header']['DataType']=preg_replace("/\"/","",$DataTypeArray[1]);
            }


            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır GenotypicData kelimesi ile başlıyorsa 
            */
            if(preg_match('/^GenotypicData/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $GenotypicDataArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->GenotypicData nesnesine atanır 
                */
                $arlequin['header']['GenotypicData']=preg_replace("/\"/","",$GenotypicDataArray[1]);
            }


            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır LocusSeparator kelimesi ile başlıyorsa 
            */
            if(preg_match('/^LocusSeparator/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $LocusSeparatorArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->LocusSeparator nesnesine atanır 
                */
                $arlequin['header']['LocusSeparator']=preg_replace("/\"/","",$LocusSeparatorArray[1]);
            }



            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır MissingData kelimesi ile başlıyorsa 
            */
            if(preg_match('/^MissingData/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $MissingDataArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->MissingData nesnesine atanır 
                */
                $arlequin['header']['MissingData']=preg_replace("/\"/","",$MissingDataArray[1]);
            }



            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır GameticPhase kelimesi ile başlıyorsa 
            */
            if(preg_match('/^GameticPhase/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $GameticPhaseArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->GameticPhase nesnesine atanır 
                */
                $arlequin['header']['GameticPhase']=preg_replace("/\"/","",$GameticPhaseArray[1]);
            }


            /**
            * Satırın($line) başından ve sonundan boşlukları sildikten sonra
            * satır RecessiveData kelimesi ile başlıyorsa 
            */
            if(preg_match('/^RecessiveData/i',trim($line))){
                /**
                * Satır($line) "=" işareti içeriyorsa
                */
                if(preg_match("/=/", $line))
                {
                    /**
                    * Satır($line) "=" işareti ile parçalanarak diziye atılır.
                    */
                    $RecessiveDataArray=array_map('trim',explode('=',$line));
                }
                /**
                * Eşitliğin sağ tarafı tırnaklardan temizlenerek 
                * $object->header->RecessiveData nesnesine atanır 
                */
                $arlequin['header']['RecessiveData']=preg_replace("/\"/","",$RecessiveDataArray[1]);
            }
            
			/**
			* $data_read=='read' datalar da okuyacak
			*/
			if($data_read=='read'){
				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır [[Samples]] kelimesi ile başlıyorsa 
				*/
				/*
				if(preg_match('/\[\[Samples\]\]/i',trim($line))){
					#
				}
				*/
				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır SampleName kelimesi ile başlıyorsa 
				*/
				if(preg_match('/^SampleName/i',trim($line))){
					
					array_push($arlequin['Data'],array(
						'SampleName'=>'',
						'SampleSize'=>'',
						'SampleData'=>array(),
					));
					$samples++;
					/**
					* Satır($line) "=" işareti içeriyorsa
					*/
					if(preg_match("/=/", $line))
					{
						/**
						* Satır($line) "=" işareti ile parçalanarak diziye atılır.
						*/
						$SampleNameArray=array_map('trim',explode('=',$line));
					}
					/**
					* Eşitliğin sağ tarafı tırnaklardan temizlenerek 
					* $SampleName değişkenine atanır 
					*/
					$SampleName= preg_replace("/\"/","",$SampleNameArray[1]);
					$arlequin['Data'][$samples-1]['SampleName']=$SampleName;

				}


				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır SampleSize kelimesi ile başlıyorsa 
				*/
				if(preg_match('/^SampleSize/i',trim($line))){
					/**
					* Satır($line) "=" işareti içeriyorsa
					*/
					if(preg_match("/=/", $line))
					{
						/**
						* Satır($line) "=" işareti ile parçalanarak diziye atılır.
						*/
						$SampleSizeArray=array_map('trim',explode('=',$line));
					}
					/**
					* Eşitliğin sağ tarafı tırnaklardan temizlenerek 
					* $SampleSize değişkenine atanır 
					*/
					$SampleSize= preg_replace("/\"/","",$SampleSizeArray[1]);
					$arlequin['Data'][$samples-1]['SampleSize']=$SampleSize;
				}


				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır SampleData kelimesi ile başlıyorsa  ve "{" işareti ile bitiyorsa
				*/
				if(preg_match('/^SampleData/i',trim($line)) && preg_match('/\{$/i',trim($line))){
					/**
					* "SampleData = {" satırından sonra Data Bilgileri okunmaya başlanacak
					*/
					$dataAppend=true;
					$dataSatirNo=0;
					$bireyNo=0;
				}
				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır  "{" işareti ile başlıyor ve bitiyorsa
				*/
				if(preg_match('/^\}$/i',trim($line)))
				{
					/**
					* "}" işareti ile Data Bilgilerinin okunması bitti
					*/
					$dataAppend=false;
					$dataSatirNo=0;
					$bireyNo=0;
				}
				/**
				* Satırın($line) başından ve sonundan boşlukları sildikten sonra
				* satır SampleData kelimesi ile başlamıyor  , "{" işareti ile bitmiyorsa ve dataAppend true ise
				*/
				if($dataAppend==true && !preg_match('/^SampleData/i',trim($line)) && !preg_match('/\{$/i',trim($line)))
				{
				   /**
					* Data Bilgileri okunuyor
					* GenotypicData==1 olduğu için 1 bireyin ard arda iki satırda bilgileri var
					*/

					if($arlequin['header']['GenotypicData']==1)
					{
						/**
						* Birey için ilk satır ise
						*/

						if($dataSatirNo%2==0)
						{
							
							if(!empty(trim($line))){
								
								/**
								* bütün boşluk türlerini, tek ya da daha fazla boşlukları tek boşluğa çevir
								* başından ve sonundan trim() fonksiyonu ile boşlukları temizle 
								* boşluktan parçalayıp diziye aktar 
								*/
								$dataList=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
								/**
								* Data Bilgilerinin ilk satırından ilk 2 elemanı sırasıyla 
								* individual nesnelerine ekler
								*/
								####KIRMIZI###
							   // break;
								for($i=0;$i<$dataList[1];$i++){
									array_push($arlequin['Data'][$samples-1]['SampleData'],array(
										'individual'=>'',
										'data'=>array(
											'dataString1'=>'',
											'dataString2'=>''
										),
									));

									###KIRMIZI###
									if($i==0){
										$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']=$dataList[0];
									}else{
										$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']=$dataList[0].'_'.$i;
									}
									
									if(strlen($arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual'])>$arlequin['header']['maxIndividualNameLength']){
										$arlequin['header']['maxIndividualNameLength']=strlen($arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']);
									}
									/**
									* Data Bilgilerinin ilk satırından ilk 2 elemanı siler ve object nesnesine ekler
									*/
									
									if($arlequin['header']['LocusSeparator']=="NONE"){
										$once	=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
										$sonra  =array_slice($once, 2);
										$data   =str_split(implode('',$sonra));
									}else{//NONE DEĞİLSE
										$once	=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
										$data   =array_slice($once, 2);
									}
									$arlequin['header']['LocusSize']=count($data);
									$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['data']['dataString1']=$data;
									//break;
								}
							}

						}
						/**
						* Birey için ikinci satır ise
						*/
						else
						{
							if(!empty(trim($line))){
								/**
								* bütün boşluk türlerini, tek ya da daha fazla boşlukları tek boşluğa çevir
								* başından ve sonundan trim() fonksiyonu ile boşlukları temizle 
								* boşluktan parçalayıp diziye aktar 
								*/
								
								if($arlequin['header']['LocusSeparator']=="NONE"){
									$dataList   =str_split(preg_replace('/\s++/', '', trim($line)));
								}else{//NONE DEĞİLSE
									$dataList	=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
								}
								$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['data']['dataString2']=$dataList;
								$bireyNo++;
							}
						}
						$dataSatirNo++;
					}
					else //GenotypicData=0
					{
						if(!empty(trim($line))){
							/**
							* bütün boşluk türlerini, tek ya da daha fazla boşlukları tek boşluğa çevir
							* başından ve sonundan trim() fonksiyonu ile boşlukları temizle 
							* boşluktan parçalayıp diziye aktar 
							*/
							$dataList=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
							
							/**
							* Data Bilgilerinin ilk satırından ilk 2 elemanı sırasıyla 
							* individual  nesnelerine ekler
							*/
							####KIRMIZI###
						   // break;
						   
						   for($i=0;$i<$dataList[1];$i++){
								array_push($arlequin['Data'][$samples-1]['SampleData'],array(
									'individual'=>'',
									'data'=>array(
										'dataString1'=>'',
									),
								));
								###KIRMIZI###
								if($i==0){
									$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']=$dataList[0];
								}else{
									$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']=$dataList[0].'_'.$i;
								}
								
								if(strlen($arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual'])>$arlequin['header']['maxIndividualNameLength']){
									$arlequin['header']['maxIndividualNameLength']=strlen($arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['individual']);
								}
								if($arlequin['header']['LocusSeparator']=="NONE"){
									$once	=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
									$sonra  =array_slice($once, 2);
									$data   =str_split(implode('',$sonra));
								}else{//NONE DEĞİLSE
									$once	=explode(' ',preg_replace('/\s++/', ' ', trim($line)));
									$data   =array_slice($once, 2);
								}
								$arlequin['header']['LocusSize']=count($data);
								$arlequin['Data'][$samples-1]['SampleData'][$bireyNo]['data']['dataString1']=$data;
								$bireyNo++;
								//break;
						   }
						}
					}
				}
			}
        }
        return $arlequin;
    }
}