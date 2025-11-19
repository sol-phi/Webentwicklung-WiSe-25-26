<body>
    <!-- navbar-expand für Responsivität -->
    <nav class="navbar navbar-expand bg-blue">
        <!-- container zentriert die Elemente -->
        <div class="container">
            <!-- Wenn das Bild nicht lädt, ist der alt-Text weiß -->
            <img src="<?= base_url('public/assets/img/WE-Logo.svg') ?>" alt="WE-Logo" class="text-white" height="50">
            <div class="container spacing">
                <ul class="navbar-nav">

                    <?php // $uri schnappt sich die bestehende URL, und $segment holt sich nur das letzte, hinterste Schlagwort der URL
                    $uri = service('request')->getUri();
                    $segment = $uri->getSegment(1); // = 'tasks', 'boards' oder 'spalten'
                    ?>

                    <li class="nav-item">
                        <!-- Überprüft die URL, und markiert das Element fett, auf dessen Seite wir gerade sind -->
                        <a class="nav-link text-white <?= ($segment === 'tasks' || $segment === '') ? 'active' : '' ?>"
                           href="<?= base_url('public') ?>">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= $segment === 'boards' ? 'active' : '' ?>"
                           href="<?= base_url('public/boards') ?>">Boards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($segment === 'spalten' || $segment === 'spalten_erstellen') ? 'active' : '' ?>"
                           href="<?= base_url('public/spalten') ?>">Spalten</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>