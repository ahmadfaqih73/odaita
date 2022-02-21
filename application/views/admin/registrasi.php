<!DOCTYPE html>
<html lang="en">

<head>

<?php $this->load->view("admin/templates/header.php") ?>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
               
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="<?= base_url('admin/registration/store') ?>" method="post" enctype="multipart/form-data" >
								<div class="form-group">
									<label for="username">Username*</label>
									<input class="form-control" required
									type="text" name="username" placeholder="username" />
								</div>

								<div class="form-group">
									<label for="nama_lengkap">Nama_lengkap*</label>
									<input class="form-control" required
									type="text" name="nama_lengkap" placeholder="nama_lengkap" />
								</div>
								
								<div class="form-group">
									<label for="email">Email*</label>
									<input class="form-control" required
									type="text" name="email" placeholder="email" />
								</div>

								<div class="form-group">
									<label for="password">Password*</label>
									<input class="form-control" required
							   		type="text" name="password" placeholder="password" />
						   		</div>

								<div class="form-group">
									<label for="alamat">Alamat*</label>
									<textarea class="form-control" required
									name="alamat" placeholder="alamat..."></textarea>

								</div>

								<div class="form-group">
									<label for="jenis_kelamin">Jenis_kelamin*</label>
									<select class="form-control" name="jenis_kelamin" required>
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
								</div>

								<div class="form-group">
									<label for="phone">Phone*</label>
									<input class="form-control "
									type="number" name="phone" min="0" placeholder="phone" required />
								</div>
		
							<button class="btn btn-success" type="submit" name="btn">simpan</button>
						</form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php $this->load->view("admin/templates/js.php") ?>

</body>

</html>