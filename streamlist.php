<?php
session_start();
if(!isset($_SESSION['USERNAME'])){
    header("Location: index.php");
    exit;
}
include 'header.php';
$lang = "en";

?>
<script type="text/javascript">
</script>
</head>

<body id="page-top" class="index">


<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <a class="navbar-brand" href="">Live Streaming</a>
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
<br><br><br><br>
<!-- Portfolio Grid Section -->
<div class="language-header">
    <div class="language-link">
        <a class="language-link-item" href="streamlist.php?lang=en" <?php if($lang == 'en'){?> style="color:#ff9900;" <?php } ?>>English</a> |
        <a class="language-link-item" href="streamlistjp.php?lang=jp"  <?php if($lang == 'jp'){?> style="color:#ff9900;" <?php } ?>>日本語</a>
    </div>
</div>
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Live streaming list</h2>
                <hr class="star-primary">
            </div>
        </div>


        <div class="row">
            <?php
            $json = file_get_contents('http://153.126.152.115:5080/api/v1/applications/live/streams?accessToken=webhawksit123');
            //$json = file_get_contents('http://123.200.14.11:5080/api/v1/applications/live/streams?accessToken=webhawksit123');
            $array = json_decode($json);
            $urlPoster=array();
            foreach ($array->data as $value) {
                ?>
                <div class="col-sm-4 portfolio-item">
                    <div class="caption">
                        <div class="caption-content">
                        </div>
                    </div>
                    <a href="view.php?name=<?php echo $value?>&lang=<?php echo $lang?>">
                        <img src="img/tumb.png" alt="video">
                        <h2 class="size"><?php echo  $value ?></h2>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
<?php include 'footer.php';?>

</body>

</html>
