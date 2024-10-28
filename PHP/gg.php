<?php
include('./db.php'); // Include your database connection

// Initialize a PDO connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

// Fetch invoices for the initial load
$sql = "SELECT * FROM factura";
$stmt = $conn->prepare($sql);
$stmt->execute();
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Facturas</title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="head">
        <header>
            <h3>Gestión de Facturas</h3>
        </header>
        <div class="command">
            <button id="altaBtn">Nueva Factura</button>
            <button id="cargar">Cargar Facturas</button>
            <button id="vaciar">Vaciar Datos</button>
            <button id="btLimpiarFiltros">Limpiar Filtros</button>
            <button class="close-session" onclick="window.location.href='DestruirSesion.php'">Terminar sesión</button>
            <input type="text" id="selectedColumn" placeholder="Columna Seleccionada" readonly style="margin-left: 10px;">
        </div>
    </div>

    <div class="modales">
        <dialog class="modalAlta">
            <iframe src="./altaform.php" width='800px' height='500px' frameborder="0"></iframe>
            <button class='cerrarventana' onclick="cerrarAlta()">X</button>
        </dialog>
        <dialog class="modalModi">
            <form id="formDeModi" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <input type="text" id="nro_factura" name="nro_factura" placeholder="Número de Factura" required>
                <input type="text" id="cuil_emisor" name="cuil_emisor" placeholder="CUIL Emisor" required>
                <input type="text" id="cuil_receptor" name="cuil_receptor" placeholder="CUIL Receptor" required>
                <input type="number" id="monto" name="monto" placeholder="Monto" required>
                <select id="iva" name="iva" required>
                    <option value="10.50">10.50</option>
                    <option value="21">21</option>
                    <option value="27">27</option>
                </select>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" required>
                <button type="submit">Modificar Factura</button>
            </form>
            <button class='cerrarventana' onclick="cerrarModi()">X</button>
        </dialog>
        <!-- Modal para mostrar el PDF -->
        <dialog id="pdfModal">
            <iframe id="pdfViewer" width="800px" height="500px" frameborder="0"></iframe>
            <button onclick="cerrarPdfModal()">Cerrar</button>
        </dialog>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th data-column="id">ID</th>
                    <th data-column="nro_factura">Nro de Factura</th>
                    <th data-column="cuil_emisor">CUIL Emisor</th>
                    <th data-column="cuil_receptor">CUIL Receptor</th>
                    <th data-column="monto">Monto</th>
                    <th data-column="iva">IVA</th>
                    <th data-column="descripcion">Descripción</th>
                    <th data-column="fecha">Fecha</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <th><input type="text" id="filterID" placeholder="Filtrar ID"></th>
                    <th><input type="text" id="filterNroFactura" placeholder="Filtrar Nro de Factura"></th>
                    <th><input type="text" id="filterCuilEmisor" placeholder="Filtrar CUIL Emisor"></th>
                    <th><input type="text" id="filterCuilReceptor" placeholder="Filtrar CUIL Receptor"></th>
                    <th><input type="number" id="filterMonto" placeholder="Filtrar Monto"></th>
                    <th>
                        <select id="filterIVA">
                            <option value="">Filtrar IVA</option>
                            <option value="10.50">10.50</option>
                            <option value="21">21</option>
                            <option value="27">27</option>
                        </select>
                    </th>
                    <th><input type="text" id="filterDescripcion" placeholder="Filtrar Descripción"></th>
                    <th><input type="date" id="filterFecha"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbDatos">
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?php echo $factura['id']; ?></td>
                        <td><?php echo $factura['nro_factura']; ?></td>
                        <td><?php echo $factura['cuil_emisor']; ?></td>
                        <td><?php echo $factura['cuil_receptor']; ?></td>
                        <td><?php echo $factura['monto']; ?></td>
                        <td><?php echo $factura['iva']; ?></td>
                        <td><?php echo $factura['descripcion']; ?></td>
                        <td><?php echo $factura['fecha']; ?></td>
                        <td>
                            <button class="modificar" data-id="<?php echo $factura['id']; ?>">Modificar</button>
                            <button class="borrar" data-id="<?php echo $factura['id']; ?>">Borrar</button>
                            <button class="ver-pdf" data-id="<?php echo $factura['id']; ?>">Ver PDF</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="contador-container">
        Contador de Facturas: <span id="facturaCount"><?php echo count($facturas); ?></span>
    </div>

    <footer>
        <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
    </footer>
