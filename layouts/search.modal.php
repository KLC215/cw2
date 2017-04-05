<!-- Dialog with Form Elements -->
<!--<div tabindex="-1" class="modal fade" id="search-dialog" style="display: none;" aria-hidden="true">-->
<!--	<div class="modal-dialog">-->
<!--		<div class="modal-content">-->
<!--			<div class="modal-header pmd-modal-bordered">-->
<!--				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>-->
<!--				<h2 class="pmd-card-title-text"><i class="material-icons md-dark pmd-md">search</i>Search stations</h2>-->
<!--			</div>-->
<!--			<div class="modal-body">-->
<!---->
<!--				<div class="form-group">-->
<!--					<label for="regular1" class="control-label">Search by</label>-->
<!--					<select id="selectSearch"-->
<!--							class="form-control selectpicker"-->
<!--							data-show-icon="true"-->
<!--							data-style="btn-primary">-->
<!--						<option value="0">&nbsp;&nbsp;Choose filter-->
<!--						</option>-->
<!--						<option value="and"-->
<!--								data-icon='glyphicon-flag'>&nbsp;&nbsp;Areas & District-->
<!--						</option>-->
<!--						<option value="location"-->
<!--								data-icon="glyphicon-map-marker">&nbsp;&nbsp;Location-->
<!--						</option>-->
<!--						<option value="type" data-icon="glyphicon-info-sign">&nbsp;&nbsp;Type</option>-->
<!--						<option value="provider" data-icon="glyphicon-asterisk">&nbsp;&nbsp;Provider</option>-->
<!--					</select>-->
<!--				</div>-->
<!--				<hr>-->
<!---->
<!--				<div class="form-group">-->
<!--					<div id="and">-->
<!--						<div class="form-group">-->
<!--							<label for="area" class="col-lg-2 control-label">Area</label>-->
<!--							<select class="form-control" id="area" name="area">-->
<!--							</select>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label for="district" class="col-lg-2 control-label">District</label>-->
<!--							<select class="form-control"-->
<!--									id="district"-->
<!--									name="district"-->
<!--									disabled>-->
<!--							</select>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!---->
<!---->
<!---->
<!--				<!--<div class="form-group pmd-textfield pmd-textfield-floating-label">-->
<!--					<label for="first-name">Email Address</label>-->
<!--					<input type="text" class="mat-input form-control" id="email" value="">-->
<!--				</div>-->
<!--				<div class="form-group pmd-textfield pmd-textfield-floating-label">-->
<!--					<label for="first-name">Mobile No.</label>-->
<!--					<input type="text" class="mat-input form-control" id="mobil" value="">-->
<!--				</div>-->
<!--				<div class="form-group pmd-textfield pmd-textfield-floating-label">-->
<!--					<label class="control-label">Message</label>-->
<!--					<textarea required class="form-control"></textarea>-->
<!--				</div>-->
<!--				<label class="checkbox-inline pmd-checkbox pmd-checkbox-ripple-effect">-->
<!--					<input type="checkbox" value="">-->
<!--					<span class="pmd-checkbox"> Accept Terms and conditions</span> </label>-->-->
<!--			</div>-->
<!--			<div class="pmd-modal-action">-->
<!--				<button data-dismiss="modal"-->
<!--						class="btn pmd-ripple-effect btn-primary"-->
<!--						type="button">Search-->
<!--				</button>-->
<!--				<button data-dismiss="modal" class="btn pmd-ripple-effect btn-default" type="button">Discard</button>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="searchModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Search stations</h4>
			</div>
			<div class="modal-body">

				<!-- Search filter -->
				<div class="form-group">
					<label for="selectSearch" class="control-label">Search by</label>
					<select id="selectSearch"
							class="form-control"
							name="selectSearch">
						<option disabled selected>&nbsp;&nbsp;Choose filter
						</option>
						<option value="and"
								data-icon='glyphicon-flag'>&nbsp;&nbsp;Areas & District
						</option>
						<option value="typeDiv" data-icon="glyphicon-info-sign">&nbsp;&nbsp;Type</option>
						<option value="providerDiv" data-icon="glyphicon-asterisk">&nbsp;&nbsp;Provider</option>
					</select>
				</div>

				<hr>

				<!-- Search by area and district -->
				<div class="form-group">
					<div id="and" class="childSearchForm" style="display: none">
						<div id="selectArea" class="form-group">
							<label for="area" class="col-lg-2 control-label">Area</label>
							<select class="form-control" id="area" name="area">
							</select>
							<span id="errorArea" style="color: red"></span>
						</div>
						<div id="selectDistrict" class="form-group">
							<label for="district" class="col-lg-2 control-label">District</label>
							<select class="form-control"
									id="district"
									name="district"
									disabled>
							</select>
							<span id="errorDistrict" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchAND" class="btn btn-success">Search</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Search by type -->
				<div class="form-group">
					<div id="typeDiv" class="childSearchForm" style="display: none">
						<div id="selectType" class="form-group">
							<label for="type" class="col-lg-2 control-label">Type</label>
							<select class="form-control" id="type" name="type">
							</select>
							<span id="errorType" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchType" class="btn btn-success">Search</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Search by provider -->
				<div class="form-group">
					<div id="providerDiv" class="childSearchForm" style="display: none">
						<div id="selectProvider" class="form-group">
							<label for="provider" class="col-lg-2 control-label">Provider</label>
							<select class="form-control" id="provider" name="provider">
							</select>
							<span id="errorProvider" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchProvider" class="btn btn-success">Search</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>