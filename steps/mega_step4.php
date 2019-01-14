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
			<label for="file_type" class="p-label-required">Data type in the MEGA file as output</label>
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
		<!-- Start: kind_of_data <select> -->
		<div class="form-group">
			<label for="kind_of_data">Select the kind of data you want to print:</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="kind_of_data" name="kind_of_data" class="form-control" disabled="disabled">
					<option class="p-select-default" value="sequence_data">Sequence Data</option>
					<option value="distance_matrix" <?=$file_type=="distance"?"selected":""?>>Distance Matrix</option>
				</select>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: kind_of_data <select> -->
	</div>
	
	<?php if($file_type=='snp' && (1==0)): ?>
	<div class="col-sm-12">
		<!-- Start: integer_that_codes_for_nuleotide <input:text> -->
		<div class="form-group">
		
			<label for="integer_that_codes_for_nuleotide_A">
			Numeric SNP data:enter the integer that codes for nucleotide A:
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="integer_that_codes_for_nuleotide_A" name="integer_that_codes_for_nuleotide_A" placeholder="for example:1" class="form-control">
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
		<div class="form-group">	
			<label for="integer_that_codes_for_nuleotide_C">
			Numeric SNP data:enter the integer that codes for nucleotide C:
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="integer_that_codes_for_nuleotide_C" name="integer_that_codes_for_nuleotide_C" placeholder="for example:2" class="form-control">
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
		<div class="form-group">	
			<label for="integer_that_codes_for_nuleotide_G">
			Numeric SNP data:enter the integer that codes for nucleotide G:
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="integer_that_codes_for_nuleotide_G" name="integer_that_codes_for_nuleotide_G" placeholder="for example:3" class="form-control">
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
		<div class="form-group">	
			<label for="integer_that_codes_for_nuleotide_T">
			Numeric SNP data:enter the integer that codes for nucleotide T:
			</label>
			<div class="input-group p-has-icon">
				<input type="text" id="integer_that_codes_for_nuleotide_T" name="integer_that_codes_for_nuleotide_T" placeholder="for example:4" class="form-control">
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
		<!-- End: integer_that_codes_for_nuleotide <input:text> -->
	</div>
	<?php endif;?>
</div>
