<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>EMRApp</title>

<link rel="stylesheet" href="/EMRApp/include/css_lib/bootstrap/5.0.2.css" />
<link rel="stylesheet" href="/EMRApp/include/css_lib/dataTable/2.1.0.css" />
<link rel="stylesheet" href="/EMRApp/module/ingreso_paciente/css/Frm_Paciente.css">
<link rel="icon" type="image/webp" href="/EMRApp/include/Images/esculapio1.webp">
</head>

<body>
    <div id="app">
        <div class="card">
            <div class="card-header" style="padding: 12px;">
                <div class="row" style="margin: 0;">
                    <div class="col-6"><img src="/EMRApp/include/Images/esculapio1.webp" alt="" width="116px" class=""></div>
                    <div class="col-6 title-p-1">
                        <h1 class="title-card" style="margin-right: 10px;">Tabla de Pacientes</h1>
                        <img src="/EMRApp/include/Images/find-patients.webp" alt="" width="65px">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width: 100%" ref="tablePacientes">
                    <thead>
                        <tr>
                            <th>Id - DPI</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Contaco de Emergencia</th>
                            <th>Tipo de Sangre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="paciente in pacientes">
                            <td>{{paciente.PAC_CORR}}-{{paciente.PAC_DOCNUM}}</td>
                            <td>{{paciente.NOMBRE}}</td>
                            <td>{{paciente.PAC_CORREO}}</td>
                            <td>{{paciente.PAC_TELEFONO_EMG}}</td>
                            <td>{{paciente.TIPO_SANGRE}}</td>
                            <td><a class="btn btn-primary" :href="`verPaciente.php?DOC=${paciente.PAC_DOCNUM}&CORR=${paciente.PAC_CORR}`">Ver</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="/EMRApp/include/js_lib/JQuery/3.7.1.js"></script>
    <script src="/EMRApp/include/js_lib/bootstrap/5.0.2.js"></script>
    <script src="/EMRApp/include/js_lib/dataTable/2.1.0.js"></script>
    <script src="/EMRApp/include/js_lib/sweetAlert2/11.12.3.js"></script>
    <script src="/EMRApp/include/js_lib/VUEjs/3.4.33.js"></script>
    <script src="/EMRApp/module/consulta_pacientes/js/Tbl_Paciente.js"></script>
    
</body>

</html>