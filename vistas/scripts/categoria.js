var tabla;

//funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on ("submit" ,function (e) 
    {
        guardaryeditar(e);    
    })
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
        $("#btnagregarc").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregarc").show();
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
        "sSearch": true,
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
        language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
               
                
        },
        "bDestroy": true,
        "iDisplayLength": 5, //paginacion
        "order":[[0, "desc"]], //ordenar (columna,orden)

        

       
    }).DataTable();

}

function guardaryeditar (e)
{
    e.preventDefault(); //no se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }


    });
    limpiar();
}

function mostrar(idcategoria) 
{
    $.post("../ajax/categoria.php?op=mostrar",{idcategoria : idcategoria}, function (data, status) 
    {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idcategoria").val(data.idcategoria);
    })
}

// funcion para desactivar registro de categoria

function desactivar(idcategoria) 
{
    bootbox.confirm("¿Estas seguro que desactivar la Categoria?",function (result) 
    {
        if(result)
        {
            $.post("../ajax/categoria.php?op=desactivar",{idcategoria : idcategoria}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }    
    });
}

// funcion para activar registro de categoria

function activar(idcategoria) 
{
    bootbox.confirm("¿Estas seguro que Activar la Categoria?",function (result) 
    {
        if(result)
        {
            $.post("../ajax/categoria.php?op=activar",{idcategoria : idcategoria}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }    
    });
}


init();