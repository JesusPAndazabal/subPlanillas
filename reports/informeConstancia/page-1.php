<page>
    <page_header>
    <?php 
            $anioActual = date('Y');
            $mesActual = date('m');
            $diaActual = date('d');

            if($mesActual == 1){
                $mesActual = "Enero";
            }else if($mesActual == 2){
                $mesActual = "Febrero";
            }else if($mesActual == 3){
                $mesActual = "Marzo";
            }else if($mesActual == 4){
                $mesActual = "Abril";
            }else if($mesActual == 5){
                $mesActual = "Mayo";
            }else if($mesActual == 6){
                $mesActual = "Junio";
            }else if($mesActual == 7){
                $mesActual = "Julio";
            }else if($mesActual == 8){
                $mesActual = "Agosto";
            }else if($mesActual == 9){
                $mesActual = "Setiembre";
            }else if($mesActual == 10){
                $mesActual = "Octubre";
            }else if($mesActual == 11){
                $mesActual = "Noviembre";
            }else if($mesActual == 12){
                $mesActual = "Diciembre";
            }
            


    ?>
    <img class="img ml-13 mb-1" src="../dist/img/logougel.jpg" alt="">
        <h6> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GOBIERNO REGIONAL - ICA</h6>
        <h6> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DIRECCIÓN REGIONAL DE EDUCACIÓN</h6>
        <h6>UNIDAD DE GESTIÓN EDUCATIVA LOCAL - CHINCHA</h6>

        <h4 class="mt-9 tc">“Año del Fortalecimiento de la Soberanía Nacional”</h4>
        <h5 class="mt-4 mb-1 tr"> Chincha Alta ,  <?php  echo $diaActual?> de <?php  echo $mesActual?> del <?php  echo $anioActual?> </h5>

        <h4 class="tc mt-10">Constancia de Ingresos</h4>

        <p class="tl mt-5  bold">A quien corresponda</p>

        <p class="mt-10 tj lh">Por medio de la presente, yo <strong>Apolaya Nicanor</strong> en mi calidad de Tesorero hago 
        constar la siguiente información a petición del solicitante de esta carta, <strong><?php foreach ($datosObtenidos as $clave){echo "{$clave['empleado']}";}?></strong> 
        se desempeña con cargo de  <strong><?php foreach ($datosObtenidos as $clave){echo "{$clave['cargo']} ";}?></strong>, con código modular : <?php foreach ($datosObtenidos as $clave){

        $anio = $clave['anio'];
        if($anio  <= 2002){
            $codigoEmpleado = $clave['codigomodular'];
        }else if($anio < 2002){
            $codigoEmpleado = $clave['codigodni'];
        }

        echo "$codigoEmpleado";}?> 
        <?php foreach ($sumarIngresos as $clave){ $ingresos = $clave['ingreso'];}?>
  
        obteniendo de esta manera un ingreso total de 
        <?php $totalLiquido =  $ingresos  ;$format_number1 = number_format($totalLiquido,2);?><?php echo $format_number1 ?>  
        mensuales en la Institución <strong><?php foreach ($datosObtenidos as $clave){echo "{$clave['nombre']}  ";}?></strong></p>

        <p class="mt-5 tj lh">Sin más por el momento y quedando a sus órdenes para cualquier duda o aclaración, extiendo la presente a solicitud de la interesada a los doce días del mes de abril del año en curso.</p>
    
        <p class="mt-17 tc">__________________________________</p>
        <p class="tc">Firma del Administrador</p>
    
    </page_header>

   


    <page_footer>
        <p> Pag - [[page_cu]]</p>
    </page_footer>
</page>