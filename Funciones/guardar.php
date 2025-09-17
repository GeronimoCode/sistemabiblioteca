<?php
session_start();

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ----------------- FUNCIONES AUXILIARES -----------------------
function mostrarError($mensaje) {
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = 'error';
    header("Location: ../html/registrarme.php");
    exit();
}

function mostrarExito($mensaje) {
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = 'success';
    header("Location: ../html/registrarme.php");
    exit();
}

// ----------------- LÓGICA PRINCIPAL -----------------------
$conexion = new mysqli("localhost", "root", "", "sistemabiblioteca");
if ($conexion->connect_error) {
    mostrarError("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$camposRequeridos = ['Documento', 'Nombre', 'Apellido', 'Email', 'Telefono', 'TipoUsuario', 'password'];
foreach ($camposRequeridos as $campo) {
    if (empty($_POST[$campo] ?? '')) {
        mostrarError("El campo $campo es obligatorio y no puede estar vacío");
    }
}

$Documento   = $conexion->real_escape_string(trim($_POST['Documento']));
$Nombre      = $conexion->real_escape_string(trim($_POST['Nombre']));
$Apellido    = $conexion->real_escape_string(trim($_POST['Apellido']));
$Email       = $conexion->real_escape_string(trim($_POST['Email']));
$Telefono    = $conexion->real_escape_string(trim($_POST['Telefono']));
$TipoUsuario = $conexion->real_escape_string(trim($_POST['TipoUsuario']));
$password    = trim($_POST['password']);

// Validaciones
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    mostrarError("El formato del correo electrónico no es válido");
}

if (!preg_match('/^[0-9]{5,15}$/', $Telefono) || !preg_match('/^[0-9]{5,15}$/', $Documento)) {
    mostrarError("El teléfono y documento deben contener solo números válidos (entre 5 y 15 dígitos)");
}

$tiposPermitidos = ['Estudiante', 'Profesor', 'Empleado'];
if (!in_array($TipoUsuario, $tiposPermitidos)) {
    mostrarError("Tipo de usuario no válido");
}

// Verificar duplicados
$sql_verificar = "SELECT Email, Documento FROM usuarios WHERE Email = ? OR Documento = ?";
$stmt_verificar = $conexion->prepare($sql_verificar);
if (!$stmt_verificar) {
    mostrarError("Error en la consulta de verificación: " . $conexion->error);
}
$stmt_verificar->bind_param("ss", $Email, $Documento);
$stmt_verificar->execute();
$resultado = $stmt_verificar->get_result();

if ($resultado->num_rows > 0) {
    $mensajeError = "El correo o el documento ya están registrados";
    while ($row = $resultado->fetch_assoc()) {
        if ($row['Email'] === $Email) {
            $mensajeError = "El correo ya está registrado";
        } elseif ($row['Documento'] === $Documento) {
            $mensajeError = "El documento ya está registrado";
        }
    }
    mostrarError($mensajeError);
}
$stmt_verificar->close();

// Hashear contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$sql_insert = "INSERT INTO usuarios (Documento, Nombre, Apellido, Email, Telefono, TipoUsuario, password) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conexion->prepare($sql_insert);
if (!$stmt_insert) {
    mostrarError("Error en la consulta de inserción: " . $conexion->error);
}
$stmt_insert->bind_param("sssssss", $Documento, $Nombre, $Apellido, $Email, $Telefono, $TipoUsuario, $passwordHash);

if ($stmt_insert->execute()) {
    mostrarExito("Registro exitoso. Ahora puedes iniciar sesión.");
} else {
    mostrarError("Error al registrar: " . $stmt_insert->error);
}

$stmt_insert->close();
$conexion->close();
exit();
?>
