<?php
$server = "192.168.100.86";
$user = "root";
$pass = "password";
$mydb = "app_development";

$conn = new mysqli($server, $user, $pass, $mydb);

if ($conn->connect_error) {
    die("Conexão Falhou: $conn->connect_error");
}

echo "Conexão deu certo<br>";

$sql = "INSERT INTO user (name, email, phone) VALUES ('Leonardo','leko@souza.com.br','67999999999')";

try {
    $conn->query($sql);
    echo "Registro inserido<br>";

} catch (\Throwable $th) {
    echo "Erro ao inserir registro<br>";
}

$sql = "SELECT * FROM user";
$result = $conn->query($sql);
if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){
        echo "User: {$row["name"]} {$row["email"]}<br>";
    }
}

$conn->close();