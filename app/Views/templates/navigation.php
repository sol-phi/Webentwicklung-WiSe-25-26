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
                    $segment1 = $uri->getSegment(1); // = 'tasks', 'boards' oder 'spalten'
                    $segment2 = $uri->getSegment(2); // = Wenn 'tasks-erstellen', dann sind es entweder 'dashboard' oder 'tasks'
                    ?>

                    <li class="nav-item">
                        <!-- Überprüft die URL, und markiert das Element fett, auf dessen Seite wir gerade sind -->
                        <a class="nav-link text-white <?= ($segment1 === 'dashboard' || ($segment1 === 'tasks-erstellen' && $segment2 === 'dashboard') || $segment1 === '') ? 'active' : '' ?>"
                           href="<?= base_url('public/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <!-- Überprüft die URL, und markiert das Element fett, auf dessen Seite wir gerade sind -->
                        <a class="nav-link text-white <?= ($segment1 === 'tasks' || ($segment1 === 'tasks-erstellen' && $segment2 === 'tasks')) ? 'active' : '' ?>"
                           href="<?= base_url('public/tasks') ?>">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($segment1 === 'spalten' || $segment1 === 'spalten-erstellen') ? 'active' : '' ?>"
                           href="<?= base_url('public/spalten') ?>">Spalten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($segment1 === 'boards' || $segment1 === 'boards-erstellen') ? 'active' : '' ?>"
                           href="<?= base_url('public/boards') ?>">Boards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($segment1 === 'taskarten' || $segment1 === 'taskarten-erstellen') ? 'active' : '' ?>"
                           href="<?= base_url('public/taskarten') ?>">Taskarten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($segment1 === 'personen' || $segment1 === 'personen-erstellen') ? 'active' : '' ?>"
                           href="<?= base_url('public/personen') ?>">Personen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>