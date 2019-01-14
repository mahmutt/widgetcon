<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?><div class="p-subtitle text-left">
	<span class="p-title-side">MEGA  Input File details</span>
</div>

<div class="row">
	<div class="col-sm-12">
		<!-- Start: file_type <select> -->
		<div class="form-group p-field-disabled">
			<label for="file_type" class="p-label-required">Type of the data</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="file_type" name="file_type" placeholder="Type of the data" required="required" disabled="disabled" class="form-control">
					<option class="p-select-default" value="number-of-repeats"><?= $app->label($file_type) ?></option>
				</select>
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: file_type <select> -->
	</div>
	<?php if($file_type!=='distance'):?>
	<div class="col-sm-12">
		<!-- Start: specify_format_of_data <select> -->
		<div class="form-group">
			<label for="specify_format_of_data" class="p-label-required">Specify the format of the data?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="specify_format_of_data" name="specify_format_of_data" placeholder="specify_format_of_data" required="required" class="form-control">
					<option  class="p-select-default" value="sequential">sequential(noninterleaved)</option>
					<option value="interleaved">interleaved</option>
				</select>
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: specify_format_of_data <select> -->
		
	</div>
	<?php endif;?>
	
	<?php if($file_type=='microsat'): ?>
	<div class="col-sm-10 col-sm-offset-2">
		<!-- Start: how_microsat_coded <select> -->
		<div class="form-group">
			<label for="how_microsat_coded" class="p-label-required">How are Microsat alleles coded? in case microsat data type</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="how_microsat_coded" name="how_microsat_coded" placeholder="how_microsat_coded" required="required" class="form-control">
					<option class="p-select-default" value="number-of-repeats">as number of repeats</option>
					<option value="length-pcr-fragments">as the length of the PCR fragments</option>
					<option value="arbitrary-number">as an arbitrary number</option>
				</select>
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: how_microsat_coded <select> -->
		
	</div>
	
	<div class="col-sm-8 col-sm-offset-4" id="repeatSize_div" style="display:none;">
		<!-- Start: repeatSize_div <input:text> -->
		<div class="form-group">
			<label for="repeatSize" class="p-label-required">
			Enter the size of the repeated motif(same for all loci:different:comma separeted list)
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="repeatSize" name="repeatSize" placeholder="eq:2,2,3,2" class="form-control" aria-required="true">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-home"></i></span>
			</div>
		</div>
		<!-- End: repeatSize_div <input:text> -->
	</div>
	
	<?php endif; ?>
	
</div>
<script type="text/javascript">

$('#how_microsat_coded').on('change', function (e) {
	how_microsat_coded = this.value;
	$( "input[name='repeatSize']" ).val('');
	if(how_microsat_coded=='length-pcr-fragments'){
		$('#repeatSize_div').show();
		$( "input[name='repeatSize']" ).removeAttr('disabled');
		$( "input[name='repeatSize']" ).attr('required','required');
		
		//alert(how_microsat_coded+','+output_format);
	}else{
		$('#repeatSize_div').hide();
		$( "input[name='repeatSize']" ).attr('disabled','disabled');
		$( "input[name='repeatSize']" ).removeAttr('required');
	}
});
</script>



