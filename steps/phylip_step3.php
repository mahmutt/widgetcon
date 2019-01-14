<?php
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?><div class="p-subtitle text-left">
	<span class="p-title-side">PHYLIP Input File details</span>
</div>

<div class="row">
	<div class="col-sm-12">
		<!-- Start: what_type_of_data <select> -->
		<div class="form-group">
			<label for="what_type_of_data" class="p-label-required">Data type?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="what_type_of_data" name="what_type_of_data" placeholder="what_type_of_data" required="required" disabled="disabled" class="form-control">
					<option class="p-select-default" value="moleculer-sequence-data">molecular sequence data</option>
					<option value="distance-matrix" <?=$file_type=="distance"?"selected":""?>>distance matrix</option>
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
		<!-- End: what_type_of_data <select> -->
		
	</div>
	
	<div class="col-sm-10 col-sm-offset-2"  id="distanceMatrix_div" style="<?=$file_type=="distance"?"display:block":"display:none"?>">
		<!-- Start: specify_format_distance_matrix <select> -->
		<div class="form-group">
			<label for="specify_format_distance_matrix" class="p-label-required">Specify the format the distance matrix?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="specify_format_distance_matrix" name="specify_format_distance_matrix" placeholder="specify_format_distance_matrix" required="required" class="form-control">
					<option class="p-select-default" value="lower-triangular">lower-triangular</option>
					<option value="square-matrix">square-matrix(both)</option>
					<option value="upper-triangular-with-diagonal">upper-triangular(with diagonal)</option>
					<option value="upper-triangular-no-diagonal">upper-triangular(no diagonal)</option>
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
		<!-- End: specify_format_distance_matrix <select> -->
		
	</div>
	<?php if($file_type!=="distance"):?>
	<div class="col-sm-12" id="formatOfData_div">
		<!-- Start: specify_format_of_data <select> -->
		<div class="form-group">
			<label for="specify_format_of_data" class="p-label-required">Specify Data Format</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="specify_format_of_data" name="specify_format_of_data" placeholder="specify_format_of_data" required="required" class="form-control">
					<option class="p-select-default" value="simple-one-row">simple(one row)</option>
					<option value="interleaved">interleaved</option>
					<option value="sequential">sequential(noninterleaved)</option>
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
	<?php endif; ?>
	
	<div class="col-sm-12">
		<!-- Start: is_it_a_relaxed_format <select> -->
		<div class="form-group">
			<label for="is_it_a_relaxed_format" class="p-label-required">Is it a relaxed PHYLIP format?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="is_it_a_relaxed_format" name="is_it_a_relaxed_format" placeholder="is_it_a_relaxed_format" required="required" class="form-control">
					<option class="p-select-default" value="no">No</option>
					<option value="yes">Yes</option>
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
		<!-- End: is_it_a_relaxed_format <select> -->
	</div>
	
	
</div>

<script type="text/javascript">

$('#what_type_of_data').on('change', function (e) {
	what_type_of_data = this.value;
	$( "input[name='specify_format_distance_matrix']" ).val('');
	if(what_type_of_data=='distance-matrix'){
		/*distance matrix seçilirse, matrix türleri görünecek ve aktif olacak*/
		$('#distanceMatrix_div').show();
		$( "input[name='specify_format_distance_matrix']" ).removeAttr('disabled');
		$( "input[name='specify_format_distance_matrix']" ).attr('required','required');
		
		/*distance matrix seçilirse, specify_format_of_data gizlenecek ve inaktif olacak*/
		$('#formatOfData_div').hide();
		$( "input[name='specify_format_of_data']" ).attr('disabled','disabled');
		$( "input[name='specify_format_of_data']" ).removeAttr('required');
		
	}else{
		$('#distanceMatrix_div').hide();
		$( "input[name='specify_format_distance_matrix']" ).attr('disabled','disabled');
		$( "input[name='specify_format_distance_matrix']" ).removeAttr('required');
		
		$('#formatOfData_div').show();
		$( "input[name='specify_format_of_data']" ).removeAttr('disabled');
		$( "input[name='specify_format_of_data']" ).attr('required','required');
	}
});


</script>


