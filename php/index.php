<?php
if (!empty($_POST))
{
	$file_name							=$_POST['file_name'];//fasta
	$input_format						=$_POST['input_format'];//fasta
	$output_format						=$_POST['output_format'];//fasta
	$dataType							=$_POST['filetype'];//fasta
	$ploidy_of_the_data					=$_POST['ploidy_of_the_data'];//fasta
	$phase_information_row_present		=$_POST['phase_information_row_present'];
	$missing_data_value_code			=$_POST['missing_data_value_code'];
	$marker_names_included				=$_POST['marker_names_included'];//structure->step3
	$number_of_markers_in_the_input_file=$_POST['number_of_markers_in_the_input_file'];//structure->step3
	$how_microsat_coded					=$_POST['how_microsat_coded'];//structure->step3,genpop->step3
	$repeatSize							=$_POST['repeatSize'];//structure->step3,genpop->step3
	$individual_name_included			=$_POST['individual_name_included'];
	$popdata_present					=$_POST['popdata_present'];
	$ra_imd_present						=$_POST['ra_imd_present'];
	$specify_format_of_data				=$_POST['specify_format_of_data'];//phylip veya mega formatında sekans ya da interleaved format
	$kind_of_data						=$_POST['kind_of_data'];//mega->step4
	$kind_of_file						=$_POST['kind_of_file'];//phylip->step4
	$relaxed_format						=$_POST['relaxed_format'];//phylip->step4
	$save_sequence_on_single_line		=$_POST['save_sequence_on_single_line'];//fasta->step4
	$what_type_of_data					=$_POST['what_type_of_data'];//phylip->step3 molecular_sequence or distance
	$data_read							='read';
	$taxset								=$_POST['taxset'];//nexus_step3.php sayfasından geliyor
	$specify_format_distance_matrix		=$_POST['specify_format_distance_matrix'];//phylip_step3.php sayfasından geliyor
    if($input_format=='arlequin' && $output_format=='genpop')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintogenpop.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintogenpop.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='arlequin' && $output_format=='phylip')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintophylip.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintophylip.py';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='arlequin' && $output_format=='mega')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintomega.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintomega.meg';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
    else if($input_format=='arlequin' && $output_format=='structure')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintostructure.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintostructure.str';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='arlequin' && $output_format=='fasta')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'data_read' 					=> $data_read,
				'dataType' 						=> $dataType,
				'save_sequence_on_single_line' 	=> $save_sequence_on_single_line,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintofasta.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintofasta.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='genpop' && $output_format=='structure')
    {
        $postdata = http_build_query(
			array(
				'input_format' 							=> $input_format,
				'output_format' 						=> $output_format,
				'file_name'		 						=> $file_name,
				'how_microsat_coded' 					=> $how_microsat_coded,
				'repeatSize' 							=> $repeatSize
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/genpop/genpoptostructure.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-genpoptostructure.str';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='genpop' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType,
				'dataStyle' 		=> $dataStyle,
				'repeatSize' 		=> $repeatSize,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/genpop/genpoptoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-genpoptoarlequin.arp';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='structure' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'data_read' 					=> $data_read,
				'dataType' 						=> $dataType,
				'dataStyle' 					=> $dataStyle,
				'repeatSize' 					=> $repeatSize,
				'ploidy_of_the_data' 			=> $ploidy_of_the_data,
				'phase_information_row_present' => $phase_information_row_present,
				'missing_data_value_code' 		=> $missing_data_value_code,
				'marker_names_included' 		=> $marker_names_included,
				'individual_name_included' 		=> $individual_name_included,
				'popdata_present' 				=> $popdata_present,
				'ra_imd_present' 				=> $ra_imd_present
	
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/structure/structuretoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-structuretoarlequin.arp';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='fasta' && $output_format=='mega')
    {
        $postdata = http_build_query(
			array(
				'input_format' 			=> $input_format,
				'output_format' 		=> $output_format,
				'file_name'		 		=> $file_name,
				'dataType' 				=> $dataType,
				'kind_of_data' 			=> $kind_of_data,
				'ploidy_of_the_data' 	=> $ploidy_of_the_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatomega.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatomega.meg';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='fasta' && $output_format=='phylip')
    {
        $postdata = http_build_query(
			array(
				'input_format' 			=> $input_format,
				'output_format' 		=> $output_format,
				'file_name'		 		=> $file_name,
				'dataType' 				=> $dataType,
				'ploidy_of_the_data' 	=> $ploidy_of_the_data,
				'kind_of_file' 			=> $kind_of_file,
				'relaxed_format' 		=> $relaxed_format,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatophylip.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatophylip.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='fasta' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 			=> $input_format,
				'output_format' 		=> $output_format,
				'file_name'		 		=> $file_name,
				'dataType' 				=> $dataType,
				'ploidy_of_the_data' 	=> $ploidy_of_the_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatoarlequin.arp';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='fasta' && $output_format=='structure')
    {
        $postdata = http_build_query(
			array(
				'input_format' 			=> $input_format,
				'output_format' 		=> $output_format,
				'file_name'		 		=> $file_name,
				'dataType' 				=> $dataType,
				'ploidy_of_the_data' 	=> $ploidy_of_the_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatostructure.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatostructure.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='fasta' && $output_format=='genpop')
    {
        $postdata = http_build_query(
			array(
				'input_format' 			=> $input_format,
				'output_format' 		=> $output_format,
				'file_name'		 		=> $file_name,
				'dataType' 				=> $dataType,
				'ploidy_of_the_data' 	=> $ploidy_of_the_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatogenpop.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatogenpop.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='phylip' && $output_format=='mega')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'ploidy_of_the_data' 			=> $ploidy_of_the_data,
				'what_type_of_data' 			=> $what_type_of_data,
				'specify_format_distance_matrix'=> $specify_format_distance_matrix,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/phylip/phyliptomega.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-phyliptomega.meg';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='phylip' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'specify_format_of_data'		=> $specify_format_of_data,
				'what_type_of_data' 			=> $what_type_of_data,
				'specify_format_distance_matrix'=> $specify_format_distance_matrix,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/phylip/phyliptoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-phyliptoarlequin.arp';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='mega' && $output_format=='fasta')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'specify_format_of_data' 		=> $specify_format_of_data,
				'save_sequence_on_single_line' 	=> $save_sequence_on_single_line,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/mega/megatofasta.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-megatofasta.fasta';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='mega' && $output_format=='nexus')
    {
        $postdata = http_build_query(
			array(
				'input_format' 				=> $input_format,
				'output_format' 			=> $output_format,
				'file_name'		 			=> $file_name,
				'dataType' 					=> $dataType,
				'specify_format_of_data' 	=> $specify_format_of_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/mega/megatonexus.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-megatonexus.nex';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='mega' && $output_format=='phylip')
    {
        $postdata = http_build_query(
			array(
				'input_format' 				=> $input_format,
				'output_format' 			=> $output_format,
				'file_name'		 			=> $file_name,
				'dataType' 					=> $dataType,
				'specify_format_of_data' 	=> $specify_format_of_data,
				'kind_of_file' 				=> $kind_of_file,
				'relaxed_format' 			=> $relaxed_format,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/mega/megatophylip.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-megatophylip.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='mega' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'specify_format_of_data' 		=> $specify_format_of_data,
				'save_sequence_on_single_line' 	=> $save_sequence_on_single_line,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/mega/megatoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-megatoarlequin.arp';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='nexus' && $output_format=='fasta')
    {
        $postdata = http_build_query(
			array(
				'input_format' 				=> $input_format,
				'output_format' 			=> $output_format,
				'file_name'		 			=> $file_name,
				'dataType' 					=> $dataType,
				'specify_format_of_data' 	=> $specify_format_of_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/nexus/nexustofasta.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-nexustofasta.fasta';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='nexus' && $output_format=='arlequin')
    {
        $postdata = http_build_query(
			array(
				'input_format' 				=> $input_format,
				'output_format' 			=> $output_format,
				'file_name'		 			=> $file_name,
				'dataType' 					=> $dataType,
				'specify_format_of_data' 	=> $specify_format_of_data,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/nexus/nexustoarlequin.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-nexustoarlequin.nex';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='fasta' && $output_format=='nexus')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType,
				'ploidy_of_the_data'=> $ploidy_of_the_data,
				'dataStyle' 		=> $dataStyle,
				'repeatSize' 		=> $repeatSize,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/fasta/fastatonexus.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-fastatonexus.nex';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='phylip' && $output_format=='fasta')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'specify_format_of_data' 		=> $specify_format_of_data,
				'what_type_of_data' 			=> $what_type_of_data,
				'save_sequence_on_single_line' 	=> $save_sequence_on_single_line,
				'specify_format_distance_matrix'=> $specify_format_distance_matrix,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/phylip/phyliptofasta.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-phyliptofasta.fasta';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='phylip' && $output_format=='nexus')
    {
        $postdata = http_build_query(
			array(
				'input_format' 					=> $input_format,
				'output_format' 				=> $output_format,
				'file_name'		 				=> $file_name,
				'dataType' 						=> $dataType,
				'ploidy_of_the_data' 			=> $ploidy_of_the_data,
				'what_type_of_data' 			=> $what_type_of_data,
				'specify_format_distance_matrix'=> $specify_format_distance_matrix,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/phylip/phyliptonexus.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-phyliptonexus.nex';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='nexus' && $output_format=='mega')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType,
				'dataStyle' 		=> $dataStyle,
				'repeatSize' 		=> $repeatSize,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/nexus/nexustomega.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-nexustomega.meg';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }else if($input_format=='nexus' && $output_format=='phylip')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'dataType' 			=> $dataType,
				'ploidy_of_the_data'=> $ploidy_of_the_data,
				'kind_of_file' 		=> $kind_of_file,
				'relaxed_format' 	=> $relaxed_format,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/nexus/nexustophylip.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-nexustophylip.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='arlequin' && $output_format=='nexus')
    {
        $postdata = http_build_query(
			array(
				'input_format' 		=> $input_format,
				'output_format' 	=> $output_format,
				'file_name'		 	=> $file_name,
				'data_read' 		=> $data_read,
				'dataType' 			=> $dataType,
				'dataStyle' 		=> $dataStyle,
				'repeatSize' 		=> $repeatSize,
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/arlequin/arlequintonexus.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-arlequintonexus.nex';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else if($input_format=='structure' && $output_format=='genpop')
    {
        $postdata = http_build_query(
			array(
				'input_format' 							=> $input_format,
				'output_format' 						=> $output_format,
				'file_name'		 						=> $file_name,
				'dataType' 								=> $dataType,
				'ploidy_of_the_data' 					=> $ploidy_of_the_data,
				'missing_data_value_code' 				=> $missing_data_value_code,
				'marker_names_included' 				=> $marker_names_included,
				'individual_name_included' 				=> $individual_name_included,
				'how_microsat_coded' 					=> $how_microsat_coded,
				'repeatSize' 							=> $repeatSize,
				'number_of_markers_in_the_input_file' 	=> $number_of_markers_in_the_input_file,
				'popdata_present' 						=> $popdata_present
			)
		);

		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL,
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		$output = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']).'/structure/structuretogenpop.php', false, $context);
		$folder_name = uniqid(date('h-i-s').'_').'-structuretogenpop.txt';
        $file = fopen('../downloads/'.$folder_name, 'w');
        fwrite($file, $output);
        fclose($file);
		response($folder_name);
    }
	else{
		echo "This format conversion is not ready yet!";
	}
}
else
{
	$opts = array('http' =>
	 array( 'header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-CL; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3' . PHP_EOL )
	);
	$context = stream_context_create($opts);
	$str = file_get_contents('http://www.widgetcon.net/php/deneme.php',false,$context);
	echo $str;
	 if(strlen($str)>0){
	 preg_match('/\<meta name="keywords" content="(.*)\">/',$str,$title);
	 echo $title[1];
	 }

}
function response($folder_name){
	$array=[];
	$array[0]='<div class="panel panel-fp">
			<div class="panel-body">
				<a class="download_btn" href="downloads/download.php?file='.$folder_name.'"><i class="fa fa-download"></i>&nbsp;DOWNLOAD</a>
			</div>
		</div>';
		$myfile = fopen($_SERVER['DOCUMENT_ROOT']."/downloads/$folder_name", "r") or die("Unable to open file!");
		//echo fread($myfile,filesize("/downloads/download.php?file=$folder_name"));
	$array[1]=fread($myfile,filesize($_SERVER['DOCUMENT_ROOT']."/downloads/$folder_name"));
	//echo $array[1];
		
		echo'<form class="modern-p-form flat-p-form  p-form-modern-purple"><div class="form-group preview-btn text-right p-buttons"><label style="left:0px;position:absolute;">Preview</label><a href="javascript:void(0)" onclick="copyClipboard()" class="btn" style="background-color:#3498db"><i class="fa fa-copy fa-2"></i> Copy Clipboard</a><a name="file_content_preview" href="downloads/download.php?file='.$folder_name.'" style="background-color:#e74c3c;color:#fff;" class="btn"><i class="fa fa-download fa-2"></i> Download</a><div class="input-group p-has-icon"><textarea id="copy_data" readonly rows="14" style="overflow:auto;pointer-events: auto;height:auto !important;background-color:#fff !important;color:#222 !important;border-color:#ccc !important;font-size:13px;font-family: "Fira Mono", monospace;" class="form-control">'.$array[1].'</textarea><span class="input-group-state"><span class="p-position"><span class="p-text"><span class="p-required-text"><i class="fa fa-star"></i></span></span></span></span> <span class="p-field-cb"></span> <span class="input-group-icon"><i class="fa fa-file-text-o"></i></span></div></div></form>';
		fclose($myfile);
}
 ?>