<?php
// USER: cuevabill12@gmail.com, CLAVE: 12345

// El más recomendado
// passowrd_hash: 60 caracteres que varian por cada actualización
$clave = "querysheet22";
$claveEncriptada = password_hash($clave, PASSWORD_BCRYPT);
var_dump($claveEncriptada);

//password_verify: retorna un valor booleano
// Haciendo login
/* $claveIngresada = "12345";
if (password_verify($claveIngresada, $claveEncriptada)){
    echo "Contraseña correcta";
}
else{
    echo "Contraseña incorrecta";
}
?> */