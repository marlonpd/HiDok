
<!DOCTYPE html>
<html>
<head>
	<title>Account Activation</title>
</head>
<body>
	<div>
		<h1>Welcome to {{ env('APP_NAME') }}.</h1>

        <p>Thanks for signing up. To start using {{ env('APP_NAME') }}, please verify your account by clicking the link below.</p>
		<p><a href="{{ $url }}/account/activation/{{ $id }}/{{ $activation_code }}">ACTIVATE YOUR ACCOUNT</a></p>
		<p>Regards, </p>
		<p>{{ env('APP_NAME') }} Team</p>
	</div>
</body>
</html>