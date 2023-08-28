<?php
require_once ('../../config/config.php'); // Asegúrate de que esté en la misma carpeta o ajusta la ruta
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "forgot_password") {
    $conexion = new ClaseConexion(); // Crea una instancia de la clase ClaseConexion
    $con = $conexion->ProcedimientoConectar(); // Establece la conexión

    if (!$conexion) {
        die('Error al conectarse a la base de datos: ' . mysqli_error($conexion));
    }

    $mail = $_POST['cli_email'];
    $password = $_POST['cli_contrasena'];

    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM cliente WHERE cli_email='$mail'";
        $resultado = mysqli_query($con, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
          $contrasenaEncriptada = password_hash($password, PASSWORD_DEFAULT);
          $sql23 = "UPDATE cliente SET cli_contrasena = '$contrasenaEncriptada' WHERE cli_email = '$mail'";
           $resultado2 = mysqli_query($con, $sql23);
           echo "contraseñas";
           echo $mail;
           echo $password;
           echo $resultado2;
           header("Location: login.php");
           exit(); // Importante: asegurarse de que el script termine aquí para que la redirección funcione correctamente
            // El correo existe en la base de datos
            // Puedes mostrar un formulario para cambiar la contraseña
            
        } else {
            // El correo no existe en la base de datos
        print "El correo no existe en la base de datos.";
        }
    } else {
        // El formato de correo electrónico es inválido
        echo "El formato de correo electrónico es inválido.";
    }
}
?>

