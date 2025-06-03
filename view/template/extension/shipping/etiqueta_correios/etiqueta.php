<?php 





include '../../../../../../config.php';

$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);



$sql = "SELECT * FROM ".DB_PREFIX."order WHERE order_id = ".$_REQUEST['pedido'];

  $sql = mysqli_query($link, $sql);

  $pedido = mysqli_fetch_assoc($sql);

  $custom_field = json_decode($pedido['shipping_custom_field'], true);



  // altere as linhas 23 e 24 de acordo com os seus campos personalizados

  @$numero = $custom_field[3];

  @$complemento = $custom_field[4];



  $sql1 = "SELECT * FROM `".DB_PREFIX."setting` WHERE `key` LIKE 'config_address'";

  $sql1 = mysqli_query($link, $sql1);

  $loja = mysqli_fetch_assoc($sql1);

?>



<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Etiqueta Pedido #<?php echo $_REQUEST['pedido'] ?> </title></head>



    <style>

      * {

          color:#000000;

          font-family:Arial,sans-serif;

          font-size:12px;

          font-weight:normal;

      }   

      .config .title{

          font-weight: bold;

          text-align: center;

      }

      .config .barcode2D,

      #miscCanvas{

        display: none;

      }      

      #barcodeTarget,

      #canvasTarget{

        margin-top: 20px;

      }        

    </style>

    

    <script type="text/javascript" src="jquery-1.3.2.min.js"></script>

    <script type="text/javascript" src="jquery-barcode.js"></script>

    <script type="text/javascript">

    

    <?php $str = $pedido['shipping_postcode']; ?>

    

      function generateBarcode(){

        var value = "<?php echo substr($str, 0, 5).'-'. substr( $str, -3 );  ?>";

        var btype = "code128";

        var renderer = $("input[name=renderer]:checked").val();

        

        var quietZone = false;

        if ($("#quietzone").is(':checked') || $("#quietzone").attr('checked')){

          quietZone = true;

        }

    

        var settings = {

          output:renderer,

          bgColor: $("#bgColor").val(),

          color: $("#color").val(),

          barWidth: $("#barWidth").val(),

          barHeight: $("#barHeight").val(),

          moduleSize: $("#moduleSize").val(),

          posX: $("#posX").val(),

          posY: $("#posY").val(),

          addQuietZone: $("#quietZoneSize").val()

        };

        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){

          value = {code:value, rect: true};

        }

        if (renderer == 'canvas'){

          clearCanvas();

          $("#barcodeTarget").hide();

          $("#canvasTarget").show().barcode(value, btype, settings);

        } else {

          $("#canvasTarget").hide();

          $("#barcodeTarget").html("").show().barcode(value, btype, settings);

        }

      }

          

      function showConfig1D(){

        $('.config .barcode1D').show();

        $('.config .barcode2D').hide();

      }

      

      function showConfig2D(){

        $('.config .barcode1D').hide();

        $('.config .barcode2D').show();

      }

      

      function clearCanvas(){

        var canvas = $('#canvasTarget').get(0);

        var ctx = canvas.getContext('2d');

        ctx.lineWidth = 1;

        ctx.lineCap = 'butt';

        ctx.fillStyle = '#FFFFFF';

        ctx.strokeStyle  = '#000000';

        ctx.clearRect (0, 0, canvas.width, canvas.height);

        ctx.strokeRect (0, 0, canvas.width, canvas.height);

      }

      

      $(function(){

        $('input[name=btype]').click(function(){

          if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();

        });

        $('input[name=renderer]').click(function(){

          if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();

        });

        generateBarcode();

      });

  

    </script>

<body onLoad="self.print();" >    <!--  -->

<div style=" height:500px; width:350px; " > 

    <img src="bg_etiqueta.png">



    <div style="margin: -260px 0px 0px 25px; font-size:12px; height: 90px;">

        <?php echo utf8_encode($pedido['shipping_firstname'].' '.$pedido['shipping_lastname'] )?><br>

        <?php if($pedido['shipping_company']!=''){ echo utf8_encode($pedido['shipping_company']).'<br>'; } ?>

        <?php echo utf8_encode($pedido['shipping_address_1'].', '.$numero) ?><br>

        <?php if($complemento!=''){ echo utf8_encode($complemento).'<br>'; } ?>

        <?php echo utf8_encode($pedido['shipping_address_2']) ?><br>

        <?php echo utf8_encode($pedido['shipping_city'].' - '. $pedido['shipping_zone']) ?>

    </div>

    

    <div style="margin: 20px 0px 0px 20px; " id="barcodeTarget" class="barcodeTarget"></div>

    <canvas id="canvasTarget" width="150" height="190" ></canvas> 

    

    <div style="margin: 0px -150px 75px 25px; ">

    <b>Remetente</b>

    <br>

    

    <?php echo utf8_encode( nl2br($loja['value'])) ?>

    

    <br>

    

    </div>

 </div> 

  </body>

</html>