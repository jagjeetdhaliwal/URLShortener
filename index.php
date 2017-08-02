<?php include_once 'includes/application_top.php';
	// if (!empty($_SESSION['userdetails'])) {
	// 	$data = $_SESSION['userdetails'];
	// }
?>
<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="css/main.css"  media="screen,projection"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Best URL Shortener Ever</title>
</head>

<body>
	<header class="body">
		<nav class="white" role="navigation">
		</nav>
    </header>

    <section class="body">
		<div class="container" id="shorten">
			<div class="section">
				<div class="row">
					<div class="col s12 center">
						<h4 class="contact-h4">Get Shareable links forever for FREE</h4>
						<form id="url_form" method="post" action="php/url_shortener.php">
							<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']?>" />
							<div class="row">
								<div class="input-field col s12">
									<input id="url" name="url" type="text" class="validate">
									<label for="url">URL</label>
									<div id="url_error" class="error-label">Paste a URL to shorten it</div>
								</div>
							</div>
						    <button class="btn waves-effect waves-light" id="url_form_submit" type="submit" name="action">Submit
								<i class="material-icons right">Shorten</i>
							</button>
						</form>

						<div class="form-message"></div>
					</div>
				</div>
			</div>
		</div>
    </section>

    <footer class="page-footer teal">
	    <div class="container">
	    </div>
	</footer>

    <!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>
