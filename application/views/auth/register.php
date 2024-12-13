<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container mt-5">
		<h3 class="text-center">Register</h3>
		<?php if (validation_errors()): ?>
			<div class="alert alert-danger"><?= validation_errors() ?></div>
		<?php endif; ?>
		<form method="post">
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input type="text" name="name" class="form-control" value="<?= set_value('name') ?>" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="email" name="email" class="form-control" value="<?= set_value('email') ?>" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input type="password" name="password" class="form-control" required>
			</div>
			<div class="mb-3">
				<label for="confirm_password" class="form-label">Confirm Password</label>
				<input type="password" name="confirm_password" class="form-control" required>
			</div>
			<button type="submit" class="btn btn-primary">Register</button>
		</form>
	</div>
</body>

</html>
