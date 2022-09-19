<?php

/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('footer')) {
	if (did_action('elementor/loaded') && hello_header_footer_experiment_active()) {
		get_template_part('template-parts/dynamic-footer');
	} else {
		get_template_part('template-parts/footer');
	}
}
?>





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

if (str_contains($uri, 'news-listing')) {


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
<?php if (str_contains($uri, 'news-listing')) { ?>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
	<script src='https://arc.e-cubed-wp.com/wp-includes/js/jquery/jquery.min.js?ver=3.6.0'></script>
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
			var element = document.getElementById("#2022");
			if (window.location.href.indexOf("news-releases") > -1) {
				if (window.location.href.indexOf("date") < 1) {
					// $('#2022').addClass('year-active');
					var element = document.getElementById("#2022");
					element.classList.add("year-active");
				} else {
					let year = `<?php echo $_GET['date'] ?>`;
					// $('#' + year).addClass('year-active');
					var element = document.getElementById("#" + year);
					element.classList.add("year-active");
				}
			}

		}

		window.onload = function() {
			checkUrl();
		};

		// $(function() {
		// 	checkUrl();
		// })
	</script>
	<script>
		var list = `<?php echo $response; ?>`;
		list = JSON.parse(list);

		console.log(list);



		///list count
		count = list.returned_count;
		let headline = null;
		let releaseDate = null;
		let news_id = null;
		let container = "";
		let row = "";
		// var href = $('.news-readmore .elementor-button').attr('href');
		var element = document.querySelector('.news-readmore .elementor-button');
		let href = element.getAttribute("href");
		console.log(href);
		//	console.log(href);
		document.getElementById("news-listing").style.display = "none";
		document.getElementById("no_record").style.display = "none";
		// $('#news-listing').css('display', 'none');
		// $('#no_record').css('display', 'none');
		let year = `<?php echo $year ?>`;
		// var element = document.getElementById("#" + year);
		// element.classList.add("year-active");
		// $('#' + year).addClass('active');

		///loop for each item
		if (count > 0) {
			for (let i = 0; i < count; i++) {

				news_id = list.release[i]['id'];
				headline = list.release[i]['headline'];
				releaseDate = date_format(list.release[i]['releaseDate']);
				document.getElementById('news-listing').querySelector('div:first .news-date div').children[0].textContent = releaseDate;
				document.getElementById('news-listing').querySelector('div:first .news-headline div').children[0].textContent = headline;
		 

				// $('#news-listing div:first .news-date div').children().text(releaseDate)
				// $('#news-listing div:first .news-headline div').children().text(headline)



				//	$('#news-listing div:first .news-readmore div').children().text(news_id)
				document.getElementById('news-listing').querySelector('div:first .news-date div').setAttribute('href',href + news_id);
				// $('.news-readmore .elementor-button').attr('href', href + news_id)
				// row = $('#news-listing').html();
				row = document.getElementById('news-listing');
				container = container + row; 
			}
			console.log('<!------------Container-------------->');
			console.log(container);
			// $('#news-listing').css('display', 'block');
			document.getElementById("news-listing").style.display = "block";

			document.getElementById('news-listing').innerHTML = container;
		} else {
			// $('#no_record').css('display', 'block');
			document.getElementById("no_record").style.display = "none";

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
if (str_contains($uri, 'news-detail')) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'https://arcresources.mediaroom.com/api/newsfeed_releases/get.php?format=json&id=' . $_GET['id']);
	$result = curl_exec($ch);
	curl_close($ch);
	$result = str_replace("\\", "\\\\", $result);
}
?>
<?php if (str_contains($uri, 'news-detail')) { ?>
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


<?php wp_footer(); ?>

</body>

</html>