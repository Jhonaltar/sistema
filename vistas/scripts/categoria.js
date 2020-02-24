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