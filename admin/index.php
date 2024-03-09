<?php
        $cssStack = [];
        $jsStack = [];  
        $selectedContent = isset($_GET['content']) ? $_GET['content'] : 'index';
        $contentPath = "$selectedContent";
?>
<!-- HEAD -->
<?php include("layouts/header.php"); 

    

?>
</head>
<body>
    <!-- Left Panel -->

    <!-- SIDEBAR -->
    <?php include("layouts/sidebar.php"); ?>

    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->


        <!-- NAV -->
        <?php include("layouts/navigation.php"); ?>


        <!-- /#header -->
        <!-- Content -->

        <?php 
        if (file_exists($contentPath)) {
            include($contentPath);
        } else {
            include("pages/Statistical.php");
        }
        ?>
        


        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->

        <!-- FOOTER -->
        <?php include("layouts/footer.php"); 

        // CSS
        foreach ($cssStack as $item) {
            if (isset($item['link'])) {
                echo "<link href='{$item['link']}' rel='stylesheet'>";
            } elseif (isset($item['style'])) {
                echo "<style>{$item['style']}</style>";
            }
        }

        //Script
        foreach ($jsStack as $item) {
            if (isset($item['link'])) {
                echo "<script src='{$item['link']}'></script>";
            } elseif (isset($item['script'])) {
                echo "<script type='text/javascript'>{$item['script']}</script>";
            }elseif (isset($item['scriptjQ'])) {
                echo "<script>{$item['scriptjQ']}</script>";
            }
        }
        ?>

        

</body>

</html>