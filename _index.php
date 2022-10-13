<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>A Basic HTML5 Template</title>
  <!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->
</head>
<body>
	<p>Insert URL</p>
  <input type="text" class="index-value" />
  <button class="upload">Index URL</button>
  
  <?php
    /* API URL */
  $url = 'https://indexing.googleapis.com/v3/urlNotifications:publish?key=AIzaSyBzfJFBPcrFAHCLKJc8HeZT8w4hkalVlw0';
     
  /* Init cURL resource */
  $ch = curl_init($url);
     
  /* Array Parameter Data */
  $data = ['url'=>'https://stupefied-blackburn.45-82-188-188.plesk.page', 'type'=>'URL_UPDATED'];
     
  /* pass encoded JSON string to the POST fields */
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     
  /* set the content type json */
  $headers = [
  'Content-Type : application/json',
  'Authorization : Bearer ya29.a0AVA9y1tx7K1CYMfKWtPAIFd88EoVhV1m6Y44tmkzROqWR23ZhNwMFUrPO-IAGQDKdjJUUKx2KKbS9dQQ7DrVe85_LU8EltrVNJ4Ny3-wYAFRUfFROFoT60c3t1synTyhntfCkYn5r5CY6oyZYCv83GVOTWTEaCgYKATASAQASFQE65dr86NxUixXDXed_RFQ4_tX0Gg0163'];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     
  /* set return type json */
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
  /* execute request */
  $result = curl_exec($ch);
  
  echo $result;
  
  /* close cURL resource */
  curl_close($ch);
  
  ?>

</body>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</html>