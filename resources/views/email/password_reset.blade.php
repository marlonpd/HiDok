
<!DOCTYPE html>
<html>
<head>
	<title>Password reset</title>
</head>
<body>
	<div>
		<h1>Greetings from {{ env('APP_NAME') }},</h1>

        <p>You have requested to Reset the Password. </p>
        <p>To complete this process please click the link below. </p>
		<p><a href="{{ $url }}/account/password/reset/{{ $id }}/{{ $reset_password_code }}">RESET PASSWORD</a></p>
		<br>
        <p>Regards, </p>
		<p>{{ env('APP_NAME') }} Team</p>
	</div>
</body>
</html>