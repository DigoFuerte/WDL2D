<?php
include_once "./php/header.php";
include_once "./php/data_model.php";

if (isset($_SESSION['user_details'])) {
    header("Location:profile.php");
}

// let's process the form

$has_error = false;
if (isset($_POST['login'])) {

	// validate user email input
	if (empty($_POST['email'])) {
		$error_email = "Please enter email";
		$has_error = true;			
	} 
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
		$error_email = "Please enter valid email";
		$has_error = true;			
	} 
	else {
		$email = filterUserInput($_POST['email']);
	}
					
	// validate user password input
	if (empty($_POST['password'])) {
		$error_password= "Please enter password";
		$has_error = true;	
	} 
	else  {
		$password = filterUserInput($_POST['password']);
	}

	//* login details entered validated OK
	if (!$has_error) {	
		if($user_details = login_user($email, $password)) {
				$_SESSION['user_details'] = $user_details;
				header("Location:profile.php");				
		} 
		else {
			$error_login = "Invalid login details!";
		}
	}
}
?>

<div class="container-fluid bg-div" style="padding-top:100px; padding-bottom:100px;">
	<div class="col-md-6 offset-md-3 mt-0 ">
		<span class="anchor" id="formContact"></span>
		<div class="card-header p-0">

			<div class="bg-info text-white text-center rounded-top py-2 sign-bg-high">
				<h3><i class="fas fa-sign-in-alt sign-fg-med"></i> Sign in</h3>
			</div>
			<div class=" card-body rounded-bottom sign-bg-low">
				<form class="form" action="" method="post" role="form">
					<?php 					
					if(isset($error_login)){
						echo "<div class='alert alert-danger text-center font-weight-bold' role='alert'> Invalid Login!</div>";
					}
					?>
					<div class="form-group">
						<label for="email" class="mb-0"><strong>Email</strong></label>
						<?php if (isset($error_email) ){?>
						<div class="alert alert-danger" role="alert">
							<strong><?=$error_email; ?> </strong>
						</div>
						<?php } ?>

						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fa fa-envelope text-info sign-fg-low"></i>
								</div>
							</div>
							<input type="text" name="email" id="email" class="form-control"
								value="<?php if(isset($email))echo $email;?>" aria-describedby="emailHelp"
								placeholder="john.doe@gmail.com">
						</div>
					</div>
					
					<div class="form-group">
						<label for="password" class="mb-0"><strong>Password</strong></label>
						<?php if(isset($error_password)){?>
						<div class="alert alert-danger" role="alert">
							<strong><?=$error_password; ?> </strong>
						</div>
						<?php } ?>

						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fa fa-lock sign-fg-low"></i></div>
							</div>
							<input type="password" name="password" id="password" class="form-control"
								value="<?php if(isset($password))echo $password;?>" aria-describedby="emailHelp" placeholder="********">
						</div>
					</div>

					<button type="submit" id="submit" name="login" 
									class="btn-hover btn btn-info btn-block rounded-bottom py-2 sign-bg-high">
						<h3 style="display:inline;">Sign in <i class="fas fa-sign-in-alt sign-fg-high" style="color:#C5D984" aria-hidden="true"></i></h3> 
					</button>
					<p class="text-center mt-2 mb-0">
						<strong>Did not sign up?</strong> 
						<a href="sign_up.php"><strong>Sign up now</strong></a> 
					</p>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
include_once "./php/footer.php";
?>