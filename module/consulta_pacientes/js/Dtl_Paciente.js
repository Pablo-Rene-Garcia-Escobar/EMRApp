var apiEndpoint = 'http://localhost/EMRApp/module/consulta_pacientes/function/ajax_functions.php?FUNC=';
var Headers = {
  json: { header: 'Content-Type', value: 'application/json' },
  form: { header: 'Content-Type', value: 'application/x-www-form-urlencoded' }
};

const { createApp } = Vue;

const app = createApp({
  directives: {
    upper: {
      update(el) {
        el.value = el.value.toUpperCase();
      },
    },
  },
  mounted: function () {},
  data() {
    return {
        DOC_ID: null,
        PAC_CORR: null,
        paciente: null,
    };
  },
  created() {
    const queryParams = new URLSearchParams(window.location.search);
    this.DOC_ID = queryParams.get('DOC');
    this.PAC_CORR = queryParams.get('CORR');    
    this.getPaciente();
  },
  methods: {
    getPaciente: function (){
        try {

            var raw = JSON.stringify({
                doc_id: this.DOC_ID,
                pac_corr: this.PAC_CORR,
            });

            var requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json; charset=utf-8" },
                body: raw,
                redirect: "follow",
            };
    
            fetch(apiEndpoint + 'getPaciente',requestOptions)
            .then(response => {         
                return response.json();
            })
            .then(respuesta => {
                if (respuesta.estado) {
                    console.log(respuesta.desc[0]);                  
                    this.paciente = respuesta.desc[0];
                    this.mostrar = true;          
                } else {
                    this.modalError(respuesta.desc);
                }
            })
            .catch((error) => {
                this.modalErrorApi(error);
                this.mostrarAnimacion = false;
            });
        
        
        } catch (error) {
        this.modalErrorApi(error)
        } finally {
        this.mostrarAnimacion = false;
        }
    },
    modalErrorApi: function (error) {
      Swal.fire({
        icon: "error", 
        title: "Oops...",
        text: `Error: ${error}`,
        footer: null,
      });
    },
    //Modal de error, recibe como parametro el mensaje de error a mostrar
    modalError: function (error) {
      swal.fire({
        title: "Oops...",
        html: `Error: ${error}`,
        icon: "error",
        showConfirmButton: false,
        timer: 5000,
        position: "top",
        toast: true,
        width: "auto",
      });
    },
    //Modal de realizado con exito, recibe como parametro el mensaje de exito a mostrar
    modalSuccess: function (mensaje) {
      return swal.fire({
        title: mensaje,
        icon: "success",
        showConfirmButton: false,
        timer: 3000,
        position: "top",
        toast: true,
        width: "17.8rem",
      });
    },
  },
});
app.mount('#app');