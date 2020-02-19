var tabla;

//funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
}

//funcion limpiar
function limpiar() {
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
}

//funcion mostrar formulario

function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }
}

//funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "sServerSide": true, //paginaciion y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tablas
        

        buttons: [{
            //Botón para Excel
            extend: 'excel',
            footer: true,
            title: 'Archivo',
            filename: 'Export_File',
    
            //Aquí es donde generas el botón personalizado
            text: '<button class="btn btn-success ">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
          },
          //Botón para PDF
          {
            extend: 'pdf',
            footer: true,
            title: 'Archivo PDF',
            filename: 'Export_File_pdf',
            text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>'
          }
        ],
        

        "ajax": 
        {
            url: '../ajax/categoria.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //paginacion
        "order":[[0, "desc"]] //ordenar (columna,orden)


    }).DataTable();
}




init();