<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<title>Actividad 4.1 - Ejercicio 4</title>
</head>
<body>
	<form action="ejercicio4.php" method="post">
		<input type="text" name="cadena" maxlength="30" />
		<input type="submit" value="Enviar" />
	</form>
	<?php
	if(isset($_POST["cadena"])) {
		$cadena = $_POST["cadena"];
		echo "Cadena de entrada: <strong>$cadena</strong><br>";
		$letras = count_chars(utf8_decode($cadena), 3);
		$cuenta = count_chars(utf8_decode($cadena), 1);
		echo "<table border='1'>";
		echo "<tr bgcolor='grey'><th>Carácter</th><th>Frecuencia</th></tr>";
		for($i = 0; $i < strlen($letras); $i++) {
			echo "<tr><td>". utf8_encode($letras[$i]) . "</td><td>" . $cuenta[ord($letras[$i])] . "</td></tr>";
		}
		echo "</table>";
	}
	?>
</body>
</html>
