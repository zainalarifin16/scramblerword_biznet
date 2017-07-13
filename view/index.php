<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Scrambler Word Biz</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta property="og:url"           content="http://www.your-domain.com/your-page.html" id="og_url" />
		<meta property="og:type"          content="website" id="og_type" />
		<meta property="og:title"         content="Your Website Title" id="og_title" />
		<meta property="og:description"   content="Your description" id="og_desc" />
		<meta name="Description" lang="en" content="Scrambler Word Biz">
		<meta name="author" content="Zainal Arifin, Biznet Gio">
		<meta name="robots" content="index, follow">

		<!-- icons -->
		<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
		<link rel="shortcut icon" href="favicon.ico">

		<!-- Override CSS file - add your own CSS rules -->
		<link rel="stylesheet" href="assets/css/styles.css">
	</head>
	<body>
		<div class="content">
			<div class="container">
				<div class="main">
					<h1 align="center" >Scrambler Word Biz</h1>
					<hr>
					<center><button id="play_now" >Play Now</button></center>
					<form id="form_game" style="display: none;" align="center" >
						<div style="float:left;" > HIGH SCORE : </div><h3 id="high_score_game" style="float:left;" ></h3>
						<br>
						<br>
						<div style="float:left;" > SCORE : </div><h3 id="score_game" style="float:left;" ></h3>
						<br>
						<br>
						
						<div>
							<h2 id="feedback" style="color:green;display: none;" >feedback SCRAMBLER</h2>
						</div>
						<div>
							<h2 id="question_game" >SOAL SCRAMBLER</h2>
						</div>
						<div>
							<input type="text" name="input_user">
						</div>
						<div>
							<button type="submit" >Submit</button>
						</div>
						<br>
						<div>
							<a id="share_fb" href="#" >Share Facebook</a>
						</div>
						<div>
							<a id="share_twitter" class="twitter-share-button"
							  href="#">
							Tweet</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container" >
				Zainal Arifin &copy; Copyright 2017
			</div>
		</div>
	</body>
	<!-- SCRIPT -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>
	<script type="text/javascript" src="assets/js/core.js" ></script>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '1444530282298964',
	      xfbml      : true,
	      version    : 'v2.9'
	    });
	    FB.AppEvents.logPageView();
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
</html>