<?php
	session_start();

	isset($_POST['ApiKey']) ? $_SESSION['ApiKey'] = $_POST['ApiKey'] : '';
	isset($_POST['Id']) ? $_SESSION['Id'] = $_POST['Id'] : '';
	isset($_POST['NombreUsuario']) ? $_SESSION['NombreUsuario'] = $_POST['NombreUsuario'] : '';
	isset($_POST['Nombre']) ? $_SESSION['Nombre'] = $_POST['Nombre'] : '';
	isset($_POST['Apellido']) ? $_SESSION['Apellido'] = $_POST['Apellido'] : '';
	isset($_POST['Email']) ? $_SESSION['Email'] = $_POST['Email'] : '';
	isset($_POST['RolId']) ? $_SESSION['RolId'] = $_POST['RolId'] : '';
	isset($_POST['RolDescrip']) ? $_SESSION['RolDescrip'] = $_POST['RolDescrip'] : '';
	isset($_POST['Imagen']) ? $_SESSION['UrlParcialImagen'] = $_POST['Imagen'] : '';
	isset($_POST['Logo']) ? $_SESSION['UrlParcialLogo'] = $_POST['Logo'] : '';
	isset($_POST['NombreLab']) ? $_SESSION['NombreLab'] = $_POST['NombreLab'] : '';
	isset($_POST['LemaLab']) ? $_SESSION['LemaLab'] = $_POST['LemaLab'] : '';
	isset($_POST['SinConexion']) ? $_SESSION['SinConexion'] = $_POST['SinConexion'] : '';
?>