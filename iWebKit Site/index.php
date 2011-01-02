<? include 'header.php' ?>

<body>
<div id="topbar" class="black">
	<div id="title">
		Login</div>
	<div id="leftnav">
		</div>
</div>
<div id="content">
	<h2><? include 'errors.php' ?></h2>
	<form method="post" action="login.php">
		<fieldset><span class="title">Sakai</span>
		<ul class="pageitem">
			<li class="bigfield"><input name="uname" placeholder="Username" type="text" /></li>
			<li class="bigfield"><input name="pass" placeholder="Password" type="password" /></li>
			<li class="button"><input name="Submit input" type="submit" value="Login" /></li>
		</ul>
		</fieldset>
	</form>
</div>
<? include 'footer.php' ?>
</body>
</html>