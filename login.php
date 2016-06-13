<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="estilo/css/style.css">
	<script src="//code.jquery.com/jquery-2.2.3.min.js"></script>
	<script src="estilo/js/script.js"></script>
</head>
<body>
	<div class="logmod"></div>
	<div class="logmod__wrapper">
		<div class="logmod__container">
			<ul class="logmod__tabs">
				<li data-tabtar="lgm-2"><a href="#">Iniciar Sessión</a></li>
				<li data-tabtar="lgm-1"><a href="#">Registrarse</a></li>
			</ul>
			<div class="logmod__tab-wrapper">
				<div class="logmod__tab lgm-1">
					<div class="logmod__heading">
						<span class="logmod__heading-subtitle">Introduce tu correo electronico y contraseña para <strong>registrarte</strong></span>
					</div>
					<div class="logmod__form">
						<form accept-charset="utf-8" action="registrar.php" class="simform" method="post">
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-name">Correo*</label>
									<input class="string optional" maxlength="255" name="user-email" id="user-email" placeholder="Correo" type="email" size="50" required/>
								</div>
							</div>
							<div class="sminputs">
								<div class="input string optional">
									<label class="string optional" for="user-pw">Contraseña *</label>
									<input class="string optional" maxlength="255" name="user-pw" id="user-pw" placeholder="Contraseña" type="text" size="50" required/>
								</div>
								<div class="input string optional">
									<label class="string optional" for="user-pw-repeat">Repite la contraseña *</label>
									<input class="string optional" maxlength="255" name="user-pw-repeat" id="user-pw-repeat" placeholder="Repite la contraseña" type="text" size="50" required/>
								</div>
							</div>
							<div class="simform__actions">
								<input class="sumbit" name="submit" type="submit" value="Crear" />
							</div> 
						</form>
					</div>
				</div>
				<div class="logmod__tab lgm-2">
					<div class="logmod__heading">
						<span class="logmod__heading-subtitle">Introduce tu correo electronico y contraseña para <strong>iniciar sessión</strong></span>
					</div> 
					<div class="logmod__form">
						<form accept-charset="utf-8" action="registrar.php" class="simform" method="post">
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-name">Correo*</label>
									<input class="string optional" maxlength="255" id="user-email" name="user-email" placeholder="Correo" type="email" size="50" required/>
								</div>
							</div>
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-pw">Contraseña *</label>
									<input class="string optional" maxlength="255" id="user-pw" name="user-pw" placeholder="Contraseña" type="password" size="50" required/>
									<span class="hide-password">Mostrar</span>
								</div>
							</div>
							<div class="simform__actions">
								<input class="sumbit" name="submit" type="submit" value="Iniciar" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>