<?php
Class structure_parser
{
    public function parser(
		$file_name,
		$dataType,
		$ploidy_of_the_data,
		$missing_data_value_code,
		$marker_names_included,
		$individual_name_included,
		$how_microsat_coded,
		$repeatSize,
		$number_of_markers_in_the_input_file,
		$popdata_present
	)
	{
		$okunan_satir=0;
		$birey_sayisi=0;
		$consecutive_row=1;//diploid_on_two_consecutive_row verilerde kullanılacak
		$structure=array(
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
		$file=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$file_name;
        $okunan_dosya=file($file);
		/*
		*	Eğer input dosyası içinde lokus isimleri yok seçilmişse program, lokus sayısına göre otomatik isim atayacak.
		*/
		if($marker_names_included=='no'){
			for($i=0;$i<$number_of_markers_in_the_input_file;$i++){
				array_push($structure['header']['LociList'],'Locus_'.($i+1));
			}
		}
        /**
        * Dosyadan satır satır okumaya başlayacak 
        */
        foreach($okunan_dosya as $sira => $line)
		{
			$line=trim($line);
			if(!empty($line)){
				/**
				* İlk satırda lokus isimleri yer alırsa
				*/
				if($okunan_satir==0 && $marker_names_included=='yes'){
					$lociArray=preg_split('/[\s]+/',$line);
					foreach($lociArray as $i=>$oneLocus){
						array_push($structure['header']['LociList'],$oneLocus);
					}
				}
				else
				{
					
					if($ploidy_of_the_data=='haploid'){
						/**
						* İlk satırdan sonraki satırlar genotip veriler içerir.
						*/
						$lineArray=preg_split('/[\s]+/',$line);
						array_push($structure['Data'],array(
							'PopName'=>'',
							'IndividualName'=>'',
							'PopData'=>array(
								'dataArray1'=>[],
								'dataArray2'=>[],
							),
						));
						if($individual_name_included=="yes" && $popdata_present=="yes"){
							$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
							$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[1]);
							$genotipik_data=array_slice($lineArray,2);
						}else if($individual_name_included=="no" && $popdata_present=="yes"){
							$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
							$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[0]);
							$genotipik_data=array_slice($lineArray,1);
						}else if($individual_name_included=="yes" && $popdata_present=="no"){
							$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
							$structure['Data'][$birey_sayisi]['PopName']="1";
							$genotipik_data=array_slice($lineArray,1);
						}else if($individual_name_included=="no" && $popdata_present=="no"){
							$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
							$structure['Data'][$birey_sayisi]['PopName']="1";
							$genotipik_data=array_slice($lineArray,0);
						}
						
						//En uzun birey isminin uzunluğu-start
						if(strlen($structure['Data'][$birey_sayisi]['IndividualName'])>$structure['header']['max_individual_name_length']){
							$structure['header']['max_individual_name_length']=strlen($structure['Data'][$birey_sayisi]['IndividualName']);
						}
						//En uzun birey isminin uzunluğu-end
						
						/*PopNameList adında bir dizi içine Popülasyon adları  eğer daha önceden eklenmemişse burada eklenecek */
						if (!in_array($structure['Data'][$birey_sayisi]['PopName'], $structure['header']['PopNameList']))
						{
							array_push($structure['header']['PopNameList'],$structure['Data'][$birey_sayisi]['PopName']);
						}
						
						//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-start
						if(count($structure['header']['LociList'])!==(count($genotipik_data))){
							array_push($structure['header']['errors'],'loci numbers are not correspond in your input file, line: '.($sira+1));
						}
						//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-end
						
						$structure['Data'][$birey_sayisi]['PopData']['dataArray1']=array_merge($structure['Data'][$birey_sayisi]['PopData']['dataArray1'],$genotipik_data);
						$birey_sayisi++;
						
					}else if($ploidy_of_the_data=='diploid_on_one_row'){
						$lineArray=preg_split('/[\s]+/',$line);
						array_push($structure['Data'],array(
							'PopName'=>'',
							'IndividualName'=>'',
							'PopData'=>array(
								'dataArray1'=>[],
								'dataArray2'=>[],
							),
						));
						if($individual_name_included=="yes" && $popdata_present=="yes"){
							$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
							$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[1]);
							$genotipik_data=array_slice($lineArray,2);
						}else if($individual_name_included=="no" && $popdata_present=="yes"){
							$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
							$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[0]);
							$genotipik_data=array_slice($lineArray,1);
						}else if($individual_name_included=="yes" && $popdata_present=="no"){
							$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
							$structure['Data'][$birey_sayisi]['PopName']="1";
							$genotipik_data=array_slice($lineArray,1);
						}else if($individual_name_included=="no" && $popdata_present=="no"){
							$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
							$structure['Data'][$birey_sayisi]['PopName']="1";
							$genotipik_data=array_slice($lineArray,0);
						}
						
						//En uzun birey isminin uzunluğu-start
						if(strlen($structure['Data'][$birey_sayisi]['IndividualName'])>$structure['header']['max_individual_name_length']){
							$structure['header']['max_individual_name_length']=strlen($structure['Data'][$birey_sayisi]['IndividualName']);
						}
						//En uzun birey isminin uzunluğu-end
						
						/*PopNameList adında bir dizi içine Popülasyon adları  eğer daha önceden eklenmemişse burada eklenecek */
						if (!in_array($structure['Data'][$birey_sayisi]['PopName'], $structure['header']['PopNameList']))
						{
							array_push($structure['header']['PopNameList'],$structure['Data'][$birey_sayisi]['PopName']);
						}
						
						//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-start
						/*if(count($structure['header']['LociList'])!==(count($genotipik_data))){
							array_push($structure['header']['errors'],'loci numbers are not correspond in your input file, line: '.($sira+1));
						}*/
						//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-end
						foreach($genotipik_data as $g=>$gd){
							if(($g%2)==0){
								array_push($structure['Data'][$birey_sayisi]['PopData']['dataArray1'],$gd);
							}else{
								array_push($structure['Data'][$birey_sayisi]['PopData']['dataArray2'],$gd);
							}
						}
						$birey_sayisi++;
					}else if($ploidy_of_the_data=='diploid_on_two_consecutive_row'){
						$lineArray=preg_split('/[\s]+/',$line);
						if($consecutive_row==1){
							$lineArray=preg_split('/[\s]+/',$line);
							array_push($structure['Data'],array(
								'PopName'=>'',
								'IndividualName'=>'',
								'PopData'=>array(
									'dataArray1'=>[],
									'dataArray2'=>[],
								),
							));
							if($individual_name_included=="yes" && $popdata_present=="yes"){
								$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
								$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[1]);
								$genotipik_data=array_slice($lineArray,2);
							}else if($individual_name_included=="no" && $popdata_present=="yes"){
								$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
								$structure['Data'][$birey_sayisi]['PopName']=trim($lineArray[0]);
								$genotipik_data=array_slice($lineArray,1);
							}else if($individual_name_included=="yes" && $popdata_present=="no"){
								$structure['Data'][$birey_sayisi]['IndividualName']=trim($lineArray[0]);
								$structure['Data'][$birey_sayisi]['PopName']="1";
								$genotipik_data=array_slice($lineArray,1);
							}else if($individual_name_included=="no" && $popdata_present=="no"){
								$structure['Data'][$birey_sayisi]['IndividualName']="ind_".($birey_sayisi+1);
								$structure['Data'][$birey_sayisi]['PopName']="1";
								$genotipik_data=array_slice($lineArray,0);
							}
							
							//En uzun birey isminin uzunluğu-start
							if(strlen($structure['Data'][$birey_sayisi]['IndividualName'])>$structure['header']['max_individual_name_length']){
								$structure['header']['max_individual_name_length']=strlen($structure['Data'][$birey_sayisi]['IndividualName']);
							}
							//En uzun birey isminin uzunluğu-end
							
							
							/*PopNameList adında bir dizi içine Popülasyon adları  eğer daha önceden eklenmemişse burada eklenecek */
							if (!in_array($structure['Data'][$birey_sayisi]['PopName'], $structure['header']['PopNameList']))
							{
								array_push($structure['header']['PopNameList'],$structure['Data'][$birey_sayisi]['PopName']);
							}
							
							//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-start
							if(count($structure['header']['LociList'])!==(count($genotipik_data))){
								array_push($structure['header']['errors'],'loci numbers are not correspond in your input file, line: '.($sira+1));
							}
							//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-end
							$structure['Data'][$birey_sayisi]['PopData']['dataArray1']=array_merge($structure['Data'][$birey_sayisi]['PopData']['dataArray1'],$genotipik_data);
							$consecutive_row=2;//diploid verinin ikinci satırını okumaya geç
						}else if($consecutive_row==2){
							$lineArray=preg_split('/[\s]+/',$line);
							if($individual_name_included=="yes" && $popdata_present=="yes"){
								$genotipik_data=array_slice($lineArray,2);
							}else if($individual_name_included=="no" && $popdata_present=="yes"){
								$genotipik_data=array_slice($lineArray,1);
							}else if($individual_name_included=="yes" && $popdata_present=="no"){
								$genotipik_data=array_slice($lineArray,1);
							}else if($individual_name_included=="no" && $popdata_present=="no"){
								$genotipik_data=array_slice($lineArray,0);
							}
							//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-start
							if(count($structure['header']['LociList'])!==(count($genotipik_data))){
								array_push($structure['header']['errors'],'loci numbers are not correspond in your input file, line: '.($sira+1));
							}
							//verilen lokus sayısı ile dosyada ki lokus sayısı eşit değil ise-end
							$structure['Data'][$birey_sayisi]['PopData']['dataArray2']=array_merge($structure['Data'][$birey_sayisi]['PopData']['dataArray2'],$genotipik_data);
							$birey_sayisi++;
							$consecutive_row=1;//diploid verinin ilk satırını okumaya geç
						}
					}
					
				}
			$okunan_satir++;
			}
		}
		return $structure;
	}
}