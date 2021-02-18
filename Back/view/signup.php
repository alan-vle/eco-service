<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
</head>

<body>

<div class="container-fluid" id="content">
	<div class="row forum-div text-center">
		<div class="col-md-4 offset-md-4">
			<!--Formulaire-->
			<div class="card wow fadeIn" data-wow-delay="0.3s">
				<div class="card-body" style="background:#fff;">
					<!--Titre formulaire-->
					<div class="form-header">
							<h3><i class="fas fa-user mt-2 mb-2"></i>S'inscrire</h3>
					</div>

					<!--Corps formulaire-->
					<div class="p-2">
						<form class="custom-card-form" method="POST" action="../controller/CustomerController.php">
						<?php
						if (isset($_GET['errorPass']) || isset($_GET['notValidMail']) || isset($_GET['errorMail'])) {
							?>
							<p class="alert alert-danger" role="alert">
								<?php
								if(isset($_GET['errorPass'])) {
									echo 'mots de passe different !';
								}
								elseif (isset($_GET['notValidMail'])) {
									echo 'format email non conforme !';
								}
								elseif (isset($_GET['errorMail'])) {
									echo 'email deja utilisé !';
								}
								?>
							</p>
						<?php
						}?>

							<div class="form-group">
								<label class="required">Votre pseudo</label>
								<input type="text" value="" name="name" id="inputName" class="form-control" required="" autofocus="">
							</div>
							<div class="form-group">
								<label class="required">Votre email</label>
								<input type="text" value="" name="email" id="inputEmail" class="form-control" required="">
							</div>
							<div class="form-group">
								<label class="required">Votre mot de passe</label>
								<input type="password" name="password" id="inputPassword" data-toggle="password" class="form-control" required="">
							</div>
							<div class="form-group">
								<label class="required">Confirmation du mot de passe</label>
								<input type="password" name="password-repeat" id="inputPasswordRepeat" data-toggle="password" class="form-control" required="">
							</div>

							<div class="form-check">
								<input type="checkbox" id="registration_form_cdn" name="registration_form[cdn]" required="required" class="form-check-input" value="1">
								<label class="form-check-label required" for="registration_form_cdn"> Accepter les conditions générales d'utilisation</label>
							</div>
							<div class="text-center btn-custom">
									<button type="submit" class="btn btn-lg" name="signUp">S'inscrire</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>