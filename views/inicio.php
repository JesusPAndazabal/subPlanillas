<?php
session_start();
date_default_timezone_set('America/Lima'); // Configura la zona horaria

// Crear el formateador de fecha
$formatter = new IntlDateFormatter(
    'es_ES', // Locale en español
    IntlDateFormatter::FULL, // Nivel de detalle de la fecha (puedes usar SHORT, MEDIUM, LONG o FULL)
    IntlDateFormatter::SHORT // Nivel de detalle de la hora
);

// Configurar el formato personalizado
$formatter->setPattern('EEEE, d \'de\' MMMM \'de\' yyyy - h:mm a');

// Obtener la fecha y hora actual
$fechaHoraActual = $formatter->format(new DateTime());
?>

<style>
    /* Estilos generales */
    body {
        margin: 0;
        padding: 0;
        height: 100vh; /* Altura total de la ventana */
        display: flex;
        flex-direction: column;
    }

    .contenedor-Imagen {
        background-color: #27AE60;
        display: flex;
        flex-direction: row; /* Elementos en fila */
        justify-content: space-between; /* Separar elementos */
        align-items: center; /* Alinear verticalmente */
        height: 48vh; /* Altura del contenedor */
        padding: 20px; /* Espaciado interno */
        box-sizing: border-box; /* Incluir padding en las dimensiones */
        margin-top: 8%;
    }

    .logo {
        width: 50%; /* Aumenta el tamaño del logo */
        max-width: none; /* Elimina la restricción de tamaño máximo */
        height: auto; /* Mantiene la proporción */
    }

    .texto-contenedor {
        color: #fff; /* Texto blanco */
        text-align: center; /* Alinear texto a la izquierda */
        flex: 1; /* Ocupa todo el espacio restante */
        padding-left: 20px; /* Separar del logo */
    }

    .titulo {
        font-size: 36px; /* Tamaño del título */
        font-weight: bold; /* Negrita */
        margin: 0; /* Sin márgenes */
    }

    .fecha-hora {
        font-size: 20px; /* Tamaño de la fecha y hora */
        margin-top: 10px; /* Espaciado superior */
    }
</style>

<div class='callout callout-success'>
    <h3 class='text-center'>Inicio <i class='fas fa-chart-bar ml-2'></i></h3>
</div>

<div class="contenedor-Imagen">
    <!-- Logo a la izquierda -->
    <img src="dist/img/logoHuaytara.png" alt="Logo Huaytara" class="logo">

    <!-- Texto a la derecha -->
    <div class="texto-contenedor">
        <div class="titulo">APLICATIVO PARA CONSULTA DE BOLETAS</div>
        <div class="fecha-hora">
            <?php 
                echo $fechaHoraActual; // Mostrar la fecha y hora formateada
            ?>
        </div>
    </div>
</div>

<script src="dist/js/colors-chart.js"></script>
<script src="dist/js/options-chart.js"></script>
<script src="dist/js/other/graficos.js"></script>
