
<!-- Página 1 del informe -->
<page>
<page_header>
    <div style="display: flex; justify-content: space-between; align-items: center; height: 60px;">
        <!-- Logo Ministerio (Izquierda) -->
        <img style="width: 180px; height: 50px; " src="../dist/img/logoMinisterio.png" alt="">
        
        <!-- Logo Huaytara (Derecha) -->
        <img style="width: 98px; height: 55px; margin-left: 360px;" src="../dist/img/logoHuaytara2.jpg" alt="">
    </div>
    <h5 class="mt-1 mb-1 tr"><?php foreach ($datosObtenidos as $clave) echo "{$clave['mes']} de {$clave['anio']}"; ?></h5>
    <h3 class="tc">BOLETA DE PAGO</h3>
    </page_header>


   <!--  <h4 class="mt-16 tc mb-4">Periodo :&nbsp;<?php foreach ($datosObtenidos as $clave){ echo "{$clave['mes']}";}?> - <?php foreach ($datosObtenidos as $clave){echo "{$clave['anio']}";}?></h4>
 -->
    




 <table  class="tabla-datos mt-16">
    <tr>
        <th colspan="3" style="background-color: #95ceda; color: black; padding: 10px;">DATOS PERSONALES</th>
    </tr>

    <tr>
        <td id="th"><strong>APELLIDOS:</strong><br><br> <?php foreach ($datosObtenidos2 as $clave) echo "{$clave['apellidos']}"; ?></td>
        <td id="th"><strong>NOMBRES:</strong><br><br> <?php foreach ($datosObtenidos2 as $clave) echo "{$clave['nombres']}"; ?></td>
        <td id="th"><strong>CODIGO MODULAR:</strong><br><br>
            <?php 
            foreach ($datosObtenidos as $clave) {
                $anio = $clave['anio'];
                $codigoInstitucion = ($anio <= 2002) ? $clave['codigomodular'] : $clave['codigodni'];
                echo $codigoInstitucion;
            }
            ?>
        </td>
    </tr>

    <tr>
        <td id="th"><strong>INSTITUCION:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['nombre']}"; ?></td>
        <td id="th"><strong>CODIGO DE INSTITUCION:</strong><br><br> 
            <?php 
            foreach ($datosObtenidos as $clave) {
                $anio = $clave['anio'];
                $codigoEmpleado = ($anio <= 2003) ? $clave['codlegacy'] : $clave['codactual'];
                echo $codigoEmpleado;
            }
            ?>
        </td>
        <td id="th"><strong>ESTADO DEL EMPLEADO:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['activo']}"; ?></td>
    </tr>

    <tr>
        <td id="th"><strong>CARGO:</strong><br><br> <?php foreach ($datosObtenidos as $clave) echo "{$clave['cargo']}"; ?></td>
        <td id="th"><strong>NIVEL DE EDUCACION:</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['nivel']}"; ?></td>
        <td id="th"><strong>TIPO DE EMPLEADO:</strong><br><br><?php foreach ($datosObtenidos as $clave) echo "{$clave['tipoempleado']}"; ?></td>
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
                    <?php foreach ($datosIngresosCol1 as $clave) {
                        $monto = $clave['monto'];
                        $numeroConvertido = ($anio <= 1991) ? number_format($monto, 3) : number_format($monto, 2);

                        echo "
                            <tr style='border-bottom: 1px solid #ddd;'>
                                <th style='padding: 3px; text-align: left;'>+{$clave['nombre']}</th>
                                <th style='padding: 3px; text-align: right;'>$numeroConvertido</th>
                            </tr>
                        ";
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
                        DESCUENTOS
                    </th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ($datosEgresos as $clave) {
                        $monto = $clave['monto'];
                        $numeroConvertido = ($anio <= 1991) ? number_format($monto, 3) : number_format($monto, 2);

                        echo "
                            <tr style='border-bottom: 1px solid #ddd;'>
                                <th style='padding: 3px; text-align: left;'>-{$clave['nombre']}</th>
                                <th style='padding: 3px; text-align: right;'>$numeroConvertido</th>
                            </tr>
                        ";
                    } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>




        

    <br>


    <table  class="tabla-datos2">

    <tr>
        <td id="th" style="width: 85%;background-color: #95ceda;"><strong>TOTAL HABERES:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php foreach ($sumarIngresos as $clave){
            $sumingreso = $clave['ingreso'];
                    
            if($anio <= 1991){
                $sumaIngresos = number_format($sumingreso,3);
            }else if($anio >=1992 ){
                $sumaIngresos = number_format($sumingreso,2);
            }

            echo $sumaIngresos; $ingresos = $sumingreso;
            }
            ?>
        </td>
        <td id="th" style="width: 83%;background-color: #95ceda;"><strong>TOTAL DESCUENTO:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php foreach ($sumarEgresos as $clave){

                $sumegreso = $clave['egreso'];

                if($anio <= 1991){
                    $sumaEgresos = number_format($sumegreso,3);
                }else if($anio >=1992 ){
                    $sumaEgresos = number_format($sumegreso,2);
                }

                echo $sumaEgresos;
                }
                ?>
        </td>
    </tr>

    <tr>
        <td id="th" style="width: 85%;background-color: #95ceda;"><strong>TOTAL LIQUIDO:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php 
            $totalLiquido =  $ingresos - $clave['egreso'];
    
                
            if($anio <= 1991){
                $format_number1 = number_format($totalLiquido,3);
            }else if($anio >=1992 ){
                $format_number1 = number_format($totalLiquido,2);
            }
            
            
            echo $format_number1 ?>
        </td>
        <td id="th" style="width: 83%;background-color: #95ceda;"><strong>MONTO IMPONIBLE:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php foreach ($datosObtenidos2 as $clave) echo "{$clave['montoimponible']}"; ?>
        </td>
    </tr>
    
</table>



    <qrcode  value="http://192.168.164.120/querysheet/reports/reporte/<?php foreach ($datosObtenidos as $clave){
            echo "
                {$clave['idboleta']}  
            ";            
        }
        ?>" style="width: 40mm; background-color: white; color: black; margin-left:76%; margin-top:7%"></qrcode> 

        

    <page_footer>
        <p> Pag - [[page_cu]]</p>
    </page_footer>

</page>
