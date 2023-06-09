<?php

$servername = "localhost";
$usernamedb = "root";
$passworddb = "";
$dbname = "practicafinal";

$conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);


include 'consulta.html';


if ($result->num_rows > 0) {
    echo '<table>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido 1</th>
              <th>Apellido 2</th>
              <th>Email</th>
              <th>Login</th>
              <th>Password</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row["ID"] . '</td>
                <td>' . $row["nombre"] . '</td>
                <td>' . $row["apellido_1"] . '</td>
                <td>' . $row["apellido_2"] . '</td>
                <td>' . $row["email"] . '</td>
                <td>' . $row["login"] . '</td>
                <td>' . $row["password"] . '</td>
              </tr>';
    }

    echo '</table>';
} else {
    echo 'No se encontraron usuarios registrados.';
}


$conn->close();
?>
