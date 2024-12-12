
<!-- Página 1 del informe -->
<page>
    <page_header>
        <div style="display: flex; justify-content: space-between; align-items: center; height: 60px;">
            <!-- Logo Ministerio (Izquierda) -->
            <img style="width: 180px; height: 50px; " src="../dist/img/logoMinisterio.png" alt="">
            
            <!-- Logo Huaytara (Derecha) -->
            <img style="width: 98px; height: 55px; margin-left: 360px;" src="../dist/img/logoHuaytara2.jpg" alt="">
        </div>
        <h5 class="mt-1 mb-1 tr" style="font-size: 18px;"><?php foreach ($datosObtenidos as $clave) echo "{$clave['mes']} de {$clave['anio']}"; ?></h5>
        <h3 class="tc">BOLETA DE PAGO</h3>
    </page_header>

    <table  class="tabla-datos mt-16">
    <tr>
        <th colspan="3" style="background-color: #95ceda; color: black; padding: 10px;">DATOS PERSONALES</th>
    </tr>

    <tr>
        <td id="th" style="width: 80%;"><strong>APELLIDOS</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['apellidos']}"; ?></td>
        <td id="th" style="width: 80%;"><strong>NOMBRES:</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['nombres']}"; ?></td>
        <td id="th"><strong>N° DE DOCUMENTO:</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['numeroDoc']}"; ?></td>
    </tr>

    <tr>
        <td id="th"><strong>ESTABLECIMIENTO:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['nombre']}"; ?></td>
        <td id="th" style="width: 80%;"><strong>CARGO</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['descripcion']}"; ?></td>
        <td id="th"><strong>Tipo de Boleta:</strong><br><br> 
        <?php foreach ($datosObtenidos as $clave) echo "{$clave['tipo']}"; ?></td>
        
    </tr>

    <tr>
        <td><strong>TIPO DE SERVIDOR:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['tipoServi']}"; ?></td>
        <td><strong>REGIMEN PENSIONARIO:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['regPensionario']}"; ?></td>
        <td><strong>CTA. TELEAHORRO O NRO. CHEQUE:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['cuenta']}"; ?></td>
    </tr>

    <tr>
        <td><strong>TIEMPO DE SERVICIO:</strong><br><br>
        <?php 
            $tiempoServi = $clave['tiempoServi'];

            if($tiempoServi == null){
                $tiempoServi = "0000-00-00";
            }else{
                $tiempoServi = $tiempoServi;
            }

            foreach ($datosObtenidos as $clave) echo $tiempoServi; 
        ?></td>
        <td id="th" style="width: 80%;"><strong>FECHA DE INGRESO</strong><br><br>
        <?php 
            foreach ($datosObtenidos as $clave) echo "{$clave['fechaIngreso']}"; 
        ?></td>
        <td id="th"><strong>FECHA DE TERMINO:</strong><br><br> 
        <?php 
            foreach ($datosObtenidos as $clave) echo "{$clave['fechatermino']}"; 
        ?></td>
        
    </tr>

    <tr>
        <td><strong>FECHA DE AFILIACION:</strong><br><br> 
            <?php 
                $fechaAfili = $clave['cussp'];

                if($fechaAfili == null){
                    $fechaAfili = "-";
                }else{
                    $fechaAfili = $fechaAfili;
                }


                foreach ($datosObtenidos as $clave) echo $fechaAfili;
                 ?>
        </td>
        <td><strong>LEYENDA MENSUAL:</strong><br><br>
        <?php 
            $leyendaMensual = $clave['leyendaMensual'];

            if($leyendaMensual == null){
                $leyendaMensual = '-';
            }else{
                $leyendaMensual = $leyendaMensual;
            }

            foreach ($datosObtenidos as $clave) echo $leyendaMensual; 
        ?></td>
        <td><strong>LEYENDA PERMANENTE:</strong><br><br>
        <?php 
            $leyendaPermanente = $clave['leyendaPermanente'];

            if($leyendaPermanente == null){
                $leyendaPermanente = '-';
            }else{
                $leyendaPermanente = $leyendaPermanente;
            }
            foreach ($datosObtenidos as $clave) echo $leyendaPermanente; 
        ?></td>
        
    </tr>
</table>
<br>


<table cellspacing="0" style="width: 10%; margin: auto; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11px; border: 1px solid #ddd;">
    <tr>
        <!-- Encabezado "Ingresos" -->
        <td style="width: 50%; vertical-align: top; padding-right: 5px; border-right: 1px solid #ccc;">
            <table cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #95ceda;">
                    <th colspan="2" style="text-align: center; padding: 5px; font-size: 11px; font-weight: bold; border-bottom: 1px solid #ccc;">
                        INGRESOS
                    </th>
                </tr>
            </thead>
                <tbody>
                     <?php foreach ($conceptosObtenidos as $clave) {
                        if ($clave['tipo'] == 'I') { // Verifica si es ingreso

                            $montoIngresos = number_format($clave['monto'] , 2);

                            echo "
                                <tr style='border-bottom: 1px solid #ddd;'>
                                    <th style='padding: 3px; text-align: left;'>+{$clave['nombre']}</th>
                                    <th style='padding: 3px; text-align: right;'>$montoIngresos</th>
                                </tr>
                            ";
                        }
                    } ?>
                </tbody>
            </table>
        </td>

        <!-- Encabezado "Descuentos" -->
        <td style="width: 50%; vertical-align: top; padding-left: 5px;">
            <table cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #95ceda;">
                    <th colspan="2" style="text-align: center; padding: 5px; font-size: 11px; font-weight: bold; border-bottom: 1px solid #ccc;">
                        EGRESOS
                    </th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ($conceptosObtenidos as $clave) {
                            if ($clave['tipo'] == 'E') { // Verifica si es ingreso

                                $montoEgresos = number_format($clave['monto'] , 2);

                                echo "
                                    <tr style='border-bottom: 1px solid #ddd;'>
                                        <th style='padding: 3px; text-align: left;'>-{$clave['nombre']}</th>
                                        <th style='padding: 3px; text-align: right;'>$montoEgresos</th>
                                    </tr>
                                ";
                            }
                        } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<br>
<table  class="tabla-datos2">

    <tr>
        <td id="th" style="width: 85%;background-color: #95ceda;"><strong>TOTAL REMUNERACION:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php foreach ($datosObtenidos as $clave) echo "{$clave['totalRemuneracion']}"; ?></td>
        <td id="th" style="width: 83%;background-color: #95ceda;"><strong>TOTAL DESCUENTO:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php foreach ($datosObtenidos as $clave) echo "{$clave['totalDescuento']}"; ?></td>
    </tr>

    <tr>
        <td id="th" style="width: 85%;background-color: #95ceda;"><strong>TOTAL LIQUIDO:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php foreach ($datosObtenidos as $clave) echo "{$clave['totalLiquido']}"; ?></td>
        <td id="th" style="width: 83%;background-color: #95ceda;"><strong>MONTO IMPONIBLE:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php foreach ($datosObtenidos as $clave) echo "{$clave['montoImponible']}"; ?></td>
    </tr>
    
</table>
        

    <page_footer>
        <p> Pag - [[page_cu]]</p>
    </page_footer>

</page>
