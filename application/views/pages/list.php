

				<!-- DataTables -->
				<?= $this->session->flashdata('success') ?>
				
				<div class="card mb-3">
				<form method="POST" action="customer_p/addQuisioner">
					<div class="card-header">
						<a href="<?php echo site_url('admin/users/add') ?>"><i class=""></i></a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th>Dimensi</th>
										<th width="50%">Pernyataan</th>
										<th>Persepsi</th>
									</tr>
								</thead>
								<tbody>
								
									<?php 
									$i=0;
									foreach ($pernyataan as $pernyataan): ?> 
									<tr>
										<td>
											<?php echo $i ?>
											<input class="form-control" name="id_pernyataan[]" hidden  value="<?= $pernyataan->id ?>" >
											<input class="form-control" name="id_dimensi<?= $i ?>" hidden  value="<?= $pernyataan->id_dimensi ?>" >
										</td>
										<td>
											<?php echo $pernyataan->dimensi ?>
										</td>
										<td>
											<?php echo $pernyataan->pernyataan ?>
										</td>
										<td class="row">
											<div class="form-check mr-1">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="TP" id="flexRadioDefault1">
											<label class="form-check-label" for="flexRadioDefault1">
												TP
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="KP" id="flexRadioDefault1">
											<label class="form-check-label" for="flexRadioDefault1">
												KP
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="CP" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												CP
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="P" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												P
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="SP" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												SP
											</label>
											</div>
										</td>
									</tr>
									
									<?php $i++; endforeach; ?>

								</tbody>
							</table>
							<div class="form-group"> 
								<label>Kritik & saran</label>
								<textarea class="form-control" name="kritik"></textarea>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-success" type="submit">Submit</button>		
					</div>
					</form>
				</div>

			