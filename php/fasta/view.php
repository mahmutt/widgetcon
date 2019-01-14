<?php
		include '../app.php';
		$app=new app();
		$file_name			='aaa.fasta';
		$populasyon_sayisi	=0;
		$identifier			='';
		$ploidy_of_the_data	='haploid';//haploid,diploid
		$dataType			='snp';//snp
		
		
		
		$sekans_sayisi	=0;
		$fasta=array(
            'header'=>array(
                'Title'=>$file_name,#"any string within double quotes",
                'DataType'=>$dataType,#DNA, RNA, PROTEIN, SNP
                'ploidy'=>$ploidy_of_the_data,
                'gap'=>'-',
                'missingData'=>'?',
                'gameticPhase'=>'unknown',
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
			if(preg_match('/^>/i',$line))
			{
				/*	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-  \
				|	GenBank 					|	“gi”|gi-number|”gb” |accession|locus 	|
				|	EMBL Data Library 			|	“gi”|gi-number|”emb”|accession|locus	| 
				|	DDBJ, DNA Database of Japan |	“gi”|gi-number|”dbj”|accession|locus	|
				|	General database identifier |	“gnl”|database|identifier           	|
				|	“simply” 					|	identifier                          	|
				\	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-   */
				$line_explode	=	explode("|",trim($line));
				/*	Okunan satýr (>gi) ifadesi ile baþlýyorsa	*/
				if(preg_match('/^>gi/i',$line))
				{
					$identifier		=	$line_explode[3];
				}
				/*	Okunan satýr (>gnl) ifadesi ile baþlýyorsa	*/
				else if(preg_match('/^>gnl/i',$line)){
					$identifier		=	$line_explode[2];
				}
				/*	Okunan satýr sadece (>gi) ve (>gnl) deðilde sadece büyüktür(>) ifadesi ile baþlýyorsa	*/
				else{
					/*	Parçalara ayrýlan satýrýn ilk parçasýný, identifier'e atayacak	*/
					/*	satýrý büyüktür (>) iþaretinden temizlemek için ilk karakteri silecek	*/
					$identifier=ltrim($line_explode[0],'>');
				}
				array_push($fasta['Data'],array(
					'SeqName'=>$identifier,
					'SeqData'=>array(
						'dataString1'=>'',
						'dataString2'=>'',
					),
				));
				$sekans_sayisi++;
				
			}else if(preg_match('/^;/',$line)){
				//yorum satýrý hiçbir iþlem yapýlmayacak
			}else{
				//Sað ve solda ki boþluklarý silecek ve bütün satýr büyük harfe çevrilecek
				$line=strtoupper(trim($line));
				//Data tipi SNP ise
				if($dataType=="snp"){
					//Ploidy deðeri diploid ise
					if($ploidy_of_the_data=='diploid'){
						$line	=	preg_replace("/\d/", "", $line);//rakamlarý sil
						$line	=	preg_replace("/N/i", "?", $line);//N deðerini ? ile deðiþtir
						$line	=	preg_replace('/\s++/', '', $line);//tüm boþluklarý sil
						
						$line_array=str_split($line);//string deðeri harflerine bölecek
						foreach($line_array as $la){
							$app = new App();
							$dataSrting1.= $app->getAmbiquityBase($la)[0];
							$dataSrting2.= $app->getAmbiquityBase($la)[1];
						}
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$dataSrting1;//SNP ve Diploid ise 
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString2'].=$dataSrting2;//SNP ve Diploid ise 
					}else if($ploidy_of_the_data=='haploid'){//ploidy deðeri haploid ise
						$line	=	preg_replace("/\d/", "", $line);//rakamlarý sil
						$line	=	preg_replace('/\s++/', '', $line);//tüm boþluklarý sil
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$line;// SNP ve haploid ise sekans burasý
					}
				}else{//Data tipi SNP deðilse
					$line	=	preg_replace("/\d/", "", $line);//rakamlarý sil
					$line	=	preg_replace("/N/i", "?", $line);//N deðerini ? ile deðiþtir
					$line	=	preg_replace('/\s++/', '', $line);//tüm boþluklarý sil
					$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=$line;// SNP deðilse sekans burasý
				}
				//En uzun sekansýn karakter sayýsý
				if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'])>$fasta['header']['maxSeqLength']){
					$fasta['header']['maxSeqLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1']);
				}
				//En uzun birey isminin uzunluðu
				if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqName'])>$fasta['header']['maxSeqNameLength']){
					$fasta['header']['maxSeqNameLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqName']);
				}
			}
		}
		var_dump($fasta);
		?>
		
