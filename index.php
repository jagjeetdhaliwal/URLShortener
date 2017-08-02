<?php include_once 'includes/application_top.php';
	// if (!empty($_SESSION['userdetails'])) {
	// 	$data = $_SESSION['userdetails'];
	// }

	require_once(__DIR__ . '/modules/ShortUrl.php');
	require_once(__DIR__ . '/modules/UrlManager.php');
	
	if (isset($_GET['goto']) && $_GET['goto']) {
		// Check in redis if the short url exists for faster read.
		$redis = new Redis();
		$redis->connect(REDIS_URL_HOST, REDIS_URL_PORT);
		$destination_url = $redis->get(trim($_GET['goto']));
		
		// if we can't find in redis, check it in the database.
		if (!$destination_url) {
			$URL = new ShortUrl(trim($_GET['goto']));
			if ($URL->id) {
				$destination_url = $URL->destination_url;
			}
		}

		// if the url doesn't exist, we do a soft failure by loading our home screen.
		// if it exists, then we redirect to the corresponding destination url
		if ($destination_url) {
			header("Location: ".$destination_url);
			die();
		}
	}

	//Fetch historically generated urls
	$historic_urls = \UrlManager::getLastFiveURLs();

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
									<label for="url">Paste a URL to shorten it</label>
									<div id="url_error" class="error-label">Please enter a valid URL</div>
								</div>
							</div>
						    <button class="btn waves-effect waves-light" id="url_form_submit" type="submit" name="action">Shorten</button>
						</form>

						<div class="form-message"></div>
					</div>
				</div>
			</div>
		</div>
	<div id="recent" class="container">
	</div>
		<div class="container">
			<h4>History</h4>
			<?php foreach ($historic_urls as $url) { ?>
				<div class="url_card">
					<a class="from_url" target="_blank" href="<?php echo HOST.$url['short_url']; ?>" ><?php echo $url['short_url']; ?></a>
					<div class="to_url"><?php echo $url['destination_url']; ?> </div>
				</div>
			<?php } ?>
		</div>
    </section>

    <!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/shorten.js"></script>
</body>

</html>
