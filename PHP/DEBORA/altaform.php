<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Factura</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./AltaForm.css">
</head>

<body>
    <h2 style="text-align:center; color: #E0E0E0; font-size: 1.5em;">Nueva Factura</h2>
    <form id="formDeAlta" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nro_factura">Número de Factura</label>
            <input type="text" id="nro_factura" name="nro_factura" required>
        </div>
        <div class="form-group">
            <label for="cuil_emisor">CUIL Emisor</label>
            <input type="text" id="cuil_emisor" name="cuil_emisor" required>
        </div>
        <div class="form-group">
            <label for="cuil_receptor">CUIL Receptor</label>
            <input type="text" id="cuil_receptor" name="cuil_receptor" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" id="monto" name="monto" required>
        </div>
        <div class="form-group">
            <label for="iva">IVA</label>
            <select id="iva" name="iva" required>
                <option value="10.50">10.50</option>
                <option value="21">21</option>
                <option value="27">27</option>
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="pdf">Archivo PDF</label>
            <input type="file" id="pdf" name="pdf" accept=".pdf">
        </div>
        <button id="submits" type="submit">Enviar Formulario</button>
    </form>

    <script>
        $(document).ready(function () {
            //ejecuta el htlm 
            $("#submits").click(function (e) {
                e.preventDefault(); // recarga la paguina
                var data = new FormData($("#formDeAlta")[0]);// nuevo objeto con nuevo id
                $.ajax({//solicitud ajax
                    type: 'POST',
                    url: "./alta.php",
                    processData: false,//permite enviar archivos
                    contentType: false,// formularios
                    cache: false,//no
                    data: data,// envis form
                    success: function (response) {
                        console.log(response); 
                        alert("Factura registrada exitosamente.");
                        
                        $("#formDeAlta")[0].reset();//se reinicia el form
                    },
                    error: function () {
                        alert("Error al registrar la factura.");
                    }
                });
            });
        });
    </script>
</body>
</html>