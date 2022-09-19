<!-- title code  -->
<?php
///filter url
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace("/", "", $uri);
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $actual_link = null;


if (str_contains($uri, 'press-release-detail')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://arcresources.mediaroom.com/api/newsfeed_releases/get.php?format=json&id=' . $_GET['id']);
    $data = curl_exec($ch);
    curl_close($ch);
    $array = explode(',', $data);
    $title = str_replace('"headline":', ' ', $array[5]);
    $title = str_replace('"', ' ', $title);


    $subheadline = str_replace('"subheadline":', ' ', $array[6]);
    $subheadline = str_replace('"', ' ', $subheadline);


    if (empty($subheadline)) {
        $subheadline = " ";
    }
}
?>
<?php if (str_contains($uri, 'press-release-detail')) { ?>
    <title><?php echo trim($title) ?></title>
    <!-- oopen graph -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo trim($title) ?>" />
    <meta property="og:description" content="<?php echo trim($subheadline) ?>" />
    <meta property="og:url" content="<?php echo $actual_link ?>" />
    <meta property="og:site_name" content="Arc Resources" />
    <meta property="article:modified_time" content="<?php echo date('Y-m-d') ?>" />

    <!-- twitter card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo trim($title) ?>" />
    <meta name="twitter:description" content="<?php echo trim($subheadline); ?>" />
<?php } else { ?>
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Home - Arc Resources" />
    <meta property="og:description" content="ARC acclaimed as global leader in responsible development Today, ARC is proud to hold the largest responsibly produced and certified production base in Canada. Learn about our EO100™ certification and how we’re producing sustainable energy for the world. Electrification drives leading GHG performance  Learn about the positive impact electrification has made in our northeast BC [&hellip;]" />
    <meta property="og:url" content="<?php echo $actual_link ?>" />
    <meta property="og:site_name" content="Arc Resources" />
    <meta property="article:modified_time" content="<?php echo date('Y-m-d') ?>" />
    <meta property="og:image" content="https://arc.e-cubed-wp.com/wp-content/uploads/2022/06/image-20.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:label1" content="Est. reading time" />
    <meta name="twitter:data1" content="5 minutes" />

<?php } ?>