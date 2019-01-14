<?php 
Class app
{
    public function label($value)
	{
		if($value=='microsat'){
			return 'SSR';
		}
		elseif($value=='dna'){
			return 'DNA';
		}
		elseif($value=='snp'){
			return 'SNP';
		}else{
			return $value;
		}
	}
	public function distance($value,$maxindchar){
		$fark=$maxindchar-strlen($value);
		return $value.str_repeat(" ", $fark);//fark kadar boşluk karakteri ekler
	}
	public function mega_format_individual_name($name){//mega dosyaları yazılırken birey isimleri arasında boşluk olmasın
		return preg_replace('/\s++/', '_', trim($name));//tüm boşlukları (_) ile değiştireceğiz.
	}
	public function nexus_format_individual_name($name,$name_length){//nexus dosyaları yazılırken birey isimleri arasında boşluk olmasın
		$name=preg_replace('/\s++/', '_', trim($name));//tüm boşlukları (_) ile değiştireceğiz
		$fark=$name_length-strlen($name);
		return $name.str_repeat(" ", $fark);//fark kadar boşluk karakteri ekler
	}
	public function phylip_format_individual_name($name,$relaxed_format){
		if($relaxed_format=="no"){
			//relaxed_format no ise sekans isimlerinin ilk 10 karakteri alınacak
			$name = trim(substr($name, 0, 10));
			$fark=10-strlen($name);
			return $name.str_repeat(" ", $fark);//fark kadar boşluk karakteri ekler
		}else{
			return preg_replace('/\s++/', '_', trim($name)).str_repeat(" ", 1);//1 tane boşluk ekler
		}
	}
	public function genpop_format_convert_value($data,$missing_data_value_code,$how_microsat_coded,$repeatSize,$d){
		if($data==$missing_data_value_code){
			return str_repeat("0", 3);
		}else{
			if($how_microsat_coded=="number-of-repeats"){
				if(!empty($repeatSize)){
					$repeatSize=explode(",",$repeatSize);
					if(count($repeatSize)==1){
						$data=$data*$repeatSize[0];
					}else{
						$data=$data*$repeatSize[$d];
					}
				}
			}
			$fark=3-strlen($data);
			if($fark>0){
				return str_repeat("0", $fark).$data;
			}else{
				return $data;
			}
		}
	}
	public function genpop_format_individual_name($name,$max_individual_name_length){
		$name=preg_replace('/\,/', '_', trim($name));//tüm virgülleri (_) ile değiştireceğiz, genpop isimlerinde virgül olamaz
		$fark=$max_individual_name_length-strlen($name);
		return $name.str_repeat(" ", $fark).str_repeat(" ", 1).str_repeat(",", 1).str_repeat(" ", 1);
	}
	public function structure_format_individual_name($name){//structure dosyaları yazılırken birey isimleri arasında boşluk olmasın
		$name=preg_replace('/\s++/', '_', trim($name));//tüm boşlukları (_) ile değiştireceğiz
		return $name;
	}
	public function structure_format_loci_name($name){//structure dosyaları yazılırken lokus isimleri arasında boşluk olmasın
		$name=preg_replace('/\s++/', '_', trim($name));//tüm boşlukları (_) ile değiştireceğiz
		return $name;
	}
	public function fasta_format_convert_missing_data($data){//structure dosyaları yazılırken lokus isimleri arasında boşluk olmasın
		$data=str_replace('?', 'N', $data);//tüm soru işaretlerini (N) ile değiştireceğiz.
		return $data;
	}
	public function structure_format_convert_value($dataArray,$ploidy,$IndividualName,$PopNumber,$how_microsat_coded,$repeatSize){
		//$this->structure_format_individual_name($IndividualName).str_repeat("\t", 1).$PopNumber.str_repeat("\t", 1);
		$data='';
		if($ploidy==0){
			$data.= $this->structure_format_individual_name($IndividualName).str_repeat("\t", 1).$PopNumber.str_repeat("\t", 1);
			if(!empty($repeatSize)){
				$repeatSize=explode(",",$repeatSize);
			}
			foreach(json_decode($dataArray,true) as $key=>$value){
				if($value=="00"){
					$data.= str_repeat("-9", 1).str_repeat(" ", 2);
				}elseif($value=="000"){
					$data.= str_repeat("-9", 1).str_repeat(" ", 3);
				}
				else{
					if($how_microsat_coded=="number-of-repeats"){
						if(!empty($repeatSize)){
							if(count($repeatSize)==1){
								$data.=($value*$repeatSize[0]).str_repeat(" ", 1);
							}else{
								$data.=($value*$repeatSize[$key]).str_repeat(" ", 1);
							}
						}else{
							$data.=$value.str_repeat(" ", 1);;
						}
						
					}else{
						$data.=$value.str_repeat(" ", 1);
					}
				}
			}
			$data.= str_repeat("\r\n", 1);
		}else{
			//$data.= $this->structure_format_individual_name($IndividualName).str_repeat("\t", 1).$PopNumber.str_repeat("\t", 1);
			if(!empty($repeatSize)){
				$repeatSize=explode(",",$repeatSize);
			}
			$data1="";
			$data2="";
			foreach(json_decode($dataArray,true) as $key=>$value){
				if($value=="00"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="0000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="000000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}else{
					if(strlen($value)==2){
						
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=($value*$repeatSize[0]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}else{
									$data1.=($value*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}
							}else{
								$data1.=$value.str_repeat(" ", 1);
								$data2.="-9".str_repeat(" ", 1);
							}
							
						}else{
							$data1.=$value.str_repeat(" ", 1);
							$data2.="-9".str_repeat(" ", 1);
						}
					}elseif(strlen($value)==3){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=($value*$repeatSize[0]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}else{
									$data1.=($value*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}
							}else{
								$data1.=$value.str_repeat(" ", 1);
								$data2.="-9".str_repeat(" ", 1);
							}
							
						}else{
							$data1.=$value.str_repeat(" ", 1);
							$data2.="-9".str_repeat(" ", 1);
						}
					}elseif(strlen($value)==4){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=(substr($value, 0, 2)*$repeatSize[0]).str_repeat(" ", 1);
									$data2.=(substr($value, 2, 2)*$repeatSize[0]).str_repeat(" ", 1);
								}else{
									$data1.=(substr($value, 0, 2)*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.=(substr($value, 2, 2)*$repeatSize[$key]).str_repeat(" ", 1);
								}
							}else{
								$data1.=(substr($value, 0, 2)).str_repeat(" ", 1);
								$data2.=(substr($value, 2, 2)).str_repeat(" ", 1);
							}
							
						}else{
							$data1.=substr($value, 0, 2).str_repeat(" ", 1);
							$data2.=substr($value, 2, 2).str_repeat(" ", 1);
						}
						
					}elseif(strlen($value)==6){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=(substr($value, 0, 3)*$repeatSize[0]).str_repeat(" ", 1);
									$data2.=(substr($value, 3, 3)*$repeatSize[0]).str_repeat(" ", 1);
								}else{
									$data1.=(substr($value, 0, 3)*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.=(substr($value, 3, 3)*$repeatSize[$key]).str_repeat(" ", 1);
								}
							}else{
								$data1.=(substr($value, 0, 3)).str_repeat(" ", 1);
								$data2.=(substr($value, 3, 3)).str_repeat(" ", 1);
							}
							
						}else{
							$data1.=substr($value, 0, 3).str_repeat(" ", 1);
							$data2.=substr($value, 3, 3).str_repeat(" ", 1);
						}
						
					}
				}
			}
			$data.= $this->structure_format_individual_name($IndividualName).str_repeat("\t", 1).$PopNumber.str_repeat("\t", 1).$data1.str_repeat("\r\n", 1);
			$data.= $this->structure_format_individual_name($IndividualName).str_repeat("\t", 1).$PopNumber.str_repeat("\t", 1).$data2.str_repeat("\r\n", 1);
		}
		return $data;
	}
	public function arlequin_format_convert_value($dataArray,$max_individual_name_length,$ploidy,$IndividualName,$PopNumber,$how_microsat_coded,$repeatSize){
		$data='';
		$data.= str_repeat("\t", 1).$this->distance($IndividualName,$max_individual_name_length).str_repeat("\t", 1)."1".str_repeat("\t", 1);
		if($ploidy==0){
			if(!empty($repeatSize)){
				$repeatSize=explode(",",$repeatSize);
			}
			foreach(json_decode($dataArray,true) as $key=>$value){
				if($value=="00"){
					$data.= str_repeat("-9", 1).str_repeat(" ", 2);
				}elseif($value=="000"){
					$data.= str_repeat("-9", 1).str_repeat(" ", 3);
				}
				else{
					if($how_microsat_coded=="number-of-repeats"){
						if(!empty($repeatSize)){
							if(count($repeatSize)==1){
								$data.=($value*$repeatSize[0]).str_repeat(" ", 1);
							}else{
								$data.=($value*$repeatSize[$key]).str_repeat(" ", 1);
							}
						}else{
							$data.=$value.str_repeat(" ", 1);;
						}
						
					}else{
						$data.=$value.str_repeat(" ", 1);
					}
				}
			}
			$data.= str_repeat("\r\n", 1);
		}else{
			if(!empty($repeatSize)){
				$repeatSize=explode(",",$repeatSize);
			}
			$data1="";
			$data2="";
			foreach(json_decode($dataArray,true) as $key=>$value){
				if($value=="00"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="0000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}elseif($value=="000000"){
					$data1.="-9".str_repeat(" ", 1);
					$data2.="-9".str_repeat(" ", 1);
				}else{
					if(strlen($value)==2){
						
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=($value*$repeatSize[0]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}else{
									$data1.=($value*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}
							}else{
								$data1.=$value.str_repeat(" ", 1);
								$data2.="-9".str_repeat(" ", 1);
							}
							
						}else{
							$data1.=$value.str_repeat(" ", 1);
							$data2.="-9".str_repeat(" ", 1);
						}
					}elseif(strlen($value)==3){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=($value*$repeatSize[0]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}else{
									$data1.=($value*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.="-9".str_repeat(" ", 1);
								}
							}else{
								$data1.=$value.str_repeat(" ", 1);
								$data2.="-9".str_repeat(" ", 1);
							}
							
						}else{
							$data1.=$value.str_repeat(" ", 1);
							$data2.="-9".str_repeat(" ", 1);
						}
					}elseif(strlen($value)==4){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=(substr($value, 0, 2)*$repeatSize[0]).str_repeat(" ", 1);
									$data2.=(substr($value, 2, 2)*$repeatSize[0]).str_repeat(" ", 1);
								}else{
									$data1.=(substr($value, 0, 2)*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.=(substr($value, 2, 2)*$repeatSize[$key]).str_repeat(" ", 1);
								}
							}else{
								$data1.=(substr($value, 0, 2)).str_repeat(" ", 1);
								$data2.=(substr($value, 2, 2)).str_repeat(" ", 1);
							}
							
						}else{
							$data1.=substr($value, 0, 2).str_repeat(" ", 1);
							$data2.=substr($value, 2, 2).str_repeat(" ", 1);
						}
						
					}elseif(strlen($value)==6){
						if($how_microsat_coded=="number-of-repeats"){
							if(!empty($repeatSize)){
								if(count($repeatSize)==1){
									$data1.=(substr($value, 0, 3)*$repeatSize[0]).str_repeat(" ", 1);
									$data2.=(substr($value, 3, 3)*$repeatSize[0]).str_repeat(" ", 1);
								}else{
									$data1.=(substr($value, 0, 3)*$repeatSize[$key]).str_repeat(" ", 1);
									$data2.=(substr($value, 3, 3)*$repeatSize[$key]).str_repeat(" ", 1);
								}
							}else{
								$data1.=(substr($value, 0, 3)).str_repeat(" ", 1);
								$data2.=(substr($value, 3, 3)).str_repeat(" ", 1);
							}
							
						}else{
							$data1.=substr($value, 0, 3).str_repeat(" ", 1);
							$data2.=substr($value, 3, 3).str_repeat(" ", 1);
						}
						
					}
				}
			}
			$data.=$data1.str_repeat("\r\n", 1);
			$data.=str_repeat("\t", 5).$data2.str_repeat("\r\n", 1);
		}
		return $data;
	}
	public function structure_format_convert_snp($dataString1){
		$dataString='';
		$dataStringArray=explode(',',$dataString1);
		foreach($dataStringArray as $i=>$char){
			if($char=='A'){
				$dataString.='1'.',';
			}elseif($char=='T'){
				$dataString.='2'.',';
			}elseif($char=='G'){
				$dataString.='3'.',';
			}elseif($char=='C'){
				$dataString.='4'.',';
			}elseif($char=='?'.','){
				$dataString.='-9'.',';
			}else{
				$dataString.='-9'.',';
			}
		}
		return $dataString;
	}
	public function genpop_format_convert_snp($dataString1){
		$dataString='';
		$dataStringArray=explode(',',$dataString1);
		foreach($dataStringArray as $i=>$char){
			if($char=='A'){
				$dataString.='100'.',';
			}elseif($char=='T'){
				$dataString.='110'.',';
			}elseif($char=='G'){
				$dataString.='120'.',';
			}elseif($char=='C'){
				$dataString.='130'.',';
			}elseif($char=='?'.','){
				$dataString.='000'.',';
			}else{
				$dataString.='000'.',';
			}
		}
		return $dataString;
	}
	public function snp_convert_letter_to_numeric($data1){
		if($data1=='A'){
			$data1="100";
		}elseif($data1=='T'){
			$data1="110";
		}elseif($data1=='G'){
			$data1="120";
		}elseif($data1=='C'){
			$data1="130";
		}elseif($data1=='?'){
			$data1="000";
		}else{
			$data1="000";
		}
		return $data1;
	}
	public function getAmbiquityBase($char){
		switch($char){
			case 'A':
			return ['A','A','A'];
			case 'T':
			return ['T','T','T'];
			case 'C':
			return ['C','C','C'];
			case 'G':
			return ['G','G','G'];
			case 'R':
			return ['A','G','R'];
			case 'M':
			return ['A','C','M'];
			case 'W':
			return ['A','T','W'];
			case 'S':
			return ['G','C','S'];
			case 'K':
			return ['G','T','K'];
			case 'Y':
			return ['C','T','Y'];
			default:
			return ['?','?','?'];
		}
	}
}
?>