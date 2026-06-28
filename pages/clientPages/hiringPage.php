<?php
require('../../processors/config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hiring | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/hiring.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<main>
		<div id="hiringContainer" class="container">
			<header id="hiringContainerHeader" class="containerHead">
				<h1>Hiring</h1>
			</header>
			<form id="hiringForm" class="containerInputs" action="../../processors/hiringProcessor.php" method="POST">
                <div class="containerSectionInputs">
                    <label for="title" class="containerInputLabel">Title</label>
                    <input type="text" id="title" name="title" class="containerInput" placeholder="Title">
                </div>
                <div id="descriptionDiv" class="containerSectionInputs">
                    <label for="description">Description</label>
                    <textarea type="text" id="description" name="description" class="containerInput" placeholder="Description"></textarea>
                </div>
                <div id="bottomInputs" class="containerSectionInputs">
                    <div class="datesDiv">
						<div class="dateSections">
							<label for="startDate">Start Date</label>
							<input type="date" id="startDate" name="startDate" class="containerInput">
						</div>
						<div class="dateSections">
							<label for="endDate">End Date</label>
							<input type="date" id="endDate" name="endDate" class="containerInput">
						</div>
					</div>
                    <div class="paymentMethodDiv">
						<select id="paymentMethod" name="paymentMethod" class="containerInput">
							<option value="credit">Credit</option>
							<option value="debit">Debit</option>
						</select>
						<input type="number" id="pin" name="pin" class="containerInput" placeholder="Pin">
					</div>
                </div>
                <button id="hire" name="hire" class="containerBtn">Hire</button>
				<button id="cancel" name="cancel" class="containerBtn">Cancel</button>
			</form>
			<?php if (isset($_SESSION['notice'])): ?>
				<p class='notice'><?= $_SESSION['notice'] ?></p>
				<?php unset($_SESSION['notice']); ?>
			<?php endif; ?>
		</div>
	</main>
</body>
</html>