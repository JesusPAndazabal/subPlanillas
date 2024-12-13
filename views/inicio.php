<?php
session_start();
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
        height: 78vh; /* Altura del contenedor */
        padding: 20px; /* Espaciado interno */
        box-sizing: border-box; /* Incluir padding en las dimensiones */
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
                echo date("l, d F Y - h:i A"); // Día, Fecha y Hora actual
            ?>
        </div>
    </div>
</div>

<script src="dist/js/colors-chart.js"></script>
<script src="dist/js/options-chart.js"></script>
<script src="dist/js/other/graficos.js"></script>
