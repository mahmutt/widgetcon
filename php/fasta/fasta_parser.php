<?php
//include ('../app.php');
include_once "../app.php";//ba�ka dosyalarda include bu �ekilde olur

Class fasta_parser
{
    public function parser($file_name,$dataType,$ploidy_of_the_data)
	{
		$sekans_sayisi	=0;
		$identifier		='';
		$fasta=array(
            'header'=>array(
                'Title'=>'',#"any string within double quotes",
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
						'dataString'=>'q',
						'dataString1'=>'q',
						'dataString2'=>'q',
                    ),
                ),
                array(
                    'SeqName'=>'name_82',
                    'SeqData'=>array(
						'dataString'=>'q',
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
			if(preg_match('/^>/i',$line))
			{
				/*	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-  \
				|	GenBank 					|	�gi�|gi-number|�gb� |accession|locus 	|
				|	EMBL Data Library 			|	�gi�|gi-number|�emb�|accession|locus	| 
				|	DDBJ, DNA Database of Japan |	�gi�|gi-number|�dbj�|accession|locus	|
				|	General database identifier |	�gnl�|database|identifier           	|
				|	�simply� 					|	identifier                          	|
				\	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-	-   */
				$line_explode	=	explode("|",trim($line));
				/*	Okunan sat�r (>gi) ifadesi ile ba�l�yorsa	*/
				if(preg_match('/^>gi/i',$line))
				{
					$identifier		=	$line_explode[3];
				}
				/*	Okunan sat�r (>gnl) ifadesi ile ba�l�yorsa	*/
				else if(preg_match('/^>gnl/i',$line)){
					$identifier		=	$line_explode[2];
				}
				/*	Okunan sat�r sadece (>gi) ve (>gnl) de�ilde sadece b�y�kt�r(>) ifadesi ile ba�l�yorsa	*/
				else{
					/*	Par�alara ayr�lan sat�r�n ilk par�as�n�, identifier'e atayacak	*/
					/*	sat�r� b�y�kt�r (>) i�aretinden temizlemek i�in ilk karakteri silecek	*/
					$identifier=ltrim($line_explode[0],'>');
				}
				array_push($fasta['Data'],array(
					'SeqName'=>$identifier,
					'SeqData'=>array(
						'dataString'=>'',
						'dataString1'=>'',
						'dataString2'=>'',
					),
				));
				$sekans_sayisi++;
				
			}else if(preg_match('/^;/',$line)){
				//yorum sat�r� hi�bir i�lem yap�lmayacak
			}else{
				//Sa� ve solda ki bo�luklar� silecek ve b�t�n sat�r b�y�k harfe �evrilecek
				$line	=strtoupper(trim($line));
				$line	=	preg_replace("/\d/", "", $line);//rakamlar� sil
				$line	=	preg_replace("/N/i", "?", $line);//N de�erini ? ile de�i�tir
				$line	=	preg_replace('/\s++/', '', $line);//t�m bo�luklar� sil
				//Data tipi SNP ise
				if($dataType=="snp"){
					//Ploidy de�eri diploid ise
					if($ploidy_of_the_data=='diploid'){
						
						$dataString1="";
						$dataString2="";
						$dataString=""; 
						$line_array=str_split($line);//string de�eri harflerine b�lecek
						foreach($line_array as $la){
							$app = new App();
							$dataString1.= $app->getAmbiquityBase($la)[0];
							$dataString2.= $app->getAmbiquityBase($la)[1];
							$dataString.= $app->getAmbiquityBase($la)[2];
						}
						//SNP verilerinin aralar�na virg�l koyarak string halinde di�er formatlara g�nderiyoruz.
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=implode(',',str_split($dataString));//SNP ve Diploid ise 
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=implode(',',str_split($dataString1));//SNP ve Diploid ise 
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString2'].=implode(',',str_split($dataString2));//SNP ve Diploid ise 
					}else if($ploidy_of_the_data=='haploid'){//ploidy de�eri haploid ise
						//SNP verilerinin aralar�na virg�l koyarak string halinde di�er formatlara g�nderiyoruz.
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=implode(',',str_split($line));// SNP ve haploid ise sekans buras�
					}
				}else{//Data tipi SNP de�ilse
					$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=$line;// SNP de�ilse sekans buras�
				}
				//En uzun sekans�n karakter say�s�
					if($dataType=='snp'){
						if(count(explode(',',$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']))>$fasta['header']['maxSeqLength']){
							$fasta['header']['maxSeqLength']=count(explode(',',$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']));
						}
					}else{
						if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'])>$fasta['header']['maxSeqLength']){
							$fasta['header']['maxSeqLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']);
						}
					}
				//En uzun birey isminin uzunlu�u
				if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqName'])>$fasta['header']['maxSeqNameLength']){
					$fasta['header']['maxSeqNameLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqName']);
				}
			}
		}
		
		return $fasta;
	}
}