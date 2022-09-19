<?php


///Get Access Token
$curl = curl_init(); 
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://login.ultipro.ca/t/ARC5000ARRS/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=arc5000candidateimport&client_secret=APIyNl4uwWt1w2FUtnv6uMdwJDcQejU5uIdSseEe3uCrB819HhsLUxckZ8yFiil4Bdt8MlKr17_WF5r_0NfL_tg',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/x-www-form-urlencoded', 
  ),
));

$response = curl_exec($curl); 
curl_close($curl);
$response = json_decode($response); 
$access_token = $response->token_type.' '.$response->access_token; 
// echo '<pre>';
// print_r($access_token);
// echo '</pre>';
// die;

// $access_token = 'Bearer eyJraWQiOiJyc2ExIiwiYWxnIjoiUlMyNTYifQ.eyJhdWQiOiJhcmM1MDAwY2FuZGlkYXRlaW1wb3J0IiwiaXNzIjoiaHR0cHM6XC9cL2xvZ2luLnVsdGlwcm8uY2FcLyIsImV4cCI6MTY2MzQ4MTQwMCwiaWF0IjoxNjYzNDc3ODAwLCJ0YSI6ImFyYzUwMDBhcnJzIiwianRpIjoiYTFkMzgzOTMtMDdhYi00NDE2LTg3NWMtOTJhNWNkMTI1NzUxIn0.GBRnwbsghagLTDb3RsvzxQ4X1tZ0GNdU2jSB6KgiRXZx38b0ySetp61iyVL-P-A5mInlSKJSpqo9mRAMjMNZcemHyagaw2WFSxhCSqONxuKp5yue43sj1yygGbbcCg5HRxW1wPmBplz3HNm9neujXbAbr7y3cq4J16YTKZbK3SOiWuBALA3ZHiVCsvD2lk3Pkk7uoOtoPOIkya12E3ElSBzNVfLiOiMEItGsMPSuj9pNZDEActTlAikymbwobJxl5CtQfKixG2_REV1keYSgbx_vOp_5lVnyzHWwjgmxEzyS4R-yJepU8hpsVHVyRtZexO04PheChn1eGh8MGEYS7A';



///Get Opportunities
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://service3.ultipro.ca/talent/recruiting/v2/ARC5000ARRS/api/opportunities',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER =>  array(
    "Authorization: $access_token"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$result = str_replace("\\", "\\\\", $response);
echo '<pre>';
print_r($result);
echo '</pre>';
die;
 

?>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script>
  var list = `<?php echo $result; ?>`;
  list = JSON.parse(list);
  // console.log(list);



  ///list count
  count = 8;
  let job_id = null;
  let title = null;
  let description = null;
  let job_detail_link = null;
  let created_at = null;
  let updated_at = null;
  let closed_date = null;  
  let container = "";
  let row = "";
  // $('#jobs-listing').css('display', 'none');
  // $('#no_record').css('display', 'none');







  ///loop for each item
  if (count > 0) {
    for (let i = 0; i < count; i++) { 
      job_id = list[i]['id'];
      created_at = list[i]['created_at'];
      updated_at = list[i]['updated_at'];
      closed_date = list[i]['closed_date'];
      title = list[i]['title']['en_us'];
      description = list[i]['description']['brief']['external']['en_us'];
      job_detail_link = list[i]['links'][0]['href'];



      $('#jobs-listing div:first .jobs-title div').children().text(title)
      $('#jobs-listing div:first .news-description div').children().text(description)

      row = $('#jobs-listing').html();
      container = container + row;
      // console.log(row);


    }
    // console.log('<!------------Container-------------->');
    // console.log(container);
    $('#jobs-listing').css('display', 'block'); 
    document.getElementById('jobs-listing').innerHTML = container;

  } else {
    $('#no_record').css('display', 'block');
  }
</script>