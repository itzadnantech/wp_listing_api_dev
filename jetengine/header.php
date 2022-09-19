<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php $viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' ); ?>
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>"> 
	<link rel="profile" href="https://gmpg.org/xfn/11"> 

	<!-- title code  -->
	<?php
	///filter url
	$uri = $_SERVER['REQUEST_URI'];
	$uri = str_replace("/", "", $uri);
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// $actual_link = null;
	 
	
	if (str_contains($uri, 'news-release-detail')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://megenergy.mediaroom.com/api/newsfeed_releases/get.php?format=json&id=' . $_GET['id']);
		$data = curl_exec($ch);
		curl_close($ch); 
		$array = explode(',', $data);  
		$title = str_replace('"headline":',' ',$array[4]);
		$title = str_replace('"',' ',$title); 

		 
			$subheadline = str_replace('"subheadline":',' ',$array[5]);
			$subheadline = str_replace('"',' ',$subheadline);
			

			if(empty($subheadline))
			{
				$subheadline = " ";
			}


	
		
		 
	}
	?>
	<title><?php echo trim($title) ?></title> 
	<!-- oopen graph -->
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?php echo trim($title) ?>" />
	<meta property="og:description" content="<?php echo trim($subheadline) ?>" />
	<meta property="og:url" content="<?php echo $actual_link ?>" />
	<meta property="og:site_name" content="MEG Energy" />
	<meta property="article:modified_time" content="<?php echo date('Y-m-d') ?>" />
	<meta property="og:image" content="https://meg.e-cubed-wp.com/wp-content/uploads/2022/03/placeholder-23-1024x683.png" />
	
	<!-- twitter card -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo trim($title) ?>" />
	<meta name="twitter:description" content="<?php echo trim($subheadline); ?>" />
	<meta name="twitter:image" content="https://meg.e-cubed-wp.com/wp-content/uploads/2022/03/placeholder-23.png" />
	 
	
	<?php wp_head(); ?> 
	

</head>
<body <?php body_class(); ?>>

<?php
hello_elementor_body_open();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-header' );
	} else {
		get_template_part( 'template-parts/header' );
	}
}
