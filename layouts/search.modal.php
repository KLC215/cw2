<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="searchModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" tkey="searchStations">Search stations</h4>
			</div>
			<div class="modal-body">

				<!-- Search filter -->
				<div class="form-group">
					<label for="selectSearch" class="control-label" tkey="searchBy">Search by</label>
					<select id="selectSearch"
							class="form-control"
							name="selectSearch">
						<option disabled selected tkey="filter">&nbsp;&nbsp;Choose filter
						</option>
						<option value="and"
								data-icon='glyphicon-flag' tkey="areaDistrict">&nbsp;&nbsp;Areas & District
						</option>
						<option value="typeDiv" data-icon="glyphicon-info-sign" tkey="type">&nbsp;&nbsp;Type</option>
						<option value="providerDiv"
								data-icon="glyphicon-asterisk"
								tkey="provider">&nbsp;&nbsp;Provider
						</option>
					</select>
				</div>

				<hr>

				<!-- Search by area and district -->
				<div class="form-group">
					<div id="and" class="childSearchForm" style="display: none">
						<div id="selectArea" class="form-group">
							<label for="area" class="col-lg-2 control-label" tkey="area">Area</label>
							<select class="form-control" id="area" name="area">
							</select>
							<span id="errorArea" style="color: red"></span>
						</div>
						<div id="selectDistrict" class="form-group">
							<label for="district" class="col-lg-2 control-label" tkey="district">District</label>
							<select class="form-control"
									id="district"
									name="district"
									disabled>
							</select>
							<span id="errorDistrict" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchAND" class="btn btn-success" tkey="search">Search</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Search by type -->
				<div class="form-group">
					<div id="typeDiv" class="childSearchForm" style="display: none">
						<div id="selectType" class="form-group">
							<label for="type" class="col-lg-2 control-label" tkey="type">Type</label>
							<select class="form-control" id="type" name="type">
							</select>
							<span id="errorType" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchType" class="btn btn-success" tkey="search">Search</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Search by provider -->
				<div class="form-group">
					<div id="providerDiv" class="childSearchForm" style="display: none">
						<div id="selectProvider" class="form-group">
							<label for="provider" class="col-lg-2 control-label" tkey="provider">Provider</label>
							<select class="form-control" id="provider" name="provider">
							</select>
							<span id="errorProvider" style="color: red"></span>
						</div>
						<div class="modal-footer">
							<div class="pull-right">
								<button id="searchProvider" class="btn btn-success" tkey="search">Search</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>