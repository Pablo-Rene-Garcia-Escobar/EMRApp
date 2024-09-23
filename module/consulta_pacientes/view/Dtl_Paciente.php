<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EMRApp</title>

    <link rel="stylesheet" href="/EMRApp/include/css_lib/bootstrap/5.0.2.css" />
    <link rel="icon" type="image/webp" href="/EMRApp/include/Images/esculapio1.webp">
</head>
<body>
    
    <div id="app">
        
        <div class="card">
                <div class="card-header" style="padding: 12px;">
                <div class="row align-items-center" style="margin: 0;">
                <div class="col-6 d-flex align-items-center">
                    <img style="border-radius: 50%; border: 4px solid white; object-fit: cover; width: 105px; height: 125px;" 
                        :src="paciente.PAC_FOTO ? `/EMRApp/adjunto/FotosPacientes/${paciente.PAC_FOTO}` : '/EMRApp/include/Images/user.png'" 
                        alt="Imagen Paciente">
                    
                    <!-- Ajuste del texto a la derecha de la imagen -->
                    <div class="ms-3 ajustar texto">
                        <h1 class="title-card text-start" style="margin: 0;">
                            {{paciente.NOMBRE}}
                        </h1>
                    </div>
                </div>
                
                <div class="col-6 title-p-1">
                    <h1 class="title-card" style="margin-right: 10px; font-size: 70px">
                        {{paciente.EDAD}} Años
                    </h1>
                </div>
            </div>

                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>

    <script src="/EMRApp/include/js_lib/JQuery/3.7.1.js"></script>
    <script src="/EMRApp/include/js_lib/bootstrap/5.0.2.js"></script>
    <script src="/EMRApp/include/js_lib/sweetAlert2/11.12.3.js"></script>
    <script src="/EMRApp/include/js_lib/VUEjs/3.4.33.js"></script>
    <script src="/EMRApp/module/consulta_pacientes/js/Dtl_Paciente.js"></script>
</body>
</html>