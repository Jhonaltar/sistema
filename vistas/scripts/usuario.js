var tabla;

//funcion que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) 
    {
      guardaryeditar(e);  
    })

    $("#imagenmuestra").hide();

     //Mostramos los permisos
     $.post("../ajax/usuario.php?op=permisos&id=",function(r){
        $("#permisos").html(r);
    });

}

//funcion limpiar
function limpiar() {
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagen").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val();
    $("#idusuario").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
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
            url: '../ajax/usuario.php?op=listar',
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
        "order":[[0, "desc"]] //ordenar (columna,orden)


    }).DataTable();
}

function guardaryeditar(e) {
    e.preventDefault();//no se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    })
    limpiar();
}

function mostrar(idusuario) 
{
    $.post("../ajax/usuario.php?op=mostrar",{idusuario: idusuario} , function (data,status) 
    {
        data= JSON.parse(data);
        mostrarform(true);
    
        $("#nombre").val(data.nombre);
        $('#tipo_documento').val(data.tipo_documento);
        $('#tipo_documento').selectpicker('refresh');
        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        $("#clave").val(data.clave);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idusuario").val(data.idusuario);
    });
    $.post("../ajax/usuario.php?op=permisos&id="+idusuario,function(r){
        $("#permisos").html(r);
    });    
}

// funcion para desactivar registro de Usuario 
function desactivar(idusuario) 
{
    bootbox.confirm("¿Estas Seguro de Desactivar el Usuario?", function (result) 
    {
        if(result)
        {
            $.post("../ajax/usuario.php?op=desactivar",{idusuario,idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }   
    });
}

// funcion para activar registro de Usuario 
function activar(idusuario) 
{
    bootbox.confirm("¿Estas Seguro de Activar el Usuario?", function (result) 
    {
        if(result)
        {
            $.post("../ajax/usuario.php?op=activar",{idusuario,idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }   
    });
}


init();