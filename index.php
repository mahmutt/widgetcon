<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="yandex-verification" content="0288e74dbda0a296" />
        <title>Widgetcon | Molecular Data Converter Widget</title>
		<!-- Sweet Alert style -->
		<link rel="stylesheet" href="./sweetalert/dist/sweetalert2.min.css">
        <link href="./font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="./bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <!-- colorpicker: Spectrum plugin -->
        <link href="./js/spectrum/spectrum.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap datetimepicker -->
        <link href="./js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
        <!-- Slider -->
        <link href="./js/jquery-ui/css/slider.css" rel="stylesheet" type="text/css">
        <link href="./css/forms-plus.css" rel="stylesheet" type="text/css">
        <!-- Color style: remove or change to change coloring -->
        <link href="./css/color/forms-plus-purple.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for background (<1-6>.jpg), remove if not needed -->
		<link href="./uploadma/css/jquery.filer.css" type="text/css" rel="stylesheet" />
		<!-- nprogress -->
		<link rel='stylesheet' href='./nprogress/nprogress.css'/>
		<link href="./uploadma/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico">
        <style>
        html {
            height: 100%;
        }
        body {
            margin: 20px 0;
            background: url(images/backgrounds/8.jpg) fixed;
            background-size: 100% 100%;
        }
		.passive {
		   pointer-events: none;
		   cursor: default;
		   background-color:#ccc !important;
		} 
		.label-modern{
			background-color: #b33996;
		}
		#costumized by widgetcon
		.home-link a{color:#fff;}
		
		label,.input-group input,option{font-weight:bold !important;}
		.p-label-required::after { 
			#content: "*(Mandatory)" !important;
			font-weight:bold;
			color:#b80000;
			font-size:16px;
		}
		.download_btn{
			color: #fff !important;
			background-color: #b33996;
			border-radius: 0;
			line-height: 36px;
			outline: 0 none;
			display: inline-block;
			padding: 6px 46px;
			margin-bottom: 0;
			font-size: 18px;
			font-weight: normal;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			background-image: none;
			border: 1px solid #ab1e80;
			text-decoration:none !important;
		}
		
		
		#costumized by widgetcon
        </style>
    </head>
    <body>
        <div class="container">
		
            <!-- Start: modern skin - Checkout steps -->
			
            <form method="post" id="formum" class="modern-p-form flat-p-form  p-form-modern-purple" action="" data-js-validate="true" data-js-highlight-state-msg="true" data-js-show-valid-msg="true" data-js-ajax-form="" data-js-ajax-before-hide-block="successBlockName;failBlockName" data-js-ajax-before-show-block="loadingBlockName" data-js-ajax-success-show-block="successBlockName" data-js-ajax-success-hide-block="formBlockName" data-js-ajax-fail-show-block="failBlockName" data-js-ajax-always-hide-block="loadingBlockName">
                <div class="p-btn-pannel p-fixed p-pos-left">
                    <a class="" href="/"><label for="home-link" class="btn home-link"><i class="fa fa-home"></i></label></a>
                </div>
				<div class="p-form p-shadowed p-form-sm progress_parent">
					<!--<a class="index.php" href=""><i class="fa fa-home"></i>&nbsp;HOME</a>
					<hr>-->
					<div align="center"><img class="img-responsive" src="images/widgetcon-logo-1080x332.png" width="332"/></div>
					<div align="center" style="margin-bottom:5px;"><span style="color:#333;font-weight:bold">Quick conversion among common population genetic data formats -</span> <span style="color:#b33996;font-weight:bold">version 1.0.0</span></div>
                    <div class="p-form-steps-wrap">
                        <ul class="p-form-steps" data-js-stepper="checkoutSteps">
                            <li class="active" data-js-step="step1">
                                <span class="p-step">
                                    <span class="p-step-text">Step 1</span>
                                </span>
                            </li>
                            <li data-js-step="step2">
                                <span class="p-step">
                                    <span class="p-step-text">Step 2</span>
                                </span>
                            </li>
                            <li data-js-step="step3">
                                <span class="p-step">
                                    <span class="p-step-text">Step 3</span>
                                </span>
                            </li>
                            <li data-js-step="step4">
                                <span class="p-step">
                                    <span class="p-step-text">Step 4</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div data-js-block="errorContentBlock" class="collapse"></div>
                    <div data-js-block="step1" data-js-validation-block="">
						<?php include 'steps/step1.php'; ?>
                        <br/>
                        <div class="text-right">
							<a class=""  id="loader_step1" style="display:none;float:left:margin-left:5px;" > <img src="images/ajax-loader.gif" /></a>
                            <a class="btn" id="confirm_step1" data-js-show-step="checkoutSteps:2"><i class="fa fa-check-square-o"></i>&nbsp;confirm</a>
                        </div>
                    </div>
                    <div data-js-block="step2" data-js-validation-block="" class="collapse">
                        <!-- Start: subtitle -->
						<div class="p-subtitle text-left">
							<span class="p-title-side">Upload Input File </span>
						</div>
						<!-- End: subtitle -->
                        <div id="section_step2">
							<div class="row">
								<div class="col-sm-12">
									<!-- Start: fileupload4 <fileupload> -->
									<div class="form-group">
										<div class="p-file-wrap">
											<div class="input-group" id="alis">
											</div>
										</div>
									</div>
									<!-- End: fileupload4 <fileupload> -->
								</div>
							</div>
						</div>
                        <div class="text-right">
							<a class="btn" href="#" data-js-show-step="checkoutSteps:1"><i class="fa fa-arrow-left"></i>&nbsp;back</a>
							<a class="btn" disabled="disabled" id="confirm_step2" data-js-show-step="checkoutSteps:3"><i class="fa fa-check-square-o"></i>&nbsp;confirm</a>
							
						</div>
                    </div>
                    <div data-js-block="step3" data-js-validation-block="" class="collapse">
                        <div id="section_step3"></div>
                        <div class="text-right">
                            <a class="btn" href="#" data-js-show-step="checkoutSteps:2"><i class="fa fa-arrow-left"></i>&nbsp;back</a>
							<a class="btn" id="confirm_step3" data-js-show-step="checkoutSteps:4"><i class="fa fa-check-square-o"></i>&nbsp;confirm</a>
                        </div>
                    </div>
					<div data-js-block="step4" data-js-validation-block="" class="collapse step4">
                        <div id="section_step4"></div>
                        <div class="text-right">
                            <a class="btn" href="#"  data-js-show-step="checkoutSteps:3"><i class="fa fa-arrow-left"></i>&nbsp;back</a>
							<a href="#" id="confirm_step4" data-js-show-step="checkoutSteps:5" class="btn"><i class="fa fa-refresh"></i> START CONVERTING</a>
							
                        </div>
						
                    </div>
					<hr>
					<div class="row">
						
						<div class="col-md-3">
							<a href="https://github.com/mahmutt/widgetcon" target="_blank" style="color:#b33996;font-weight:bold;text-decoration:underline"><i class="fa fa-github"></i> Github</a> 				 
						</div>
						<div class="col-md-3">
							<a href="https://widgetcon.net/documentation" target="_blank" style="color:#b33996;font-weight:bold;text-decoration:underline"><i class="fa fa-file"></i> Documentation</a> 				 
						</div>
						<div class="col-md-3" style="">
							 <a href="https://widgetcon.net/documentation#contuct-and-bug-report" target="_blank" style="color:#b33996;font-weight:bold;text-decoration:underline"><i class="fa fa-bug"></i> Bug Report</a> 	  
						</div>
						<div class="col-md-3" style="">
							 <a href="https://widgetcon.net/documentation#example-data-sets" target="_blank" style="color:#b33996;font-weight:bold;text-decoration:underline"><i class="fa fa-file-text-o"></i> Example Data Sets</a> 	  
						</div>
					</div>
					
                </div>
            </form>
            <!-- End: modern skin - Checkout steps -->
        </div>
        <script src="./js/jquery.js" type="text/javascript"></script>
		<script src="./uploadma/js/jquery.filer.min.js"></script>
        <!-- jquery ui -->
        <script src="./js/jquery-ui/js/core.js"></script>
        <script src="./js/jquery-ui/js/widget.js"></script>
        <script src="./js/jquery-ui/js/mouse.js"></script>
        <script src="./js/jquery-ui/js/autocomplete.js"></script>
        <script src="./js/jquery-ui/js/slider.js"></script>
        <script src="./js/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
        <!-- Helpers -->
        <script src="./js/moment/moment.js"></script>
        <script src="./js/moment/locale/da.js"></script>
        <!-- Validation plugin -->
        <script src="./js/jquery-validation/jquery.validate.js"></script>
        <script src="./js/jquery-validation/additional-methods.js"></script>
        <!-- Field mask plugin -->
        <script src="./js/jquery-masked-input/jquery.maskedinput.js"></script>
        <!-- Bootstrap datetimepicker -->
        <script src="./js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!-- captcha: Realperson plugin -->
        <script src="./js/jquery-realperson/jquery.plugin.js"></script>
        <script src="./js/jquery-realperson/jquery.realperson.js"></script>
        <!-- colorpicker: Spectrum plugin -->
        <script src="./js/spectrum/spectrum.js"></script>
        <!-- ajax: jQuery Form Plugin -->
        <script src="./js/jquery-form-plugin/jquery.form.js"></script>
        <!-- Forms Plus plugins/helpers -->
        <script src="./js/forms-plus/forms-plus.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-value.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-field.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-file.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-spinner.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-validation.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-block.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-elements.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-slider.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-ajax.js" type="text/javascript"></script>
        <script src="./js/forms-plus/forms-plus-steps.js" type="text/javascript"></script>
        <!-- Forms Plus init -->
        <script src="./js/script.js"></script>
		<!-- Sweet Alert -->
		<script src="./sweetalert/dist/sweetalert2.min.js"></script>
		<script src='./nprogress/nprogress.js'></script>
		<script type="text/javascript">
		function copyClipboard() {
		  /* Get the text field */
		  var copyText = document.getElementById("copy_data");

		  /* Select the text field */
		  copyText.select();

		  /* Copy the text inside the text field */
		  document.execCommand("Copy");

		  /* Alert the copied text */
		  //alert("Copied the text: " + copyText.value);
		}
		$( document ).ready(function() {
			NProgress.configure({ parent: '.progress_parent',template: '<div class="bar" style="height:3px" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>' });
			//NProgress.start();
			window.onerror = function(message, url, lineNumber) 
			{
				alert(url + " dosyasında + " + lineNumber + ".satırda bir hata oluştu : " + message);
			};
			var output_format;
			var input_format;
			var file_type;
			var upload_extensions;
			var file_name;
			/**
			 *  İzin verilen dosya uzantıları
			 *  @upload_allowed_extensions(input_format)
			**/
			function upload_allowed_extensions(input_format){
				if(input_format=='structure'){
					return ["str","txt"];
				}else if(input_format=='arlequin'){
					return ["arp"];
				}else if(input_format=='genpop'){
					return ["txt"];
				}else if(input_format=='nexus'){
					return ["nex","nxs"];
				}else if(input_format=='mega'){
					return ["meg","txt"];
				}else if(input_format=='phylip'){
					return ["txt","phy","py"];
				}else if(input_format=='fasta'){
					return ["fasta","fas","fa","seq","fsa","fna","ffn","faa","frn","mpfa","txt"];
				}else{
					return ["txt"];
				}
			}
			$('#input_format').on('change', function (e) {
				input_format = this.value;
				$('#output_format').prop('selectedIndex',0);
				$("#output_format option").removeAttr('disabled').css({'color':'#666666'});
				
				$('#filetype').prop('selectedIndex',0);
				$("#filetype option").removeAttr('disabled').css({'color':'#666666'});
				if(input_format!=''){
					converting_formats(input_format);
					//upload_extensions=upload_allowed_extensions(input_format);
					//alis(upload_extensions,input_format);
				}else{
				}
			});
			$('#output_format').on('change', function (e) {
				output_format = this.value;
				if(input_format!=''){
					converting_types(input_format,output_format);
					//alert(input_format+','+output_format);
				}else{
				}
			});
			$('#filetype').on('change', function (e) {
				file_type = this.value;
				/**
				*	input dosyası, output dosyası veya dosya tipi değişince
				*	yüklenen dosya varsa silinecek ve dosya upload boş gelecek
				**/
				upload_extensions=upload_allowed_extensions(input_format);
				alis(upload_extensions,input_format);
			});
			/**
			 *  Birbirine çevrilen dosya formatları
			 *  @converting_formats(input_format)
			**/
			function converting_formats(input_format){
				var arlequin	=['structure','genpop','nexus','mega','phylip','fasta'];
				var structure	=['arlequin','genpop'];
				var genpop		=['arlequin','structure'];
				var nexus		=['arlequin','mega','fasta','phylip'];
				var mega		=['nexus','fasta','phylip','arlequin'];
				var phylip		=['mega','fasta','nexus','arlequin'];
				var fasta		=['mega','nexus','phylip','arlequin','structure','genpop'];
				var dizi;
				if(input_format=='structure'){
					dizi=structure;
				}else if(input_format=='arlequin'){
					dizi=arlequin;
				}else if(input_format=='genpop'){
					dizi=genpop;
				}else if(input_format=='nexus'){
					dizi=nexus;
				}else if(input_format=='mega'){
					dizi=mega;
				}else if(input_format=='phylip'){
					dizi=phylip;
				}else if(input_format=='fasta'){
				dizi=fasta;
				}else{
					dizi=structure;
				}
				$('#output_format').prop('selectedIndex',0);
				$("#output_format option").removeAttr('disabled').css({'color':'#666666'});
				$("#output_format option").each(function()
				{
					var val=$(this).val();
					if(jQuery.inArray(val, dizi) == -1 && val!==''){
						$(this).prop('disabled', true).css({'color':'#dddddd'});
					}
				});
			}
			/**
			 *  Çevrilebilen dosya tipleri
			 *  @converting_types(input_format,output_format)
			**/
			function converting_types(input_format,output_format){
				var arlequin	=['microsat','dna','rna','protein','snp','aflp','rflp','rapd','ipbs'];
				var structure	=['microsat','snp','aflp','rflp','rapd','ipbs'];
				var genpop		=['microsat','snp','aflp','rflp','rapd','ipbs'];
				var mega		=['dna','rna','protein','snp','distance'];
				var phylip		=['dna','rna','protein','snp','distance'];
				var nexus		=['dna','rna','protein','snp'];
				var fasta		=['dna','rna','protein','snp'];
				var array_input;
				var array_output;
				var arrayi_intersection;
				if(input_format=='structure'){
					array_input=structure;
				}else if(input_format=='arlequin'){
					array_input=arlequin;
				}else if(input_format=='genpop'){
					array_input=genpop;
				}else if(input_format=='nexus'){
					array_input=nexus;
				}else if(input_format=='mega'){
					array_input=mega;
				}else if(input_format=='phylip'){
					array_input=phylip;
				}else if(input_format=='fasta'){
				array_input=fasta;
				}else{
					array_input=structure;
				}
				if(output_format=='structure'){
					array_output=structure;
				}else if(output_format=='arlequin'){
					array_output=arlequin;
				}else if(output_format=='genpop'){
					array_output=genpop;
				}else if(output_format=='nexus'){
					array_output=nexus;
				}else if(output_format=='mega'){
					array_output=mega;
				}else if(output_format=='phylip'){
					array_output=phylip;
				}else if(output_format=='fasta'){
				array_output=fasta;
				}else{
					array_output=structure;
				}
				arrayi_intersection=$.arrayi_intersection(array_input, array_output);
				$('#filetype').prop('selectedIndex',0);
				$("#filetype option").removeAttr('disabled').css({'color':'#666666'});
				
				$("#filetype option").each(function()
				{
					var val=$(this).val();
					if(jQuery.inArray(val,arrayi_intersection) == -1 && val!==''){
						$(this).prop('disabled', true).css({'color':'#dddddd'});
					}
				});
			}
			$.arrayi_intersection = function(a, b)
			{
				return $.grep(a, function(i)
				{
					return $.inArray(i, b) > -1;
				});
			};
			function section_step3(file_name,input_format,output_format,file_type)
			{
				var url;
				if(input_format=='structure'){
					url='steps/structure_step3.php';
				}else if(input_format=='arlequin'){
					url='steps/arlequin_step3.php';
				}else if(input_format=='genpop'){
					url='steps/genpop_step3.php';
				}else if(input_format=='nexus'){
					url='steps/nexus_step3.php';
				}else if(input_format=='mega'){
					url='steps/mega_step3.php';
				}else if(input_format=='phylip'){
					url='steps/phylip_step3.php';
				}else if(input_format=='fasta'){
					url='steps/fasta_step3.php';
				}else{
					url='steps/arlequin_step3.php';
				}
				$.ajax
				({	
					type	: "POST",
					url:url,
					data:{
					'file_name'		:file_name,
					'input_format'	:input_format,
					'output_format'	:output_format,
					'file_type'		:file_type
					},
					success	:function(donen_veri)
					{
						$('#section_step3').html(donen_veri);
						$("#confirm_step2").removeAttr('disabled');
						NProgress.done();
						
						section_step4(file_name,input_format,output_format,file_type);
					},
					error:function(ma,ydin)
					{
						if (ma.status === 0) {
							alert('Not connected.\nPlease verify your network connection. [0]');
						} else if (ma.status == 400) {
							alert('Server understood the request, but request content was invalid. [400]');
						} else if (ma.status == 401) {
							alert('Unauthorized access. [401]');
						} else if (ma.status == 403) {
							alert('Forbidden resource can\'t be accessed. [403]');
						} else if (ma.status == 404) {
							alert('Requested page not found. [404]');
						} else if (ma.status == 500) {
							alert('Internal server error [500]');
						} else if (ma.status == 503) {
							alert('Service unavailable.');
						} else if (ydin === 'parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if (ydin === 'timeout') {
							alert('Request Time out.');
						} else if (ydin === 'abort') {
							alert('Request was aborted by the server.');
						} else {
							alert('Unknown Error \n' + ma.responseText);
						}
					}
				});
			}
			function section_step4(file_name,input_format,output_format,file_type)
			{
				var url;
				if(output_format=='structure'){
					url='steps/structure_step4.php';
				}else if(output_format=='arlequin'){
					url='steps/arlequin_step4.php';
				}else if(output_format=='genpop'){
					url='steps/genpop_step4.php';
				}else if(output_format=='nexus'){
					url='steps/nexus_step4.php';
				}else if(output_format=='mega'){
					url='steps/mega_step4.php';
				}else if(output_format=='phylip'){
					url='steps/phylip_step4.php';
				}else if(output_format=='fasta'){
					url='steps/fasta_step4.php';
				}else{
					url='steps/arlequin_step4.php';
				}
				$.ajax
				({	
					type	: "POST",
					url:url,
					data:{
					'file_name'		:file_name,
					'input_format'	:input_format,
					'output_format'	:output_format,
					'file_type'		:file_type
					},
					success	:function(donen_veri)
					{
						$('#section_step4').html(donen_veri);
					},
					error:function(ma,ydin)
					{
						if (ma.status === 0) {
							alert('Not connected.\nPlease verify your network connection. [0]');
						} else if (ma.status == 400) {
							alert('Server understood the request, but request content was invalid. [400]');
						} else if (ma.status == 401) {
							alert('Unauthorized access. [401]');
						} else if (ma.status == 403) {
							alert('Forbidden resource can\'t be accessed. [403]');
						} else if (ma.status == 404) {
							alert('Requested page not found. [404]');
						} else if (ma.status == 500) {
							alert('Internal server error [500]');
						} else if (ma.status == 503) {
							alert('Service unavailable.');
						} else if (ydin === 'parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if (ydin === 'timeout') {
							alert('Request Time out.');
						} else if (ydin === 'abort') {
							alert('Request was aborted by the server.');
						} else {
							alert('Unknown Error \n' + ma.responseText);
						}
					}
				});
			}
			
			/**
			 *  id değeri {confirm_step4} olan butona tıklanınca - @confirm_step4 click
			 *	Sunucuya tüm bilgiler ajax metodu ile göderilir,
			 *  index.php sayfasında ki çevirme işlemlerinden sonra geriye response gönderilir,
			 *	gelen response değeri sayfaya eklenir.
			**/
			$('#confirm_step4').click(function(){
				/**
				* Eğer formun tüm zorunlu alanları dolduruldu ise ajax-post metodu çalışacak
				**/
				var dfd	= jQuery.Deferred(),
				valid  	= true
				jQuery("#formum").find(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], " +
					"[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], " +
					"[type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], " +
					"[type='radio'], [type='checkbox']").each(function(i, $el){
					if( !jQuery($el).valid() ){
						valid                       = false;
					}
				});
				if( valid ){
					dfd.resolve('validation');
				}else{
					dfd.reject('validation');
				}
				if(valid){
					var start_time;
					var end_time;
					$.ajax
					({	
						type	: "POST",
						url		:'php/index.php',
						data	:$('#formum').serialize()+ '&file_name=' + file_name,
						beforeSend: function(){
							NProgress.start();
							start_time=new Date().getTime();
							console.log("start time:"+start_time);
						},
						success	:function(response)
						{
							setTimeout(
							function() 
							{
								NProgress.done();
								console.log("end time:"+new Date().getTime());
								swal({
								  title: '<h4 style="color:#a5dc86">Your output file is avaliable <span style="font-size:10px;color:red">'+(new Date().getTime() - start_time) / 1000+' s.</span></h4>',
								  width: 720,
								  type: 'success',
								  showConfirmButton: false,
								  showCloseButton: true,
								  html:response,
								})
							}, 100);
						},
						error:function(ma,ydin)
						{
							if (ma.status === 0) {
								alert('Not connected.\nPlease verify your network connection. [0]');
							} else if (ma.status == 400) {
								alert('Server understood the request, but request content was invalid. [400]');
							} else if (ma.status == 401) {
								alert('Unauthorized access. [401]');
							} else if (ma.status == 403) {
								alert('Forbidden resource can\'t be accessed. [403]');
							} else if (ma.status == 404) {
								alert('Requested page not found. [404]');
							} else if (ma.status == 500) {
								alert('Internal server error [500]');
							} else if (ma.status == 503) {
								alert('Service unavailable.');
							} else if (ydin === 'parsererror') {
								alert('Error.\nParsing JSON Request failed.');
							} else if (ydin === 'timeout') {
								alert('Request Time out.');
							} else if (ydin === 'abort') {
								alert('Request was aborted by the server.');
							} else {
								alert('Unknown Error \n' + ma.responseText);
							}
						}
					})
				}
			});
			function alis(upload_extensions,input_format){
				var upload_extensions_array='.'+upload_extensions.join(',.');
				var DOM='<label class="p-label-required" for="input_format">Input File:</label> <input type="file" name="files[]" id="filer_input" onchange="" accept="">';
				$('#alis').html('').append(DOM);
				$('#filer_input').filer({
					limit:1,
					extensions:upload_extensions,
					changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop input file here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse File</a></div></div>',
					showThumbs: true,
					theme: "dragdropbox",
					dragDrop: {
						dragEnter: null,
						dragLeave: null,
						drop: function(){
							if($('#filer_input').attr('disabled')=='disabled'){
								alert('Firstly you have to select a input file format!');
							}
						},
					},
					uploadFile: {
						url: "uploadma/php/upload.php",
						data:null,
						type: 'POST',
						enctype: 'multipart/form-data',
						beforeSend: function(){
							$("#confirm_step2").attr('disabled','disabled');
							
							NProgress.start();
						},
						success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id){
							var parent = itemEl.find(".jFiler-jProgressBar").parent();
							itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function(){
								$("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");    
							});
							var parse_data=$.parseJSON(data);
							file_name=parse_data.name;
							var record_item = {
								"name"		: parse_data.name,
								"extension"	: parse_data.extension,
								"size"		: parse_data.size,
								"type"		: parse_data.type,
							};
							section_step3(file_name,input_format,output_format,file_type);
						},
						error: function(el){
							var parent = el.find(".jFiler-jProgressBar").parent();
							el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
								$("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");    
							});
						},
						statusCode: null,
						onProgress: null,
						onComplete: null
					},
					addMore: false,
					clipBoardPaste: true,
					excludeName: null,
					beforeRender: null,
					afterRender: null,
					beforeShow: null,
					beforeSelect: null,
					onSelect: null,
					afterShow: null,
					onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
						/**/
						$.post('uploadma/php/remove_file.php', {file: file.name});
						$("#confirm_step2").attr('disabled','disabled');
						NProgress.done();
						/**/
					},
					onEmpty: null,
					options: null,
					captions: {
						button: "Choose File",
						feedback: "Choose file To Upload",
						feedback2: "file was chosen",
						drop: "Drop file here to Upload",
						removeConfirmation: "Are you sure you want to remove this file?",
						errors: {
							filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
							filesType: "Only selected-'{{fi-extensions}}' extensions are allowed to be uploaded.",
							//filesType:swal('Oops...','Something went wrong!','error'),
							filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
							filesSizeAll: "File you've choosed are too large! Please upload file up to {{fi-maxSize}} MB."
						}
					}
				});
			}
		});


		</script>
				<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118293057-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-118293057-1');
		</script>
    </body>
</html>
