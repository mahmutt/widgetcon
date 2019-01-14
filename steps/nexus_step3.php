<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?><div class="p-subtitle text-left">
	<span class="p-title-side">Nexus  Input File details</span>
</div>

<div class="row">
	<div class="col-sm-12">
		<!-- Start: TaxSet <select> -->
		<div class="form-group">
			<label for="taxset" class="p-label-required">Do you want the output file includes the nonspecified sequences within TaxSet?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="taxset" name="taxset" placeholder="Type of the data" class="form-control" required="required">
					<option class="p-select-default" value="no">No</option>
					<option class="" value="yes">Yes</option>
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
		<!-- End: TaxSet <select> -->
	</div>
	<div class="col-sm-12">
		<!-- Start: specify_format_of_data <select> -->
		<div class="form-group">
			<label for="specify_format_of_data" class="p-label-required">Specify the format of the data?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="specify_format_of_data" name="specify_format_of_data" placeholder="specify_format_of_data" required="required" class="form-control">
					<option  class="p-select-default" value="sequential">Sequential (Non-interleaved)</option>
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
</div>




