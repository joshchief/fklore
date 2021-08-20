<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<center><img src="http://folkoflore.com/assets/img/logoheader.png" width="240px" height="161px" /></center>

		<h2>Greetings {{ $username }}!</h2>

		<div>
			A request to reset your password has been made. To do so, please visit the link below to create your new password, if after sending your request for a password reset you now remember your current password, then feel free to login and disregard this email. If you did not make this request then please contact us immediately by replying to this email and we will look into it!

			<br />
			<br />

			Reset Link: <a href="http://folkoflore.com/user/reset/{{ $resetToken }}">http://folkoflore.com/user/reset/{{ $resetToken }}</a>

			<br />
			<br />

			Sincerely, <br />
			FolkOfLore Staff
		</div>
	</body>
</html>
