<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div id="page">
		<div class="container-flex" id="content">
			<div class="container w-85 forum-div">
				<div class="h-100 d-flex justify-content-center align-items-center" style="height: calc(100vh - 181px )!important;">
					<div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">
						<!--Formulaire-->
						<div class="card wow fadeIn" data-wow-delay="0.3s">
							<div class="card-body" style="background:#fff;">
								<!--Titre formulaire-->
								<div class="form-header main-color">
										<h3><i class="fas fa-user mt-2 mb-2"></i>Se connecter</h3>
								</div>

								<!--Corps formulaire-->
								<div class="p-2">
									<form method="post" action="../controller/CustomerController.php">
										<label class="lbl-error"><?php if(isset($_GET['msg'])) {echo $_GET['msg'];}?></label>
										<div class="form-group">
											<label for="inputEmail" class="required">Votre email</label>
											<input type="email" value="" name="email" id="inputEmail" class="form-control" required="" autofocus="">
										</div>
										<div class="form-group">
											<label for="inputPassword" class="required">Votre mot de passe</label>
											<input type="password" name="password" id="inputPassword" data-toggle="password" class="form-control" required="">
										</div>
										<div class="text-center btn-custom">
												<button type="submit" name="connect" class="btn btn-lg">Se connecter</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>