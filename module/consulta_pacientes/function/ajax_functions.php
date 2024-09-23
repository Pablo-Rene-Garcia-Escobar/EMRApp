<?php

// Permitir solicitudes desde cualquier origen (para desarrollo, usa con precaución)
header("Access-Control-Allow-Origin: *");
// Permitir ciertos métodos HTTP
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir ciertos encabezados
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include '../../../core_functions/core_functions.php';

try {
    if (isset($_GET["FUNC"])) {
        $v_Func = $_GET["FUNC"];
        if ($v_Func == "getPacientes")
        {
            echo json_encode(getPacientes());
        } 
        else if ($v_Func == "getPaciente")
        {
            echo json_encode(getPaciente());
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}

function getPacientes() {
    $strConsulta = "
    SELECT 
        P.PAC_CORR,
        P.PAC_DOCNUM,
        TRIM(P.PAC_NOMBRE1)||' '|| TRIM(P.PAC_NOMBRE2)||' '|| TRIM(P.PAC_APELLIDO1)||' '||TRIM(P.PAC_APELLIDO2) NOMBRE,
        P.PAC_CORREO,
        P.PAC_TELEFONO_EMG,
        S.TS_DESC||S.TS_FACTOR_RH TIPO_SANGRE
    FROM
        EMR.EMR_PACIENTE P
    INNER JOIN
        EMR.EMR_DATOS_CLINICOS D
    ON
        P.PAC_CORR = D.PAC_CORR
        AND P.PAC_DOCNUM = D.PAC_DOCNUM
    LEFT JOIN
        EMR.EMR_TIPO_SANGRE S
    ON
        D.ID_TS = S.TS_ID
    ";

    $arrConsulta = _query($strConsulta);

    return $arrConsulta;
}

function getPaciente() {
    try {
        $respuesta = array(
            'estado' => false,
            'desc' => 'Ocurrio un error al obtener la información del usuario.'
        );

        $data = json_decode(file_get_contents('php://input'), true);

        $doc = $data['doc_id'];
        $corr = $data['pac_corr'];

        if (isset($doc) && isset($corr)) {            

            $strConsulta = "SELECT 
                                P.PAC_CORR,
                                P.PAC_DOCNUM,
                                TRIM(P.PAC_NOMBRE1)||' '|| TRIM(P.PAC_NOMBRE2)||' '|| TRIM(P.PAC_APELLIDO1)||' '||TRIM(P.PAC_APELLIDO2) NOMBRE,
                                P.PAC_NOMBRE1,
                                P.PAC_NOMBRE2,
                                P.PAC_NOMBRE3,
                                P.PAC_APELLIDO1,
                                P.PAC_APELLIDO2,
                                P.PAC_APELLIDOC,
                                P.PAC_FOTO,
                                P.PAC_DIRECCION,
                                P.PAC_TELEFONO,
                                P.PAC_CORREO,
                                P.PAC_TELEFONO_EMG,
                                P.PAC_FEC_NAC,
                                P.PAC_OCUPACION,
                                P.NAC_ID,
                                P.PAC_FEC_REGISTRO,
                                P.EC_ID,
                                P.PAC_ESTADO_SN,
                                D.DC_GENERO,
                                D.DC_PESOKG_ACTUAL,
                                D.DC_PESOLB_ACTUAL,
                                D.DC_ALTURACM_ACTUAL,
                                D.DC_ULT_CITA_CONSUL,
                                D.DC_ULT_MED_GLUCOSAMGDL,
                                D.DC_ULT_MED_GLUCOSAMGDL,
                                D.DC_ULT_MED_FC_LPM,
                                S.TS_DESC||S.TS_FACTOR_RH TIPO_SANGRE,
                                TRUNC((SYSDATE - P.PAC_FEC_NAC) / 365) AS EDAD
                            FROM
                                EMR.EMR_PACIENTE P
                            INNER JOIN
                                EMR.EMR_DATOS_CLINICOS D
                            ON
                                P.PAC_CORR = D.PAC_CORR
                                AND P.PAC_DOCNUM = D.PAC_DOCNUM
                            LEFT JOIN
                                EMR.EMR_TIPO_SANGRE S
                            ON
                                D.ID_TS = S.TS_ID
                            WHERE
                                P.PAC_DOCNUM = :doc
                                AND P.PAC_CORR = :corr
                            ";

            $params = array(
                ':doc' => $doc,
                ':corr' => $corr,
            );

            $result = _queryBind($strConsulta, $params);            

            if (empty($result)) {
                $respuesta['estado'] = false;
                throw new Exception("No se encontró el paciente: " . $corr . "-" . $doc);
            }

            $respuesta['estado'] = true;
            $respuesta['desc'] = $result;
            return $respuesta;

        } else {
            $respuesta['estado'] = false;
            throw new Exception("No se especificarón los parametros necesarios para esta solicitud.");
        }
    } catch (Exception $e) {
        $respuesta['desc'] = $e->getMessage();
        return $respuesta;
    }

    return $respuesta;
}