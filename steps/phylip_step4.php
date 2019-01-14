<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?>
<!-- Start: subtitle -->
<div class="p-subtitle text-left">
	<span class="p-title-side">You May Select Expected Output File Details</span>
</div>
<!-- End: subtitle -->
<div class="row">
	<div class="col-sm-12">
		<!-- Start: file_type <select> -->
		<div class="form-group p-field-disabled">
			<label for="file_type" class="p-label-required">Specify which data type should be included in the PHYLIP file(PHYLIP can only analyze one data per file)</label>
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
	<div class="col-sm-12">
		<!-- Start: kind_of_file <select> -->
		<div class="form-group">
			<label for="kind_of_file">Select the kind of data you want to write:</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="kind_of_file" name="kind_of_file" class="form-control" disabled="disabled">
					<option class="p-select-default" value="sequence_data">Sequence Data</option>
					<option value="distance_matrix" <?=$file_type=="distance"?"selected":""?>>Distance Matrix</option>
				</select>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: kind_of_file <select> -->
	</div>
	<div class="col-sm-12">
		<!-- Start: relaxed_format <select> -->
		<div class="form-group">
			<label for="relaxed_format">Save relaxed PHYLIP format(e.q for RAxML):</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="relaxed_format" name="relaxed_format" class="form-control">
					<option class="p-select-default" value="no">No</option>
					<option value="yes">Yes</option>
				</select>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: relaxed_format <select> -->
	</div>
	<?php if(1==0):?>
	<div class="col-sm-12">
		<!-- Start: phylip_parser <input:text> -->
		<div class="form-group">
			<label for="phylip_parser">
			Specify the locus/locus combination you want to write to the PHYLIP file
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="phylip_parser" name="phylip_parser" placeholder="" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</div>
		</div>
		<!-- End: phylip_parser <input:text> -->
	</div>
	<?php endif;?>
</div>
