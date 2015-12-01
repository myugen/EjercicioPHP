<?php
session_start();
if(isset($_SESSION["usuario"]) && isset($_SESSION["tipo"])) {
	header("Location: index.php");
}
else {
	$usuario = "anónimo";
	if(!empty($_POST["userUp"]) && !empty($_POST["passwordUp"]) && !empty($_POST["confirmPasswordUp"])) {
		$camposRellenos = true;
		$user = $_POST["userUp"];
		$pass = $_POST["passwordUp"];
		$confirmPass = $_POST["confirmPasswordUp"];
		$tipo = "usuario";
		if(preg_match_all("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{7,15}$/", $pass)) {
			$passValido = true;
			if($pass == $confirmPass) {
				$passConfirmado = true;
				$conectionDB = "localhost";
				$userDB = "root";
				$passDB = "admin";
				$nameDB = "foro";
				$conexion = new mysqli($conectionDB, $userDB, $passDB, $nameDB);
				if(!$conexion)
					die("<p>Error de conexión " . mysqli_connect_errno() . ": ". mysqli_connect_error() . "</p><br>");
					else {
						$peticion = "INSERT INTO usuario VALUES(null, '$user', '$pass', '$tipo');";
						$resultado = $conexion->query($peticion);
						if($resultado) {
							$creacion = true;
							$_SESSION["usuario"] = $user;
							$_SESSION["tipo"] = $tipo;
							$usuario = $_SESSION["usuario"];
						}
						else {
							$creacion = false;
						}
					}
			}
			else 
				$passConfirmado = false;
		}
		else
			$passValido = false;
	}
	else
		$camposRellenos = false;
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Inicio</title>
</head>
<body>
    <div class="container">
    	<div class="row">
    	<nav class="navbar navbar-fixed-top navbar-inverse">
    		<a class="navbar-brand" href="#"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="nav navbar-nav navbar-left">
	    		<li class="nav-item active">
	      			<a class="nav-link" href="#">Inicio<span class="sr-only">(current)</span></a>
	    		</li>
	    		<li class="nav-item">
	      			<a class="nav-link" href="#">Foro</a>
	    		</li>
    		</ul>
    		<ul class="nav navbar-nav navbar-right">
    			<?php
    			//Mensaje especial en la zona de usuario
    			if($usuario == "anónimo")
    				echo "<li class='nav-item' style='padding-right: 15px'><p class='navbar-text'>Bienvenido, $usuario</p></li>";
    			else {
    				echo "<li class='nav-item dropdown' style='padding-right: 15px'>
    						<a id='dropdownMenu' class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
								Bienvenido, $usuario<span class='caret'></span>
    						</a>
							<ul class='dropdown-menu' aria-labelledby='dropdownMenu'>
    							<li><a href='cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					</li>";
    			}
    			?>
    		</ul>
    	</nav>
    	</div>
    	<div class="row" style="padding-top: 20px">
    		<div class="page-header">
    			<h1>Bienvenido a MiForo</h1>
    			<small>Para disfrutar al máximo de la página, por favor, identifíquese o dese de alta.</small>
    		</div>
    	</div>
    	<div class="row">
	    	<div class="jumbotron">
	    	<div class="container">
	    		<?php 
	    		if(!$camposRellenos) {
	    			echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		else if(!$passValido) {
	    			echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Contraseña no válida, debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
							Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>. <a href='index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		else if(!$passConfirmado) {
	    			echo "<div class='alert alert-danger' role='alert'>
	    			<strong>¡Error!</strong> Las contraseñas no coinciden. <a href='index.php' class='alert-link'>Volver al índice</a>.
	    			</div>";
	    		}
	    		else if(!$creacion) {
	    			echo "<div class='alert alert-danger' role='alert'>
	    			<strong>¡Error!</strong> Lo sentimos, ha ocurrido un fallo con la creación de la cuenta.<a href='index.php' class='alert-link'>Volver al índice</a>.
	    			</div>";
	    		}
	    		else {
	    			echo "<div class='alert alert-success role='alert'>
						  	<strong>¡Enhorabuena!</strong> Cuenta creada con éxito, además está logueado. <a href='index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		?>
	    	</div>
	    	</div>
    	</div>
    </div>
</body>
</html>