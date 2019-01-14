<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];

include '../php/app.php';
$app=new app();
?>
<div class="p-subtitle text-left">
	<span class="p-title-side">FASTA  Input File details</span>
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
	
	<?php if($file_type=='snp'): ?>
	
	<div class="col-sm-12">
		<!-- Start: ploidy_of_the_data <select> -->
		<div class="form-group">
			<label for="ploidy_of_the_data">Ploidy level?</label>
			<label class="input-group p-has-icon p-custom-arrow">
				<select id="ploidy_of_the_data" name="ploidy_of_the_data" class="form-control">
					<option class="p-select-default" value="haploid">haploid</option>
					<option value="diploid">diploid</option>
				</select>
				<span class="p-field-cb"></span>
				<span class="p-select-arrow"><i class="fa fa-caret-down"></i></span>
				<span class="input-group-icon"><i class="fa fa-file-text-o"></i></span>
			</label>
		</div>
		<!-- End: ploidy_of_the_data <select> -->
	</div>
	
	<?php endif;?>
	
</div>




