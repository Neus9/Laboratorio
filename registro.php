<?php
if (isset($_POST['submit'])) {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido_1 = $_POST['apellido_1'];
    $apellido_2 = $_POST['apellido_2'];
    $email = $_POST['email'];
    $loginpost = $_POST['login'];
    $passwordpost = $_POST['password'];
   
 // Validar los datos recibidos
 $errors = array();

 // Validar el nombre
 if (empty($nombre)) {
     $errors[] = "El nombre es requerido";
 }

 // Validar el primer apellido
 if (empty($apellido_1)) {
     $errors[] = "El primer apellido es requerido";
 }

 // Validar el segundo apellido
 if (empty($apellido_2)) {
     $errors[] = "El segundo apellido es requerido";
 }

 // Validar el email
 if (empty($email)) {
     $errors[] = "El email es requerido";
 } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $errors[] = "El email ingresado no es válido";
 }

 // Validar el login
 if (empty($loginpost)) {
     $errors[] = "El login es requerido";
 }

 // Validar el password
 if (empty($passwordpost)) {
    $errors[] = "El password es requerido";
} elseif (strlen($passwordpost) < 4 || strlen($passwordpost) > 8) {
    $errors[] = "El password debe tener entre 4 y 8 caracteres";
}

// Si hay errores, mostrarlos
if (!empty($errors)) {
    echo "<h2>Error:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
} else {



    // Conexión a la base de datos
    $servername = "localhost";
    $usernamedb = "root";
    $passworddb = "";
    $dbname = "practicafinal";

    $conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si el email ya existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<script>alert("El email ya está registrado");</script>';
        $Link = "index.html";
        //echo '<script>setTimeout(function(){ window.location.href = "index.html"; }, 2000);</script>'; // Redireccionar automáticamente después de 3 segundos
        header("refresh:1; url=$Link");
        $conn->close();
        exit();
        
    }

    // Insertar datos en la tabla
    $sql = "INSERT INTO usuarios (nombre, apellido_1, apellido_2, email, login, password) 
            VALUES ('$nombre', '$apellido_1', '$apellido_2', '$email', '$loginpost', '$passwordpost')";


if ($conn->query($sql) === TRUE) {
        $message = "Registro completado con éxito";
        $buttonText = "Consultar Usuarios";
        $buttonLink = "consulta.php";
       
    } else {
        $message = "Error al guardar los datos: " . $conn->error;
        $buttonText = "Volver";
        $buttonLink = "index.html";
    }

    $conn->close();
} 
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <style>

        
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color:#caebcb;
        }
        
        .center-content {
            text-align: center;
        }
        
        .btn-consulta {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-consulta:hover {
            background-color: #45a049;
        }

        .message {
            font-size: 40px;
            color: #45a049;
        }

    </style>
</head>
<body>
    <div class="center-container">
        <div class="center-content">
            <?php if (isset($_POST['submit'])) { ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
                <br>
                <a href="<?php echo $buttonLink; ?>" class="btn-consulta"><?php echo $buttonText; ?></a>
                <br>
                <br>
                <a href="index.html" class="btn-consulta">Volver al formulario</a> 
            <?php } ?>
        </div>
    </div>
</body>
</html>
