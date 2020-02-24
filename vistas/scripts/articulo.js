var tabla;

//funcion que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) 
    {
      guardaryeditar(e);  
    })

    //Cargamos los items al select categoria
    $.post("../ajax/articulo.php?op=selectCategoria", function (r) {
        $("#idcategoria").html(r);
        $("#idcategoria").selectpicker('refresh');
    });
    $("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar() {
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#imagen").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val();
    $("#print").hide();
    $("#idarticulo").val("");
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
            url: '../ajax/articulo.php?op=listar',
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

function guardaryeditar(e) {
    e.preventDefault();//no se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
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

function mostrar(idarticulo) 
{
    $.post("../ajax/articulo.php?op=mostrar",{idarticulo: idarticulo} , function (data,status) 
    {
        data= JSON.parse(data);
        mostrarform(true);
        
        $("#idcategoria").val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idarticulo").val(data.idarticulo);
        generarbarcode();
    });    
}

// funcion para desactivar registro de Articulo 
function desactivar(idarticulo) 
{
    bootbox.confirm("¿Estas Seguro de Desactivar el Articulo?", function (result) 
    {
        if(result)
        {
            $.post("../ajax/articulo.php?op=desactivar",{idarticulo,idarticulo}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }   
    });
}

// funcion para activar registro de Articulo 
function activar(idarticulo) 
{
    bootbox.confirm("¿Estas Seguro de Activar el Articulo?", function (result) 
    {
        if(result)
        {
            $.post("../ajax/articulo.php?op=activar",{idarticulo,idarticulo}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            })
        }   
    });
}

//funcion para generar el codigo de barras
function generarbarcode() 
{
    codigo=$("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
}

//funcion para imprimir codigo de barra
function imprimir() 
{
    $("#print").printArea();
}

init();