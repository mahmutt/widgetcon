<?php 
$file_name		=$_POST['file_name'];
$input_format	=$_POST['input_format'];
$output_format	=$_POST['output_format'];
$file_type		=$_POST['file_type'];
$data_read		='not_read';
include '../php/arlequin/arlequin_parser.php';
$arlequin=new arlequin_parser();
$dizi=$arlequin->parser($file_name,$data_read);
?>

<div class="p-subtitle text-left">
	<span class="p-title-side">Details of the Arlequin Input File</span>
</div>
<!-- End: subtitle -->
<?php if(strtolower($file_type)!=strtolower($dizi['header']['DataType'])):?>
<div class="alert alert-error">
	<strong><i class="fa fa-times"></i> Warning:</strong> Input file data type is not corresponding with selected data type.
</div>
<?php endif;?>
<div class="row">
	<div class="col-sm-12">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Title of the Data File</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['Title']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Number of Samples (Populations)</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['NbSamples']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Type of Molecular Data</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['DataType']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Genotypic Data</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['GenotypicData']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Locus Separator</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['LocusSeparator']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Mising Data Code</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['MissingData']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Gametic Phase Information</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['GameticPhase']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Recessive Data Infromation</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?=$dizi['header']['RecessiveData']?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
	<div class="col-sm-6">
		<!-- Start: text <input:text> -->
		<div class="form-group p-field-disabled">
			<label for="text">Input Data File Format</label>
			<div class="input-group p-has-icon">
				<input type="text" id="text" name="text" placeholder="<?= $input_format?>" disabled="disabled" class="form-control">
				<span class="input-group-state">
					<span class="p-position">
						<span class="p-text">
							<span class="p-valid-text"><i class="fa fa-check"></i></span>
							<span class="p-error-text"><i class="fa fa-times"></i></span>
						</span>
					</span>
				</span>
				<span class="p-field-cb"></span>
				<span class="input-group-icon"><i class="fa fa-pencil-square-o"></i></span>
			</div>
		</div>
		<!-- End: text <input:text> -->
	</div>
</div>

