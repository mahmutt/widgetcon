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
			<label for="file_type" class="p-label-required">Data type in FASTA file (Data from multiple individuals will be stacked to a multi- FASTA file)</label>
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
		<!-- Start: save_sequence_on_single_line <select> -->
		<div class="form-group">
			<label for="save_sequence_on_single_line" class="p-label-required">Do you want to save sequence on a single line?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="save_sequence_on_single_line" name="save_sequence_on_single_line" placeholder="save_sequence_on_single_line" required="required" class="form-control">
					<option class="p-select-default" value="yes">yes</option>
					<option value="no">no</option>
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
		<!-- End: save_sequence_on_single_line <select> -->
		
	</div>
</div>
