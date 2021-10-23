<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="og:type" content="website" />
	<meta name="twitter:card" content="photo" />
	<title>{{ $data->name }}</title>
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-icon.png">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/slick.css">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

    {!! html_entity_decode($data->content) !!}

</body>
</html>