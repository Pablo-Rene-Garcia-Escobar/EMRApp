<?php
// Permitir solicitudes desde cualquier origen (para desarrollo, usa con precaución)
header("Access-Control-Allow-Origin: *");
// Permitir ciertos métodos HTTP
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir ciertos encabezados
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include '../../core_functions/core_functions.php';

try {
    if (isset($_GET["FUNC"])) {
        $v_Func = $_GET["FUNC"];
        if ($v_Func == "guardarRegistro") {
            echo json_encode(guardarRegistro());
        } else if ($v_Func == "iniciarSesion") {
            echo json_encode(iniciarSesion());
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}

function guardarRegistro()
{
    try {
        //Obtiene los datos y decodifica el JSON
        $dataRegistro = json_decode(file_get_contents('php://input'), true);

        $data = $dataRegistro['dataRegistro'];

        $strConsulta = "SELECT 1 FROM EMR.EMR_ACCE_USER WHERE USER_CORREO = :user_correo";

        $params = array(
            ':user_correo' => $data['mail'],
        );

        $resul = _queryBind($strConsulta, $params);

        if (!empty($resul)) {
            throw new Exception("Ya existe un usuario con el correo ingresado.");
        }

        $strInsRegistro =
            "INSERT INTO EMR.EMR_ACCE_USER 
            (
            USER_NOMBRE1,
            USER_NOMBRE2,
            USER_APELLIDO1,
            USER_APELLIDO2,
            USER_CORREO,
            USER_PASS,
            ROL_ID,
            USER_FEC_CREA
            )
            VALUES
            (
            :user_nombre1,
            :user_nombre2,
            :user_apellido1,
            :user_apellido2,
            :user_correo,
            :user_pass,
            :rol_id,
            SYSDATE
            )";

        $params = array(
            ':user_nombre1' => $data['nombre1'],
            ':user_nombre2' => $data['nombre2'],
            ':user_apellido1' => $data['apellido1'],
            ':user_apellido2' => $data['apellido2'],
            ':user_correo' => $data['mail'],
            ':user_pass' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 5]),
            ':rol_id' => 4,
        );

        if (_queryBindCommit($params, $strInsRegistro)) {
            return array(
                'estado' => true,
                'desc' => 'Usuario creado correctamente',
            );
        } else {
            throw new Exception("Error al crear usuario.");
        }
    } catch (Exception $e) {
        return array(
            'estado' => false,
            'desc' => $e->getMessage(),
        );
    }
}

function iniciarSesion()
{
    try {
        //Obtiene los datos y decodifica el JSON
        $dataLogin = json_decode(file_get_contents('php://input'), true);

        $data = $dataLogin['dataLogin'];

        if (!$data['mail']) {
            throw new Exception("Por favor llene el campo de correo electrónico.");
        }

        if (!$data['password']) {
            throw new Exception("Por favor llene el campo de contraseña.");
        }

        $strConsulta = "SELECT * FROM EMR.EMR_ACCE_USER WHERE USER_CORREO = :user_correo";

        $params = array(
            ':user_correo' => $data['mail'],
        );

        $resul = _queryBind($strConsulta, $params);

        if (empty($resul)) {
            throw new Exception("El correo ingresado no existe.");
        }

        if (password_verify($data['password'],$resul[0]['USER_PASS'])) {
            session_start();
            $_SESSION['user_id'] = $resul[0]['USER_ID'];
            $_SESSION['nombre1'] = $resul[0]['USER_NOMBRE1'];
            $_SESSION['nombre2'] = $resul[0]['USER_NOMBRE2'];
            $_SESSION['apellido1'] = $resul[0]['USER_APELLIDO1'];
            $_SESSION['apellido2'] = $resul[0]['USER_APELLIDO2'];
            $_SESSION['correo'] = $resul[0]['USER_CORREO'];
            $_SESSION['rol_id'] = $resul[0]['ROL_ID'];
            $_SESSION['usuario_logeado'] = true;
        } else {
            throw new Exception("Contraseña invalida.");
        }

        return array(
            'estado' => true,
            'desc' => 'Bienvenido',
        );

    } catch (Exception $e) {
        return array(
            'estado' => false,
            'desc' => $e->getMessage(),
        );
    }
}
