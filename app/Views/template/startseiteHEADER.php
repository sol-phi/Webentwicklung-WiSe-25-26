<!DOCTYPE html>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite!</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://unpkg.com/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url('assets/css/styleAufgabe1.css')?>" rel="stylesheet" />
</head>

<body>
    <nav class="navbar main-nav bg-blue">
        <div class="container">

            <img src="<?=base_url('assets/img/WE-Logo.svg')?>" alt="WE Logo" height="40" class="me-2">

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Boards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Spalten</a>
                </li>
            </ul>
        </div>


    </nav>

    <script src="https://unpkg.com/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>