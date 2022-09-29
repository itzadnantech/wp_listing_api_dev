     <!-- Global script -->
     <!-- Global script -->
     <!-- Global script -->
     <!-- Global script -->
     <!-- Global script -->
     <?php
        ///filter url
        $uri = $_SERVER['REQUEST_URI'];
        $uri = str_replace("/", "", $uri);


        ?>


     <!-- code news listing page -->
     <!-- code news listing page -->
     <!-- code news listing page -->
     <!-- code news listing page -->
     <!-- code news listing page -->
     <!-- code news listing page -->
     <!-- code news listing page -->

     <?php

        if (str_contains($uri, 'press-releases')) {


            function lastday($dateValue)
            {

                $time = strtotime($dateValue);
                $year = date("Y", $time);
                $currentY = date('Y');
                $lastyearE = mktime(0, 0, 0, 12, 31,  $year);
                return  date('Y-m-d', $lastyearE);
            }

            ///check filter
            if (isset($_GET['date'])) {
                $year = $_GET['date'];
                $start_date = $_GET['date'] . '-01-01';
                $end_date = date("Y-m-d", strtotime("Last day of December", strtotime($start_date)));
                $url = 'https://arcresources.mediaroom.com/api/newsfeed_releases/list.php?format=json&start_date=' . $start_date . '&end_date=' . $end_date;
                // echo $url;
                // die;
            } else {
                $year = date('Y');
                $start_date = date('Y') . '-01-01';
                $end_date = date("Y-m-d", strtotime("Last day of December", strtotime($start_date)));
                $url = 'https://arcresources.mediaroom.com/api/newsfeed_releases/list.php?format=json&start_date=' . $start_date . '&end_date=' . $end_date;
            }




            ///get listing manually  
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',

            ));

            $response = curl_exec($curl);

            // $response = json_decode($response);

            curl_close($curl);
        }

        ?>

     <!-- ///convert list into javascript -->
     <?php if (str_contains($uri, 'press-releases')) { ?>
         <style>
             .active {
                 background-color: white !important;
                 color: #016D9B !important;
                 border: 1px solid #016D9B !important;
             }
         </style>
         <script>
             function date_format(date) {
                 let date_arr = date.split(" ");
                 let new_date = date_arr[2] + " " + date_arr[1] + " " + date_arr[3];
                 return new_date;

             }

             function checkUrl() {
                 let url = window.location.href;
                 if (window.location.href.indexOf("news-releases") > -1) {
                     if (window.location.href.indexOf("date") < 1) {
                         //    $('#2022').addClass('year-active');
                         var element = document.getElementById('2022');
                         element.classList.add("year-active");
                     } else {
                         let year = `<?php echo $_GET['date'] ?>`;
                         //    $('#' + year).addClass('year-active');
                         var element = document.getElementById(year);
                         element.classList.add("year-active");

                     }
                 }

             }

             //    $(function() {
             //        checkUrl();
             //    })

             window.onload = function() {
                 checkUrl();
             };
         </script>
         <script>
             var list = `<?php echo $response; ?>`;
             list = JSON.parse(list);
             ///list count
             count = list.returned_count;
             let headline = null;
             let releaseDate = null;
             let news_id = null;
             let container = "";
             let row = "";
             //    var href = $('.news-readmore .elementor-button').attr('href');
             let href = document.getElementById('news-readmore').children[0].children[0].children[0].getAttribute('href');
             console.log(href);

             //    $('#news-listing').css('display', 'none');
             //    $('#no_record').css('display', 'none');
             document.getElementById('news-listing').style.display = "none";
             //    document.getElementById('no_record').style.display = "none";


             let year = `<?php echo $year ?>`;
             var element = document.getElementById(year);
             element.classList.add("active");
             //    $('#' + year).addClass('active');

             ///loop for each item
             if (count > 0) {
                 for (let i = 0; i < count; i++) {

                     news_id = list.release[i]['id'];
                     headline = list.release[i]['headline'];
                     //    releaseDate = date_format(list.release[i]['releaseDate']);
                     let date = list.release[i]['releaseDate'];
                     let date_arr = date.split(" ");
                     releaseDate = date_arr[2] + " " + date_arr[1] + " " + date_arr[3];


                     ///js
                     var section = document.getElementById('news-listing').innerHTML;
                     document.getElementById('news-date').children[0].children[0].textContent = releaseDate;
                     document.getElementById('news-headline').children[0].children[0].textContent = headline;
                     document.getElementById('news-readmore').children[0].children[0].children[0].setAttribute('href', href + news_id);

                     row = document.getElementById('news-listing').innerHTML;
                     container = container + row;




                     ///Jquery
                     //    $('#news-listing div:first .news-date div').children().text(releaseDate)
                     //    $('#news-listing div:first .news-headline div').children().text(headline)
                     //    $('.news-readmore .elementor-button').attr('href', href + news_id)
                     //    row = $('#news-listing').html();
                     //    container = container + row;
                 }

                 //    $('#news-listing').css('display', 'block');
                 document.getElementById('news-listing').style.display = "block";
                 document.getElementById('news-listing').innerHTML = container;
             } else {
                 //    $('#no_record').css('display', 'block');
                 document.getElementById('no_record').style.display = "block";
             }
             // console.log(row);
         </script>






     <?php } ?>

     <!-- code news listing end -->
     <!-- code news listing end -->
     <!-- code news listing end -->
     <!-- code news listing end -->
     <!-- code news listing end -->
     <!-- code news listing end -->








     <!-- code news detail -->
     <!-- code news detail -->
     <!-- code news detail -->

     <?php
        if (str_contains($uri, 'press-release-detail')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, 'https://arcresources.mediaroom.com/api/newsfeed_releases/get.php?format=json&id=' . $_GET['id']);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = str_replace("\\", "\\\\", $result);
        }
        ?>
     <?php if (str_contains($uri, 'press-release-detail')) { ?>
         <script>
             var txt = `<?php echo $result; ?>`;
             if (window.location.href.indexOf("id") > -1) {
                 var obj = JSON.parse(txt);

                 if (obj.headline != null && obj.headline != "") {
                     document.getElementById('headline').children[0].children[0].textContent = obj.headline;
                 } else {
                     document.getElementById('headline').style.display = "none";
                 }
                 if (obj.releaseDate != null && obj.releaseDate != "") {
                     document.getElementById('releaseDate').children[0].children[0].textContent = obj.releaseDate;
                 } else {
                     document.getElementById('releaseDate').style.display = "none";
                 }
                 if (obj.subheadline != null && obj.subheadline != "") {
                     document.getElementById('subheadline').children[0].children[0].textContent = obj.subheadline;
                 } else {
                     document.getElementById('subheadline').style.display = "none";
                 }
                 if (obj.image_url != null && obj.image_url != "") {
                     document.getElementById('image_url').children[0].children[0].src = obj.image_url;
                 } else {
                     document.getElementById('image_url').style.display = "none";
                 }

                 if (obj.body != null && obj.body != "") {
                     document.getElementById('body').children[0].children[0].innerHTML = obj.body;
                 } else {
                     document.getElementById('body').style.display = "none";
                 }
                 if (obj.location != null && obj.location != "") {
                     document.getElementById('location').children[0].children[0].textContent = obj.location;
                 } else {
                     document.getElementById('location').children[0].children[0].style.display = "none";
                 }
                 if (obj.summary != null && obj.summary != "") {
                     document.getElementById('summary').children[0].children[0].innerHTML = obj.summary;
                 } else {
                     document.getElementById('summary').style.display = "none";
                 }




             }
         </script>
     <?php } ?>




     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->
     <!------------------------ New Listing for home page ------------------->

     <?php
        if (empty($uri) || str_contains($uri, 'newsroom')) {
            ///get listing manually  
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://arcresources.mediaroom.com/api/newsfeed_releases/list.php?format=json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',

            ));

            $response = curl_exec($curl);
            // $response = json_decode($response);

            curl_close($curl);
        }
        ?>

     <!-- ///convert list into javascript -->
     <?php if (empty($uri)) { ?>

         <script>
             function date_format(date) {
                 let date_arr = date.split(" ");
                 let new_date = date_arr[2] + " " + date_arr[1] + " " + date_arr[3];
                 return new_date;

             }

             var list = `<?php echo $response; ?>`;
             list = JSON.parse(list);
             ///list count
             count = list.returned_count;
             let headline = null;
             let news_id = null;
             // let link = "/press-releases/press-release-detail/?id="; 
             ///loop for each item
             if (count > 0) {
                 for (let i = 1; i < 4; i++) {
                     let link = $('#news-' + i).attr('data-tp-sc-link');
                     news_id = list.release[i - 1]['id'];
                     headline = list.release[i - 1]['headline'];
                     releaseDate = date_format(list.release[i - 1]['releaseDate']);
                     $('#news-' + i).children().children().text(headline)
                     $('#news-' + i).attr('data-tp-sc-link', link + news_id);
                     $('#date-' + i).children().children().text(releaseDate);

                 }
             }
         </script>

     <?php } ?>

     <?php if (str_contains($uri, 'newsroom')) { ?>
         <script>
             function date_format(date) {
                 let date_arr = date.split(" ");
                 let new_date = date_arr[2] + " " + date_arr[1] + " " + date_arr[3];
                 return new_date;

             }


             var list = `<?php echo $response; ?>`;

             list = JSON.parse(list);
             console.log(list);
             ///list count
             count = list.returned_count;
             let headline = null;
             let news_id = null;
             let releaseDate = null;
             // let link = "/press-releases/press-release-detail/?id="; 
             ///loop for each item
             if (count > 0) {
                 for (let i = 1; i < 5; i++) {
                     let link = $('#news-' + i).attr('data-tp-sc-link');
                     news_id = list.release[i - 1]['id'];
                     headline = list.release[i - 1]['headline'];
                     releaseDate = date_format(list.release[i - 1]['releaseDate']);
                     $('#date-' + i).children().children().text(releaseDate)
                     $('#news-' + i).children().children().text(headline)
                     $('#news-' + i).attr('data-tp-sc-link', link + news_id);

                 }
             }
         </script>
     <?php } ?>

     <!------------------------ New Listing for home end ------------------->
     <!------------------------ New Listing for home end ------------------->
     <!------------------------ New Listing for home end ------------------->
     <!------------------------ New Listing for home end ------------------->
     <!------------------------ New Listing for home end ------------------->

     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->
     <!------------------------ New Listing for investor page ------------------->

     <?php
        if (empty($uri) || str_contains($uri, 'investor')) {
            ///get listing manually  
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://arcresources.mediaroom.com/api/newsfeed_releases/list.php?format=json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',

            ));

            $response = curl_exec($curl);
            // $response = json_decode($response);

            curl_close($curl);
        }
        ?>

     <!-- ///convert list into javascript -->
     <?php if (str_contains($uri, 'investor')) { ?>
         <script>
             function date_format(date) {
                 let date_arr = date.split(" ");
                 let new_date = date_arr[2] + " " + date_arr[1] + " " + date_arr[3];
                 return new_date;

             }


             var list = `<?php echo $response; ?>`;
             list = JSON.parse(list);
             console.log(list);
             ///list count
             count = list.returned_count;
             let headline = null;
             let news_id = null;
             let releaseDate = null;
             // let link = "/press-releases/press-release-detail/?id="; 
             ///loop for each item
             if (count > 0) {
                 for (let i = 1; i < 5; i++) {
                     let link = $('#news-' + i).attr('data-tp-sc-link');
                     news_id = list.release[i - 1]['id'];
                     headline = list.release[i - 1]['headline'];
                     releaseDate = date_format(list.release[i - 1]['releaseDate']);
                     $('#date-' + i).children().children().text(releaseDate)
                     $('#news-' + i).children().children().text(headline)
                     $('#news-' + i).attr('data-tp-sc-link', link + news_id);

                 }
             }
         </script>
     <?php } ?>

     <!------------------------ New Listing for investor end ------------------->
     <!------------------------ New Listing for investor end ------------------->
     <!------------------------ New Listing for investor end ------------------->
     <!------------------------ New Listing for investor end ------------------->
     <!------------------------ New Listing for investor end ------------------->






     <!------------------------ Jobs Listing Page ------------------->
     <?php
        if (str_contains($uri, 'career-opportunities')) {
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
            $access_token = $response->token_type . ' ' . $response->access_token;

            ///Get Opportunities
            $curl = curl_init();
            // $date = date('Y-m-d', strtotime('-1 day'));
            $date = date('Y-m-d');
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://service3.ultipro.ca/talent/recruiting/v2/ARC5000ARRS/api/opportunities?updated_after=' . $date,
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
        } ?>


     <!-- ///convert list into javascript -->
     <?php if (str_contains($uri, 'career-opportunities')) { ?>

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
             document.getElementById('jobs-listing').style.display = "none";
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
                     //    job_detail_link = list[i]['links'][0]['href'];
                     job_detail_link = "https://arcresourcestg.wpengine.com/career-detail/?job_id=" + job_id


                     var section = document.getElementById('jobs-listing').innerHTML;
                     document.getElementById('jobs-title').children[0].children[0].children[0].textContent = title;
                     document.getElementById('jobs-title').children[0].children[0].children[0].setAttribute('href', job_detail_link);
                     document.getElementById('jobs-title').children[0].children[0].children[0].setAttribute('target', '_blank');
                     document.getElementById('jobs-description').children[0].children[0].textContent = description;

                     row = document.getElementById('jobs-listing').innerHTML;
                     container = container + row;
                     // console.log('<!------------Row-------------->');
                     // console.log(row);


                 }
                 // console.log('<!------------Container-------------->');
                 // console.log(container);
                 // $('#jobs-listing').css('display', 'block');

                 document.getElementById('jobs-listing').style.display = "block";
                 document.getElementById('jobs-listing').innerHTML = container;

             } else {
                 $('#no_record').css('display', 'block');
             }
         </script>

     <?php } ?>


     <!------------------------ Jobs Detail Page ------------------->
     <?php
        if (str_contains($uri, 'career-detail')) {
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
            $access_token = $response->token_type . ' ' . $response->access_token;

            $job_id = $_GET['job_id'];

            ///Get Opportunities
            $curl = curl_init();
            $date = date('Y-m-d', strtotime('-1 day'));
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://service3.ultipro.ca/talent/recruiting/v2/ARC5000ARRS/api/opportunities/' . $job_id,
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
        } ?>


     <!-- ///convert list into javascript -->
     <?php if (str_contains($uri, 'career-detail')) { ?>

         <script>
             var list = `<?php echo $result; ?>`;
             list = JSON.parse(list);
             


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
             
          
            
             job_id = list['id'];
             created_at = list['created_at'];
             updated_at = list['updated_at'];
             closed_date = list['closed_date'];
             title = list['title']['en_us'];
             description = list['description']['detailed']['external']['en_us'];
             
            
              
             document.getElementById('title').children[0].children[0].textContent = title;
           
            
            //  document.getElementById('title').style.display = "block";
             document.getElementById('description').children[0].children[0].children[0].innerHTML = description;
         </script>

     <?php } ?>