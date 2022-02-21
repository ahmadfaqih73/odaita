

				<!-- DataTables -->
				<?= $this->session->flashdata('success') ?>
				
				<div class="card mb-3">
				<form method="POST" action="customer_h/addQuisioner">
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
										<th>Harapan</th>
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
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="TPG" id="flexRadioDefault1">
											<label class="form-check-label" for="flexRadioDefault1">
												TPG
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="KPG" id="flexRadioDefault1">
											<label class="form-check-label" for="flexRadioDefault1">
												KPG
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="CPG" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												CPG
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="PG" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												PG
											</label>
											</div>
											<div class="form-check mr-1"">
											<input class="form-check-input" required type="radio" name="kepuasan<?= $i?>" value="SPG" id="flexRadioDefault2" >
											<label class="form-check-label" for="flexRadioDefault2">
												SPG
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

			