<?php
$sz = sizeof($_POST);
$json = file_get_contents("people.json"); 
$arr = json_decode($json , true);
$arrk = array_keys( $arr );
$arrv = array_values( $arr );
$myfile = "messages.txt";
$fmsg = file($myfile);
$szmsg = sizeof( $fmsg );

if( $sz > 0 ){
    $question = $_POST["question"];
    $en_name = $_POST["person"];
    $fa_name = $arr[$en_name];     
    $mi = $question . $en_name ;
    $va = crc32( md5( $mi , true ) );
    $ind = $va % $szmsg;
    $msg = $fmsg[ $ind ]; 
}
else{
 $question = '...';
 $msg = 'سوال خود را بپرس!';
 $ind = array_rand( $arrk );
 $en_name = $arrk[$ind]; 
 $fa_name = $arrv[$ind];
}
?>
<!DOCTYPE html>
<html lang="en/fa">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">    
      <?php 
       if( $sz > 0 ){  
        echo "<span id=\"label\">پرسش:</span>";
         echo "<span id=\"question\"> $question </span>" ; 
       }
      ?>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <?php 
             if( $sz == 0 )echo "<input type=\"text\" name=\"question\" maxlength=\"150\" placeholder=\"...\"/>" ;
             else echo "<input type=\"text\" name=\"question\" maxlength=\"150\" value=\"$question\" />" ; 
            ?> 
             را از
            <select name="person">
                <?php
                 echo "<option value=\"$en_name\"> $fa_name </option>";                    
                 foreach ( $arrk as $ename ) {
                   if( $ename != $en_name ){   
                     $fname = $arr[$ename] ;
                     echo "<option value=\"$ename\"> $fname </option>";                    
                   }
                 }   
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>