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
			<label for="file_type" class="p-label-required">Specify which data type should be included in the NEXUS file</label>
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
	<?php if($file_type=='snp'): ?>
	<div class="col-sm-12">
		<!-- Start: convertSNpsIntoBinary <select> -->
		<div class="form-group">
			<label for="convertSNpsIntoBinary" class="p-label-required">Do you want to convert SNPs into binary format?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="convertSNpsIntoBinary" name="convertSNpsIntoBinary" required="required" placeholder="" class="form-control">
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
		<!-- End: convertSNpsIntoBinary <select> -->
	</div>
	<?php endif;?>
</div>
