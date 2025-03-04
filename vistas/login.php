<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include_once("head.php");
    ?>
</head>
<body>
    <section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="asset/images/logo.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4 text-secondary">Inicio de Sesión</h1>
							<form method="POST" novalidate="" id="login">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Correo electrónico</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Contraseña</label>
										<a href="#" class="float-end">
											Recuperar Clave
										</a>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
									<div class="valid-feedback">
                                        Looks good!
                                    </div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Ingresar
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								No tienes una cuenta <a href="#" class="text-dark">Crear una</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2024 &mdash; MiEmpresita.com
					</div>
				</div>
			</div>
		</div>
	</section>

</body>
</html>