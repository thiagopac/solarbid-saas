<html>
<head>
<title>Error</title>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,400i,600,700&amp;subset=latin-ext" rel="stylesheet">

</head>
<body>
	<div class="error-page">
		<h1><?php echo $heading; ?></h1>
		<h2>Erro interno do servidor</h2>
		<hr>
		<p>
			Tente novamente mais tarde
		</p>
		<div class="error-container">
			<pre><?php echo $message; ?></pre>
		</div>
	</div>
</body>
</html>
