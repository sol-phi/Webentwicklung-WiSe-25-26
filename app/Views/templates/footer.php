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
        <!-- padding_y-3 -->
        <footer class="bg-blue py-3 mt-4">
            <!-- Flex-Container, erstes Element links, und zweites Element rechts. Abstand automatisch zum Ausfüllen ermittelt-->
            <div class="container d-flex justify-content-between">
                <div>
                    <span class="text-white">©Web-Entwicklung Team 04</span>
                </div>
                <div class="d-flex gap-3">
                    <span class="text-white">Impressum</span>
                    <span class="text-white">Datenschutz</span>
                    <span class="text-white">Kontakt</span>
                </div>
            </div>
        </footer>
    </body>
</html>