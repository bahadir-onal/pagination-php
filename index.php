<?php
$db = new PDO("mysql:host=localhost;dbname=denemedb;charset=utf8","root","123456789");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SAYFALAMA SİSTEMİ ÖRNEK</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <script>
        $(document).ready(function(e) {

            $("#sayi").on('change',function(e) {

                var gelendeger=$("#sayi option:selected").val();

                $.get("cook.php?tercih=belirle",{"limit":gelendeger},function() {

                    window.location.reload();

                });

            });

        });

    </script>


</head>
<body>
<?php

$cek=$db->prepare("SELECT COUNT(*) AS toplam FROM yazilar");
$cek->execute();
$urunlerson=$cek->fetch(PDO::FETCH_ASSOC);

if (@!isset($_COOKIE['gosterlimit'])) {
    $gosterilecekadet=5;
} else {

    $gosterilecekadet=@$_COOKIE['gosterlimit'];

}



$toplamicerik=$urunlerson["toplam"];
$toplamsayfa=ceil($toplamicerik / $gosterilecekadet);

$sayfa= isset($_GET["hareket"]) ? (int) $_GET["hareket"] : 1;

if($sayfa<1) $sayfa=1;

if ($sayfa > $toplamsayfa)   $sayfa = $toplamsayfa;

$limit = ($sayfa - 1) * $gosterilecekadet;


$cek2=$db->prepare("SELECT * FROM yazilar LIMIT $limit,$gosterilecekadet");
$cek2->execute();



?>




<div class="container">
		<div class="row">
                    <div class="col-md-12" id="yinele">
                    
                    <table class="table table-bordered mt-2 text-center ">
                    <tbody>
                     <tr>
                    <td  class="text-left bg-light">
                    
                    <select id="sayi" class="form-control">
                        <?php
                        $sayilar=array(5,10,15,20);

                        foreach ($sayilar as $deger) {

                            if ($deger==$_COOKIE['gosterlimit']) {

                                echo "<option value=".$deger." selected>$deger</option>";

                            } else {

                                echo "<option value=".$deger.">$deger</option>";

                            }


                        }
                        ?>

                    </select>
                    
                    </td>
                     <td  class="text-left bg-light">
                    <div class="alert alert-info col-md-3 float right">Toplam Veri Sayısı : <?php echo $urunlerson['toplam'] ?> </div>
                   
                   </td>
                    </tr>
                    
                    <tr>
                    <th style="width:100px;" >Konu no</th>
                    <th >Konu İçerik</th>
                    </tr>
                    </tbody>
                    <tbody>
                    <?php

                    while ($aktar=$cek2->fetch(PDO::FETCH_ASSOC)) {

                        echo '<tr>
                        <td>'.$aktar["id"].'</td>
                        <td>'.$aktar["icerik"].'</td>
                        </tr> ';

                    }
                    ?>
                    <tr>
                    <td colspan="2"  class="text-center bg-light" >
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mx-auto">

                            <?php

                            for ($i=1; $i<=$toplamsayfa; $i++) {

                                echo "<li class='page-item'>
                                        <a class='page-link' href='?hareket=$i'>$i</a>
                                      </li>";
                            }

                            ?>

                        </ul>
                    </nav>
                    
                    
                     <!-- sayfalama buraya gelecek -->
                    
                    
                    </td>
                    
                    
                    </tr>
                   
                    
                    
                    </tbody>
                    
                    
                    
                    
                    </table>
                    
                    
                    
                    </div>
        
        
        </div>
	


</div>





</body>
</html>