<script>
    $(document).ready(function() {
        const modalAlta = document.querySelector(".modalAlta");
        const modalModi = document.querySelector(".modalModi");

        // Open the alta modal with empty fields
        $('#altaBtn').click(function() {
            $('#formDeModi')[0].reset(); // Reset the fields in the form
            $('#id').val(''); // Ensure the hidden ID field is empty
            modalAlta.showModal();
        });

        function cerrarAlta() {
            modalAlta.close();
        }

        function cerrarModi() {
            modalModi.close();
        }

        // Define the cerrarPdfModal function
        window.cerrarPdfModal = function() {
            const pdfModal = document.querySelector("#pdfModal");
            pdfModal.close(); // Close modal using the native method
        };

        window.cerrarAlta = cerrarAlta;
        window.cerrarModi = cerrarModi;

        // Load data into the table
        $("#cargar").click(function() {
            cargaTabla();
        });

        function cargaTabla() {
            $.ajax({
                type: "GET",
                url: "./facturasJSONPrepare.php",
                success: function(response) {
                    let data = JSON.parse(response);
                    $("#tbDatos").empty();
                    data.facturas.forEach(factura => {
                        $("#tbDatos").append(`
                            <tr>
                                <td>${factura.id}</td>
                                <td>${factura.nro_factura}</td>
                                <td>${factura.cuil_emisor}</td>
                                <td>${factura.cuil_receptor}</td>
                                <td>${factura.monto}</td>
                                <td>${factura.iva}</td>
                                <td>${factura.descripcion}</td>
                                <td>${factura.fecha}</td>
                                <td>
                                    <button class="modificar" data-id="${factura.id}">Modificar</button>
                                    <button class="borrar" data-id="${factura.id}">Borrar</button>
                                    <button class="ver-pdf" data-id="${factura.id}">Ver PDF</button>
                                </td>
                            </tr>
                        `);
                    });
                    $('#facturaCount').text(data.facturas.length);
                },
                error: function() {
                    alert("Error al cargar las facturas.");
                }
            });
        }

        // Clear data from the table
        $("#vaciar").click(function() {
            $("#tbDatos").empty();
            $('#facturaCount').text(0);
        });

        // Clear filters
        $("#btLimpiarFiltros").click(function() {
            document.querySelectorAll('thead input, thead select').forEach(input => input.value = '');
            cargaTabla(); // Reload data after clearing filters
        });

        // Filter data
        $("input, select").on("input change", function() {
            const filterID = $("#filterID").val().toLowerCase();
            const filterNroFactura = $("#filterNroFactura").val().toLowerCase();
            const filterCuilEmisor = $("#filterCuilEmisor").val().toLowerCase();
            const filterCuilReceptor = $("#filterCuilReceptor").val().toLowerCase();
            const filterMonto = $("#filterMonto").val();
            const filterIVA = $("#filterIVA").val();
            const filterDescripcion = $("#filterDescripcion").val().toLowerCase();
            const filterFecha = $("#filterFecha").val();

            $("#tbDatos tr").filter(function() {
                $(this).toggle(
                    ($(this).find("td:nth-child(1)").text().toLowerCase().indexOf(filterID) > -1 || filterID === "") &&
                    ($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(filterNroFactura) > -1 || filterNroFactura === "") &&
                    ($(this).find("td:nth-child(3)").text().toLowerCase().indexOf(filterCuilEmisor) > -1 || filterCuilEmisor === "") &&
                    ($(this).find("td:nth-child(4)").text().toLowerCase().indexOf(filterCuilReceptor) > -1 || filterCuilReceptor === "") &&
                    ($(this).find("td:nth-child(5)").text().indexOf(filterMonto) > -1 || filterMonto === "") &&
                    ($(this).find("td:nth-child(6)").text().indexOf(filterIVA) > -1 || filterIVA === "") &&
                    ($(this).find("td:nth-child(7)").text().toLowerCase().indexOf(filterDescripcion) > -1 || filterDescripcion === "") &&
                    (filterFecha === "" || $(this).find("td:nth-child(8)").text() === filterFecha)
                );
            });
        });

        // Modify invoice
        $(document).on("click", ".modificar", function() {
            const id = $(this).data("id");
            $.ajax({
                url: './modificar.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    let factura = JSON.parse(response);
                    if (factura.status && factura.status === "error") {
                        alert(factura.message); // Handle error
                    } else {
                        // Load data into the form without PDF
                        $('#id').val(factura.id);
                        $('#nro_factura').val(factura.nro_factura);
                        $('#cuil_emisor').val(factura.cuil_emisor);
                        $('#cuil_receptor').val(factura.cuil_receptor);
                        $('#monto').val(factura.monto);
                        $('#iva').val(factura.iva);
                        $('#descripcion').val(factura.descripcion);
                        modalModi.showModal(); // Show the modal
                    }
                },
                error: function() {
                    alert("Error al cargar los datos de la factura.");
                }
            });
        });

        // Delete invoice
        $(document).on("click", ".borrar", function() {
            const id = $(this).data("id");
            if (confirm("¿Estás seguro de que deseas borrar esta factura?")) {
                $.ajax({
                    url: './borrar.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        const result = JSON.parse(response);
                        alert(result.message); // Show success or error message
                        if (result.status === "success") {
                            cargaTabla(); // Reload the table after successful delete
                        }
                    },
                    error: function() {
                        alert("Error al borrar la factura.");
                    }
                });
            }
        });

        // View PDF
        $(document).on("click", ".ver-pdf", function() {
            const id = $(this).data("id");
            $.ajax({
                url: './obtenerPdf.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    try {
                        const factura = JSON.parse(response);
                        if (factura.pdf) {
                            const pdfData = factura.pdf;
                            $('#pdfViewer').attr('src', 'data:application/pdf;base64,' + pdfData);
                            const pdfModal = document.querySelector("#pdfModal");
                            pdfModal.showModal(); // Show modal using the native method
                        } else {
                            alert("No se encontró el PDF.");
                        }
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        alert("Error al cargar el PDF. Respuesta del servidor no es JSON.");
                    }
                },
                error: function() {
                    alert("Error al cargar el PDF.");
                }
            });
        });

        // Handle form submission for modification
        $('#formDeModi').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Get form data

            $.ajax({
                url: './modificar.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const result = JSON.parse(response);
                    alert(result.message); // Show success or error message
                    if (result.status === "success") {
                        cargaTabla(); // Reload the table after successful update
                        cerrarModi(); // Close the modal
                    }
                },
                error: function() {
                    alert("Error al modificar la factura.");
                }
            });
        });

        // Sort table columns when header is clicked
        $("th[data-column]").click(function() {
            const column = $(this).data("column");
            const rows = $("#tbDatos tr").get();
            const ascending = $(this).hasClass("asc");

            rows.sort(function(a, b) {
                const keyA = $(a).find("td").eq($(this).index()).text();
                const keyB = $(b).find("td").eq($(this).index()).text();
                if ($.isNumeric(keyA) && $.isNumeric(keyB)) {
                    return ascending ? keyA - keyB : keyB - keyA;
                }
                return ascending ? keyA.localeCompare(keyB) : keyB.localeCompare(keyA);
            }.bind(this));

            $.each(rows, function(index, row) {
                $("#tbDatos").append(row);
            });

            // Update selected column display
            $('#selectedColumn').val($(this).text() + " (Ordenado " + (ascending ? "ascendente" : "descendente") + ")");

            // Toggle the class for the next sorting order
            $(this).toggleClass("asc").toggleClass("desc");
        });
    });
