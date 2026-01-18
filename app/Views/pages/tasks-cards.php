<div class="container mt-4 mb-4">

    <?php
    // Zeige Flash-Messages (Bootstrap Alerts) als Bestätigungsmeldung, wenn von einem erfolgreichen Submit von der Erstellen View kommend
    if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif;
    if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 d-flex justify-content-between align-items-center fw-semibold">
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <span>Tasks - <?= esc($selected_board['board']) ?></span>

            <div class="d-flex justify-content-between align-items-center">
                <div class="dropdown me-2">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Boards
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <!--Generiert die Dropdown-Einträge dynamisch basierend auf den Boards in der Datenbank-->
                        <?php foreach ($boards as $board): ?>
                            <li>
                                <!--URL wird generiert basierend auf der Board-ID, jeder einzelne Board ist seine eigene Unterseite-->
                                <a class="dropdown-item" href="<?= base_url('public/tasks/cards/' . $board['id']) ?>">
                                    <?= esc($board['board']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!--Kleines Extra, um zur alten Tabellenansicht wechseln zu können-->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Ansicht
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('public/tasks/cards/'  . $selected_board['id']) ?>">Cards</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('public/tasks/table') ?>">Tabelle</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!--Flexbox-Klassen für responsives Layout, sodass Spalten bei zu wenig Platz nach unten rutschen-->
        <div class="card-body">

            <div id="toolbar" class="d-flex justify-content-between align-items-center">
                <a href="<?= base_url('public/tasks-erstellen/cards/' . $selected_board['id'] . '/create')?>" class="btn btn-primary">
                    Neu
                </a>
                <!--Funktioniert nicht, sollte aber auf jeder Seite drauf sein. Vielleicht für später?-->
                <div class="input-group ms-3" style="max-width: 250px;">
                    <input id="taskSearch" type="search" class="form-control" placeholder="Suchen... (WIP)">
                    <button class="btn btn-outline-primary" type="button" id="button-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-3">
                <!--Jede Spalte wird in einer vertikalen Card dargestellt-->
                <?php foreach ($spalten as $spalte): ?>
                    <!--Min- und Max-Width verhindern gequetschte oder gedehnte Spalten. flex-box und card müssen separate divs sein-->
                    <div class="flex-grow-1" style="min-width: 200px; max-width: 300px;">
                        <div class="card">

                            <div class="card-header">
                                <div class="fs-5 fw-semibold"><?= esc($spalte['spalte']) ?></div>
                                <div class="small"><?= esc($spalte['spaltenbeschreibung']) ?></div>
                            </div>

                            <div class="card-body">
                                <?php foreach ($tasks as $task): ?>
                                    <!--In tasks sind alle Tasks für das ausgewählte Board enthalten, daher müssen wir hier nochmal explizit nach Spalte filtern-->
                                    <?php if ($task['spaltenid'] == $spalte['id']): ?>

                                        <!--Jeder Task wird als kleine Card innerhalb der Spalte dargestellt-->
                                        <div class="card mb-3">

                                            <div class="card-header bg-light-subtle fw-semibold d-flex align-items-center justify-content-between">
                                                <span><?= esc($task['tasks']) ?></span>
                                                <div class="d-inline-flex gap-3">
                                                    <a href="<?= base_url('public/tasks-erstellen/cards/' . $selected_board['id'] . '/update/' . $task['id'])?>">
                                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                                    </a>
                                                    <a href="<?= base_url('public/tasks-erstellen/cards/' . $selected_board['id'] . '/delete/' . $task['id'])?>">
                                                        <i class="fa-solid fa-trash text-primary"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <!--Folgende row/col Struktur sorgt für eine saubere Ausrichtung der Icons und Texte-->
                                            <div class="card-body">
                                                <!--Ineffizient, aber bietet somit auch Support für mehrere Personen für einen Task-->
                                                <?php foreach ($personen as $person): ?>
                                                    <?php if ($person['id'] == $task['personenid']): ?>
                                                        <div class="row mb-2">
                                                            <div class="col-1">
                                                                <i class="fa-solid fa-user text-muted"></i>
                                                            </div>
                                                            <div class="col">
                                                                <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div class="row mb-2">
                                                    <div class="col-1">
                                                        <i class="fa-solid fa-calendar text-muted"></i>
                                                    </div>
                                                    <div class="col">
                                                        <!--DateTime wird nur der Formatierung wegen on the fly erzeugt-->
                                                        <?= esc((new DateTime($task['erstelldatum']))->format('d M Y')) ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-1">
                                                        <i class="fa-solid fa-bell text-muted"></i>
                                                    </div>
                                                    <div class="col">
                                                        <!--Leere Werte werden in Erinnerungsdatum als '0000-00-00 00:00:00' in der DB gespeichert,
                                                        daher müssen wir danach testen.-->
                                                        <?php if (empty($task['erinnerungsdatum']) || $task['erinnerungsdatum'] == '0000-00-00 00:00:00'): ?>
                                                            -
                                                        <?php else: ?> <!--DateTime wird nur der Formatierung wegen on the fly erzeugt-->
                                                            <?= esc((new DateTime($task['erinnerungsdatum']))->format('d M Y H:i')) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-1">
                                                        <i class="fa-solid fa-sticky-note text-muted"></i>
                                                    </div>
                                                    <div class="col">
                                                        <?php if (empty($task['notizen'])): ?>
                                                            -
                                                        <?php else: ?>
                                                            <?= esc($task['notizen']) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>