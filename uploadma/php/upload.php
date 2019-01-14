
<?php
    include('class.uploader.php');
    
    $uploader = new Uploader();
	$limit		=$_POST['limit'];
	$maxSize	=$_POST['maxSize'];
    $data = $uploader->upload($_FILES['files'], array(
        'limit' => $limit, //Maximum Limit of files. {null, Number}
        'maxSize' => $maxSize, //Maximum Size of files {null, Number(in MB's)}
        'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
        'required' => false, //Minimum one file is required for upload {Boolean}
        'uploadDir' => '../../uploads/', //Upload directory {String}
        #'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
        'title' => array('auto',15), //New file name {null, String, Array} *please read documentation in README.md
        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
        'perms' => null, //Uploaded file permisions {null, Number}
        'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
        'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
        'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
        'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
        'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
        'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
    
    if($data['isComplete']){
       $record=[];
		$record['name']			=$data['data']['metas'][0]['name'];
		$record['extension']    =$data['data']['metas'][0]['extension'];
		$record['size']			=$data['data']['metas'][0]['size'];
		$record['type']			=$data['data']['metas'][0]['type'][0];
		#$files                 =$data['data']['metas'][0];
		print_r(json_encode($record));
    }

    if($data['hasErrors']){
        $errors = $data['errors'];
        print_r($errors);
    }
    
    function onFilesRemoveCallback($removed_files){
        foreach($removed_files as $key=>$value){
            $file = '../../uploads/' . $value;
            if(file_exists($file)){
                unlink($file);
            }
        }
        
        return $removed_files;
    }
?>
