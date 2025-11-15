<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <link href="<?= base_url('public/assets/css/tasks.css') ?>" rel="stylesheet">
    </head>
    <body>
        <!-- navbar-expand für Responsivität -->
        <nav class="navbar navbar-expand bg-blue">
            <!-- container zentriert die Elemente -->
            <div class="container">
                <!-- Wenn das Bild nicht lädt, ist der alt-Text weiß -->
                <img src="<?= base_url('public/assets/img/WE-Logo.svg') ?>" alt="WE-Logo" class="text-white" height="50">
                <div class="container spacing">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- Auf der Seite "Tasks" sind wir gerade -->
                            <a class="nav-link active text-white" aria-current="page" href="#">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Boards</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Spalten</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>
</html>