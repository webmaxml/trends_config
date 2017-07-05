<? include 'config/top.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?= $head_top ?>
	<meta charset="UTF-8">
	<title>Test</title>
	<?= $head_bottom ?>
</head>
<body>
	<?= $body_top ?>

	<form action="<?= $order_url ?>" method="post">
		<?= $hidden_input ?>
		<input type="text" name="name">
		<input type="text" name="phone">
		<button>Заказать</button>
	</form>

	<?= $upsells ?>
	<?= $product ?> - <?= $price_new ?> <?= $valuta ?>
	<a href="<?= $transit_target ?>">target layer link</a>
	<?= $body_bottom ?>
</body>
</html>