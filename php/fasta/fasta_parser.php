<?php
//include ('../app.php');
include_once "../app.php";//başka dosyalarda include bu şekilde olur

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
        * Dosyadan satır satır okumaya başlayacak 
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
				/*	Okunan satır (>gi) ifadesi ile başlıyorsa	*/
				if(preg_match('/^>gi/i',$line))
				{
					$identifier		=	$line_explode[3];
				}
				/*	Okunan satır (>gnl) ifadesi ile başlıyorsa	*/
				else if(preg_match('/^>gnl/i',$line)){
					$identifier		=	$line_explode[2];
				}
				/*	Okunan satır sadece (>gi) ve (>gnl) değilde sadece büyüktür(>) ifadesi ile başlıyorsa	*/
				else{
					/*	Parçalara ayrılan satırın ilk parçasını, identifier'e atayacak	*/
					/*	satırı büyüktür (>) işaretinden temizlemek için ilk karakteri silecek	*/
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
				//yorum satırı hiçbir işlem yapılmayacak
			}else{
				//Sağ ve solda ki boşlukları silecek ve bütün satır büyük harfe çevrilecek
				$line	=strtoupper(trim($line));
				$line	=	preg_replace("/\d/", "", $line);//rakamları sil
				$line	=	preg_replace("/N/i", "?", $line);//N değerini ? ile değiştir
				$line	=	preg_replace('/\s++/', '', $line);//tüm boşlukları sil
				//Data tipi SNP ise
				if($dataType=="snp"){
					//Ploidy değeri diploid ise
					if($ploidy_of_the_data=='diploid'){
						
						$dataString1="";
						$dataString2="";
						$dataString=""; 
						$line_array=str_split($line);//string değeri harflerine bölecek
						foreach($line_array as $la){
							$app = new App();
							$dataString1.= $app->getAmbiquityBase($la)[0];
							$dataString2.= $app->getAmbiquityBase($la)[1];
							$dataString.= $app->getAmbiquityBase($la)[2];
						}
						//SNP verilerinin aralarına virgül koyarak string halinde diğer formatlara gönderiyoruz.
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=implode(',',str_split($dataString));//SNP ve Diploid ise 
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString1'].=implode(',',str_split($dataString1));//SNP ve Diploid ise 
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString2'].=implode(',',str_split($dataString2));//SNP ve Diploid ise 
					}else if($ploidy_of_the_data=='haploid'){//ploidy değeri haploid ise
						//SNP verilerinin aralarına virgül koyarak string halinde diğer formatlara gönderiyoruz.
						$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=implode(',',str_split($line));// SNP ve haploid ise sekans burası
					}
				}else{//Data tipi SNP değilse
					$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'].=$line;// SNP değilse sekans burası
				}
				//En uzun sekansın karakter sayısı
					if($dataType=='snp'){
						if(count(explode(',',$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']))>$fasta['header']['maxSeqLength']){
							$fasta['header']['maxSeqLength']=count(explode(',',$fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']));
						}
					}else{
						if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString'])>$fasta['header']['maxSeqLength']){
							$fasta['header']['maxSeqLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqData']['dataString']);
						}
					}
				//En uzun birey isminin uzunluğu
				if(strlen($fasta['Data'][$sekans_sayisi-1]['SeqName'])>$fasta['header']['maxSeqNameLength']){
					$fasta['header']['maxSeqNameLength']=strlen($fasta['Data'][$sekans_sayisi-1]['SeqName']);
				}
			}
		}
		
		return $fasta;
	}
}