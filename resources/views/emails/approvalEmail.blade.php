<!DOCTYPE html>
<html>
<head>
	<title>Verification from Janvi LGD</title>
</head>
<body style="font-family: calibri; margin: 1.5vh 1.5vw;">
	<div style="border: 1em solid #d2ab66; border-radius: 10px; border-bottom-width: .2em;">
		<div style="text-align: center; font-size: 1.5em; background: #d2ab66; color: #fff; padding-bottom: 1vh;">
			<b>WELCOME TO JANVI LGD</b>
		</div>
		<div style="padding: 0 2vw;">
			<div><p style="padding: 0.5vh 0">Dear, <b>{{ $name }}</b>!</p></div>
			<div>
				<p> Congratulations and welcome to the JANVI LGD family! Your account on JANVI LGD is now approved. Click <a href="https://www.janvilgd.com/customer/login">here</a> to sign in.</p>
				<p> Your account information are as below: </p>
				<p>
					<div> Email Address: {{ $email }} </div>
					<div> Password: The one you set when you registered your account. </div>
				</p>
				<p> If you forget your password in the future, just click or tap on the "Forgot Password" link on the App or Login page. </p>
				<p style="margin-bottom: 0.5rem;"> You can access the Janvi LGD app in the following ways: </p>
				<div>
					<div style="margin: 1rem; display: inline-block;">
						<a href="https://www.janvilgd.com" target="_blank" title="JANVI LGD WEB" >
							<img src="{{ url('/') }}/assets/images/logo.png" alt="JANVI LGD" width="100px" style="background: #000000; padding: 0.5rem; box-shadow: 0px 5px 10px 0px lightgrey; border-radius: 25px;">
						</a>
					</div>
					<div style="margin: 1rem; display: inline-block;">
						<a href="{{ $link[0] }}" target="_blank" title="JANVI LGD ANDROID" >
							<img src="{{ url('/') }}/assets/images/google-play-shadow-applied.png" alt="JANVI LGD" width="50px">
						</a>
					</div>
					<div style="margin: 1rem; display: inline-block;">
						<a href="{{ $link[1] }}" target="_blank" title="JANVI LGD IOS" >
							<img src="{{ url('/') }}/assets/images/app-store.png" alt="JANVI LGD" width="50px" style="box-shadow: 0px 5px 10px 0px lightgrey; border-radius: 12px;">
						</a>
					</div>
				</div>
				<p> Reach out anytime! We're here to support you in reaching your business goals. </p>
				<p> Looking forward to working with you. </p>
			</div>
			<div>
				<p style="padding: 0.5vh 0">
					Regards,<br>
					<b>Janvi LGD</b>
				</p>
			</div>
		</div>
		<div style="text-align: center; background: #d2ab66; color: #fff;">
			<small>&copy; Copyright 2022 Janvi LGD</small>
		</div>
	</div>
</body>
</html>