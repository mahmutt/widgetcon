<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?>
<div class="p-subtitle text-left">
	<span class="p-title-side">STRUCTURE  Input File details</span>
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
	
	<?php if($file_type=='microsat'): ?>
	<div class="col-sm-10 col-sm-offset-2">
		<!-- Start: how_microsat_coded <select> -->
		<div class="form-group">
			<label for="how_microsat_coded" class="p-label-required">The form of SSR alleles</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="how_microsat_coded" name="how_microsat_coded" placeholder="how_microsat_coded" required="required" class="form-control">
					<option class="p-select-default" value="number-of-repeats">coded as number of repeats</option>
					<option value="length-pcr-fragments">coded as the length of the PCR fragments</option>
					<option value="arbitrary-number">coded as an arbitrary number</option>
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
	
	<div class="col-sm-8 col-sm-offset-4" id="repeatSize_div" style="display:block;">
		<!-- Start: repeatSize_div <input:text> -->
		<div class="form-group">
			<label for="repeatSize" class="p-label-required">
			Enter the size of the repeated motif(same for all loci:different:comma separeted list)(e.q:2,2,3,2):
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
	
	<div class="col-sm-12">
		<!-- Start: ploidy_of_the_data <select> -->
		<div class="form-group">
			<label for="ploidy_of_the_data" class="p-label-required">Ploidy level?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="ploidy_of_the_data" name="ploidy_of_the_data" required="required" class="form-control">
					<option class="p-select-default" value="haploid">haploid</option>
					<option value="diploid_on_one_row">diploid(on one row)</option>
					<option value="diploid_on_two_consecutive_row">diploid(on two consecutive row)</option>
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
		<!-- End: ploidy_of_the_data <select> -->
	</div>
	
	<div class="col-sm-12">
		<!-- Start: missing_data_value_code <input:text> -->
		<div class="form-group">
			<label for="missing_data_value_code" class="p-label-required">
			Missing data is coded as(-9,-999,...):
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="missing_data_value_code" value="-9" name="missing_data_value_code" placeholder="eq:(-9,-999,...)" class="form-control" aria-required="true" required="required">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-code"></i></span>
			</div>
		</div>
		<!-- End: missing_data_value_code <input:text> -->
	</div>
	
	<div class="col-sm-12">
		<!-- Start: marker_names_included <select> -->
		<div class="form-group">
			<label for="marker_names_included" class="p-label-required">Is there a row of marker names?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="marker_names_included" name="marker_names_included" required="required" class="form-control">
					<option class="p-select-default" value="yes">Yes</option>
					<option value="no">No</option>
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
		<!-- End: marker_names_included <select> -->
		
	</div>
	
	<div class="col-sm-10 col-sm-offset-2" id="number_of_markers_in_the_input_file_div" style="display:none;">
		<!-- Start: number_of_markers_in_the_input_file <input:text> -->
		<div class="form-group">
			<label for="number_of_markers_in_the_input_file"  class="p-label-required">
			Enter the number of markers (loci) listed in the input file:
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="number_of_markers_in_the_input_file" name="number_of_markers_in_the_input_file" class="form-control"  aria-required="true">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-required-text"><i class="fa fa-star"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-code"></i></span>
			</div>
		</div>
		<!-- End: number_of_markers_in_the_input_file <input:text> -->
	</div>
	
	<div class="col-sm-12">
		<!-- Start: individual_name_included <select> -->
		<div class="form-group">
			<label for="individual_name_included" class="p-label-required">Are individual names present?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="individual_name_included" name="individual_name_included" required="required" class="form-control">
					<option class="p-select-default" value="yes">Yes</option>
					<option value="no">No</option>
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
		<!-- End: individual_name_included <select> -->
		
	</div>
	
	<div class="col-sm-12">
		<!-- Start: popdata_present <select> -->
		<div class="form-group">
			<label for="popdata_present" class="p-label-required">Is there a specific coulumn of population information (e.g. PopData) present?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="popdata_present" name="popdata_present" required="required" class="form-control">
					<option class="p-select-default" value="yes">Yes</option>
					<option value="no">No</option>
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
		<!-- End: popdata_present <select> -->
		
	</div>
	
</div>
<script type="text/javascript">

$('#how_microsat_coded').on('change', function (e) {
	how_microsat_coded = this.value;
	$( "input[name='repeatSize']" ).val('');
	if(how_microsat_coded=='number-of-repeats'){
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

$('#marker_names_included').on('change', function (e) {
	marker_names_included = this.value;
	$( "input[name='number_of_markers_in_the_input_file']" ).val('');
	if(marker_names_included=='no'){
		$('#number_of_markers_in_the_input_file_div').show();
		$( "input[name='number_of_markers_in_the_input_file']" ).removeAttr('disabled');
		$( "input[name='number_of_markers_in_the_input_file']" ).attr('required','required');
		
		//alert(marker_names_included+','+output_format);
	}else{
		$('#number_of_markers_in_the_input_file_div').hide();
		$( "input[name='number_of_markers_in_the_input_file']" ).attr('disabled','disabled');
		$( "input[name='number_of_markers_in_the_input_file']" ).removeAttr('required');
	}
});
</script>