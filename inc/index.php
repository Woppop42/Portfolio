<?php
    include("headFront.php");
    ?>
<title>SITE PROCEDURAL PHP</title>
<?php
include("headerFront.php");
?>
</head>
<body>

<div class="container">
    <div class="row mt-5">
        <?php if(isset($_SESSION["message"])){
            echo '<div class="alert alert-succes" role="alert">' . $_SESSION["message"] . '</div>';
            unset($_SESSION["message"]);
        }
        ?>
    </div>
</div>

</main>
    <?php
    include("footerFront.php");
    ?>
    <footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
            crossorigin="anonymous"></script>
    </footer>
</body>    