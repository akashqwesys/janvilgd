<!DOCTYPE html>
<html>
<head>
	<title>Order Invoice Janvi LGD</title>
</head>
<body style="font-family: calibri; margin: 1.5vh 1.5vw;">
	<div style="border: 1em solid #d2ab66; border-radius: 10px; border-bottom-width: .2em;">
		<div style="text-align: center; font-size: 1.5em; background: #d2ab66; color: #fff; padding-bottom: 1vh;">
			<b>JANVI LGD</b>
		</div>
		<div style="padding: 0 2vw;">
			<div><p style="padding: 0.5vh 0">Hey {{ $data['data']['customer']->name }},</p></div>
			<div style="">
				<p style="padding: 0.5vh 0">Your order invoice [#{{ $data['data']['order_id'] }}] has been successfully generated and below is attached PDF. Please have a look here.</p>
                <p style="padding: 0.5vh 0">To see more details please visit the order details section on our website or mobile application.</p>
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