</script>

</body>
</html>



<?php
include('./db.php'); // Include your database connection

// Initialize a PDO connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

// Check if it's a GET request to fetch invoice details
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $Id = $_GET['id'];
    $sql = "SELECT * FROM factura WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $Id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode($result); // Return the invoice data as JSON
    } else {
        echo json_encode(["status" => "error", "message" => "Factura no encontrada."]);
    }
    exit; // Exit after handling GET request
}

// Handle POST request to update invoice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id = $_POST['id'];
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $iva = $_POST['iva'];
    $descripcion = $_POST['descripcion'];

    // Prepare SQL statement
    $sql = "UPDATE factura SET nro_factura = :nro_factura, cuil_emisor = :cuil_emisor, 
            cuil_receptor = :cuil_receptor, monto = :monto, iva = :iva, 
            descripcion = :descripcion WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $Id);
    $stmt->bindParam(':nro_factura', $nro_factura);
    $stmt->bindParam(':cuil_emisor', $cuil_emisor);
    $stmt->bindParam(':cuil_receptor', $cuil_receptor);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':iva', $iva);
    $stmt->bindParam(':descripcion', $descripcion);

    try {
        $stmt->execute();
        echo json_encode(["status" => "success", "message" => "Factura actualizada exitosamente"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error al actualizar: " . $e->getMessage()]);
    }
}
?>




<?php
include('./db.php'); // Include your database connection

// Initialize a PDO connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

// Fetch invoices for the initial load
$sql = "SELECT * FROM factura";
$stmt = $conn->prepare($sql);
$stmt->execute();
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Facturas</title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="head">
        <header>
            <h3>Gestión de Facturas</h3>
        </header>
        <div class="command">
            <button id="altaBtn">Nueva Factura</button>
            <button id="cargar">Cargar Facturas</button>
            <button id="vaciar">Vaciar Datos</button>
            <button id="btLimpiarFiltros">Limpiar Filtros</button>
            <button class="close-session" onclick="window.location.href='DestruirSesion.php'">Terminar sesión</button>
            <input type="text" id="selectedColumn" placeholder="Columna Seleccionada" readonly style="margin-left: 10px;">
        </div>
    </div>

    <div class="modales">
        <dialog class="modalAlta">
            <iframe src="./altaform.php" width='800px' height='500px' frameborder="0"></iframe>
            <button class='cerrarventana' onclick="cerrarAlta()">X</button>
        </dialog>
        <dialog class="modalModi">
            <form id="formDeModi" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <input type="text" id="nro_factura" name="nro_factura" placeholder="Número de Factura" required>
                <input type="text" id="cuil_emisor" name="cuil_emisor" placeholder="CUIL Emisor" required>
                <input type="text" id="cuil_receptor" name="cuil_receptor" placeholder="CUIL Receptor" required>
                <input type="number" id="monto" name="monto" placeholder="Monto" required>
                <select id="iva" name="iva" required>
                    <option value="10.50">10.50</option>
                    <option value="21">21</option>
                    <option value="27">27</option>
                </select>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" required>
                <button type="submit">Modificar Factura</button>
            </form>
            <button class='cerrarventana' onclick="cerrarModi()">X</button>
        </dialog>
        <!-- Modal para mostrar el PDF -->
        <dialog id="pdfModal">
            <iframe id="pdfViewer" width="800px" height="500px" frameborder="0"></iframe>
            <button onclick="cerrarPdfModal()">Cerrar</button>
        </dialog>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th data-column="id">ID</th>
                    <th data-column="nro_factura">Nro de Factura</th>
                    <th data-column="cuil_emisor">CUIL Emisor</th>
                    <th data-column="cuil_receptor">CUIL Receptor</th>
                    <th data-column="monto">Monto</th>
                    <th data-column="iva">IVA</th>
                    <th data-column="descripcion">Descripción</th>
                    <th data-column="fecha">Fecha</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <th><input type="text" id="filterID" placeholder="Filtrar ID"></th>
                    <th><input type="text" id="filterNroFactura" placeholder="Filtrar Nro de Factura"></th>
                    <th><input type="text" id="filterCuilEmisor" placeholder="Filtrar CUIL Emisor"></th>
                    <th><input type="text" id="filterCuilReceptor" placeholder="Filtrar CUIL Receptor"></th>
                    <th><input type="number" id="filterMonto" placeholder="Filtrar Monto"></th>
                    <th>
                        <select id="filterIVA">
                            <option value="">Filtrar IVA</option>
                            <option value="10.50">10.50</option>
                            <option value="21">21</option>
                            <option value="27">27</option>
                        </select>
                    </th>
                    <th><input type="text" id="filterDescripcion" placeholder="Filtrar Descripción"></th>
                    <th><input type="date" id="filterFecha"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbDatos">
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?php echo $factura['id']; ?></td>
                        <td><?php echo $factura['nro_factura']; ?></td>
                        <td><?php echo $factura['cuil_emisor']; ?></td>
                        <td><?php echo $factura['cuil_receptor']; ?></td>
                        <td><?php echo $factura['monto']; ?></td>
                        <td><?php echo $factura['iva']; ?></td>
                        <td><?php echo $factura['descripcion']; ?></td>
                        <td><?php echo $factura['fecha']; ?></td>
                        <td>
                            <button class="modificar" data-id="<?php echo $factura['id']; ?>">Modificar</button>
                            <button class="borrar" data-id="<?php echo $factura['id']; ?>">Borrar</button>
                            <button class="ver-pdf" data-id="<?php echo $factura['id']; ?>">Ver PDF</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="contador-container">
        Contador de Facturas: <span id="facturaCount"><?php echo count($facturas); ?></span>
    </div>

    <footer>
        <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
    </footer>
<script>
    $(document).ready(function() {
        const modalAlta = document.querySelector(".modalAlta");
        const modalModi = document.querySelector(".modalModi");

        // Open the alta modal with empty fields
        $('#altaBtn').click(function() {
            $('#formDeModi')[0].reset(); // Reset the fields in the form
            $('#id').val(''); // Ensure the hidden ID field is empty
            modalAlta.showModal();
        });

        function cerrarAlta() {
            modalAlta.close();
        }

        function cerrarModi() {
            modalModi.close();
        }

        // Define the cerrarPdfModal function
        window.cerrarPdfModal = function() {
            const pdfModal = document.querySelector("#pdfModal");
            pdfModal.close(); // Close modal using the native method
        };

        window.cerrarAlta = cerrarAlta;
        window.cerrarModi = cerrarModi;

        // Load data into the table
        $("#cargar").click(function() {
            cargaTabla();
        });

        function cargaTabla() {
            $.ajax({
                type: "GET",
                url: "./facturasJSONPrepare.php",
                success: function(response) {
                    let data = JSON.parse(response);
                    $("#tbDatos").empty();
                    data.facturas.forEach(factura => {
                        $("#tbDatos").append(`
                            <tr>
                                <td>${factura.id}</td>
                                <td>${factura.nro_factura}</td>
                                <td>${factura.cuil_emisor}</td>
                                <td>${factura.cuil_receptor}</td>
                                <td>${factura.monto}</td>
                                <td>${factura.iva}</td>
                                <td>${factura.descripcion}</td>
                                <td>${factura.fecha}</td>
                                <td>
                                    <button class="modificar" data-id="${factura.id}">Modificar</button>
                                    <button class="borrar" data-id="${factura.id}">Borrar</button>
                                    <button class="ver-pdf" data-id="${factura.id}">Ver PDF</button>
                                </td>
                            </tr>
                        `);
                    });
                    $('#facturaCount').text(data.facturas.length);
                },
                error: function() {
                    alert("Error al cargar las facturas.");
                }
            });
        }

        // Clear data from the table
        $("#vaciar").click(function() {
            $("#tbDatos").empty();
            $('#facturaCount').text(0);
        });

        // Clear filters
        $("#btLimpiarFiltros").click(function() {
            document.querySelectorAll('thead input, thead select').forEach(input => input.value = '');
            cargaTabla(); // Reload data after clearing filters
        });

        // Filter data
        $("input, select").on("input change", function() {
            const filterID = $("#filterID").val().toLowerCase();
            const filterNroFactura = $("#filterNroFactura").val().toLowerCase();
            const filterCuilEmisor = $("#filterCuilEmisor").val().toLowerCase();
            const filterCuilReceptor = $("#filterCuilReceptor").val().toLowerCase();
            const filterMonto = $("#filterMonto").val();
            const filterIVA = $("#filterIVA").val();
            const filterDescripcion = $("#filterDescripcion").val().toLowerCase();
            const filterFecha = $("#filterFecha").val();

            $("#tbDatos tr").filter(function() {
                $(this).toggle(
                    ($(this).find("td:nth-child(1)").text().toLowerCase().indexOf(filterID) > -1 || filterID === "") &&
                    ($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(filterNroFactura) > -1 || filterNroFactura === "") &&
                    ($(this).find("td:nth-child(3)").text().toLowerCase().indexOf(filterCuilEmisor) > -1 || filterCuilEmisor === "") &&
                    ($(this).find("td:nth-child(4)").text().toLowerCase().indexOf(filterCuilReceptor) > -1 || filterCuilReceptor === "") &&
                    ($(this).find("td:nth-child(5)").text().indexOf(filterMonto) > -1 || filterMonto === "") &&
                    ($(this).find("td:nth-child(6)").text().indexOf(filterIVA) > -1 || filterIVA === "") &&
                    ($(this).find("td:nth-child(7)").text().toLowerCase().indexOf(filterDescripcion) > -1 || filterDescripcion === "") &&
                    (filterFecha === "" || $(this).find("td:nth-child(8)").text() === filterFecha)
                );
            });
        });

        // Modify invoice
        $(document).on("click", ".modificar", function() {
            const id = $(this).data("id");
            $.ajax({
                url: './modificar.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    let factura = JSON.parse(response);
                    if (factura.status && factura.status === "error") {
                        alert(factura.message); // Handle error
                    } else {
                        // Load data into the form without PDF
                        $('#id').val(factura.id);
                        $('#nro_factura').val(factura.nro_factura);
                        $('#cuil_emisor').val(factura.cuil_emisor);
                        $('#cuil_receptor').val(factura.cuil_receptor);
                        $('#monto').val(factura.monto);
                        $('#iva').val(factura.iva);
                        $('#descripcion').val(factura.descripcion);
                        modalModi.showModal(); // Show the modal
                    }
                },
                error: function() {
                    alert("Error al cargar los datos de la factura.");
                }
            });
        });

        // Delete invoice
        $(document).on("click", ".borrar", function() {
            const id = $(this).data("id");
            if (confirm("¿Estás seguro de que deseas borrar esta factura?")) {
                $.ajax({
                    url: './borrar.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        const result = JSON.parse(response);
                        alert(result.message); // Show success or error message
                        if (result.status === "success") {
                            cargaTabla(); // Reload the table after successful delete
                        }
                    },
                    error: function() {
                        alert("Error al borrar la factura.");
                    }
                });
            }
        });

        // View PDF
        $(document).on("click", ".ver-pdf", function() {
            const id = $(this).data("id");
            $.ajax({
                url: './obtenerPdf.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    try {
                        const factura = JSON.parse(response);
                        if (factura.pdf) {
                            const pdfData = factura.pdf;
                            $('#pdfViewer').attr('src', 'data:application/pdf;base64,' + pdfData);
                            const pdfModal = document.querySelector("#pdfModal");
                            pdfModal.showModal(); // Show modal using the native method
                        } else {
                            alert("No se encontró el PDF.");
                        }
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        alert("Error al cargar el PDF. Respuesta del servidor no es JSON.");
                    }
                },
                error: function() {
                    alert("Error al cargar el PDF.");
                }
            });
        });

        // Handle form submission for modification
        $('#formDeModi').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Get form data

            $.ajax({
                url: './modificar.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const result = JSON.parse(response);
                    alert(result.message); // Show success or error message
                    if (result.status === "success") {
                        cargaTabla(); // Reload the table after successful update
                        cerrarModi(); // Close the modal
                    }
                },
                error: function() {
                    alert("Error al modificar la factura.");
                }
            });
        });

        // Sort table columns when header is clicked
        $("th[data-column]").click(function() {
            const column = $(this).data("column");
            const rows = $("#tbDatos tr").get();
            const ascending = $(this).hasClass("asc");

            rows.sort(function(a, b) {
                const keyA = $(a).find("td").eq($(this).index()).text();
                const keyB = $(b).find("td").eq($(this).index()).text();
                if ($.isNumeric(keyA) && $.isNumeric(keyB)) {
                    return ascending ? keyA - keyB : keyB - keyA;
                }
                return ascending ? keyA.localeCompare(keyB) : keyB.localeCompare(keyA);
            }.bind(this));

            $.each(rows, function(index, row) {
                $("#tbDatos").append(row);
            });

            // Update selected column display
            $('#selectedColumn').val($(this).text() + " (Ordenado " + (ascending ? "ascendente" : "descendente") + ")");

            // Toggle the class for the next sorting order
            $(this).toggleClass("asc").toggleClass("desc");
        });
    });
</script>

</body>
</html>