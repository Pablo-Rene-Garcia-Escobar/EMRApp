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
  mounted: function () {
    this.getPacientes();
  },
  data() {
    return {
      pacientes: null,
      dataTable: null,
    };
  },
  watch: {},
  methods: {
    getPacientes: function () {
        var requestOptions = {
            method: "POST",
            headers: { "Content-Type": "application/json; charset=utf-8" },
            redirect: "follow",
          };
    
          fetch(apiEndpoint + 'getPacientes',requestOptions)
            .then(response => {
              return response.json();
            })
            .then(datos => {
              this.pacientes = datos;
              
              this.$nextTick(() => {
                // Inicializa DataTables después de obtener los datos
                this.dataTable = $(this.$refs.tablePacientes).DataTable({
                    language: {
                        url: '/EMRApp/JSON_api/DataTable/2.1.6_es-MX.json',
                    }
                });
            });          
            })
            .catch(error => console.error('Error al cargar el JSON:', error));
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