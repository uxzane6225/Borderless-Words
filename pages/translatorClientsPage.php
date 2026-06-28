<?php
session_start();
require('../processors/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Translators | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/main.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("navbar.php") ?>
	<main id="translatorsPage" class="mainPagesBody">
		<aside class="filters">
			<h2>Filters</h2>
			<div id="languages" class="categories">
				<h3>Languages</h3>
				<label><input type="checkbox" class="checkBox"> English</label>
				<label><input type="checkbox" class="checkBox"> Filipino</label>
				<label><input type="checkbox" class="checkBox"> Spanish</label>
				<label><input type="checkbox" class="checkBox"> German</label>
				<label><input type="checkbox" class="checkBox"> Portuguese</label>
				<label><input type="checkbox" class="checkBox"> Russian</label>
			</div>
			<div id="work" class="categories">
				<h3>Work Style</h3>
				<label><input type="checkbox" class="checkBox"> On-site</label>
				<label><input type="checkbox" class="checkBox"> Remote</label>
				<label><input type="checkbox" class="checkBox"> Hybrid</label>
			</div>
		</aside>
		<section id="translatorsList">
			<article class="translatorArticle">
				<img src="">
				<div class="translatorContent">
					<div class="translatorDescription">
						<h2>Display Name</h2>
						<p>Description</p>
					</div>
					<div class="translatorBottom">
						<p>Rating 5.0</p>
						<p class="language">language</p>
					</div>
				</div>
			</article>
			<article class="translatorArticle">
				<img src="">
				<div class="translatorContent">
					<div class="translatorDescription">
						<h2>Display Name</h2>
						<p>Description</p>
					</div>
					<div class="translatorBottom">
						<p>Rating 5.0</p>
						<p class="language">language</p>
					</div>
				</div>
			</article>
			<article class="translatorArticle">
				<img src="">
				<div class="translatorContent">
					<div class="translatorDescription">
						<h2>Display Name</h2>
						<p>Description</p>
					</div>
					<div class="translatorBottom">
						<p>Rating 5.0</p>
						<p class="language">language</p>
					</div>
				</div>
			</article>
		</section>
	</main>
</body>
</html>