<?php
	include_once 'config.php';
	include_once 'util.php';
	if (!logged_in() || !is_admin()) {
		header('Location: '.$app_root);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Giftbox - Admin</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/create.css" />
</head>
<body>
	<div id="content-wrapper">
		<div class="header-wrapper" id="create-header-wrapper">
			<header>
				<h1>
					<a id="create-home-icon" title="Return to the Homepage" href="<?php echo $app_root ?>">Giftbox</a>
				</h1>
				<nav id="create-top-nav">
					<ul>
						<li>
							<a href="<?php echo $app_root ?>">Home</a>
						</li>
					</ul>
				</nav>
			</header>
		</div>
		<div id="centering-wrapper">
			<a class="pure-button" href="manage_users.php">Manage Users</a>
		</div>
	</div>
</body>
</html>