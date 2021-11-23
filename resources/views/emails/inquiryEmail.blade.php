<!DOCTYPE html>
<html>
<head>
	<title>Inquiry from Janvi LGD</title>
</head>
<body style="font-family: calibri; margin: 1.5vh 1.5vw;">
	<div style="border: 1em solid #d2ab66; border-radius: 10px; border-bottom-width: .2em;">
		<div style="text-align: center; font-size: 1.5em; background: #d2ab66; color: #fff; padding-bottom: 1vh;">
			<b>JANVI LGD</b>
		</div>
		<div style="padding: 0 2vw;">
			<div><p style="padding: 0.5vh 0">Hello Sir,</p></div>
			<div style="">
				<p style="padding: 0.5vh 0">This is to inform you that we have received an inquiry on {{ $data['data']['time'] }}. Please have a look here.</p>
                <br>
                <p>Name: {{ $data['data']['name'] }}</p>
                <p>Mobile: {{ $data['data']['phone'] }}</p>
                <p>Email: {{ $data['data']['email'] }}</p>
                <p>Subject: {{ $data['data']['subject'] }}</p>
                <p>Message: {{ $data['data']['msg'] }}</p>
			</div>
			<div>
				<p style="padding: 0.5vh 0">
					Support Team,<br>
					<b>Janvi LGD</b>
				</p>
			</div>
		</div>
		<div style="text-align: center; background: #d2ab66; color: #fff;">
			<small>&copy; Copyright 2021 Janvi LGD</small>
		</div>
	</div>
</body>
</html>