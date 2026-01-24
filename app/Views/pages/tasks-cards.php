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

        <!--Klassen, damit obere Elemente nicht mit scrollen.-->
        <div class="card-body pt-3 pb-0 px-0">

            <div class="px-3">
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
            </div>

            <!--Klassen sorgen dafür, dass Scrollbar an der äußersten Card hängt-->
            <!--Flexbox-Klassen für responsives Layout, sodass Spalten bei zu wenig Platz nach unten rutschen-->
            <div class="kanban-scroll overflow-x-auto mt-3 px-3">
                <div class="d-flex flex-nowrap gap-3 align-items-stretch mb-3">
                    <?php foreach ($spalten as $spalte): ?>
                        <!--Width ist sehr genau gewählt, sodass die 4. Spalte in der Desktop-Sicht gerade so weit reinclippt,
                        dass Benutzer verstehen, dass sie horizontal scrollen können, auch wenn die Scrollbar nicht direkt sichtbar ist-->
                        <div class="d-flex flex-column flex-shrink-0 gap-3" style="width: 405px;">
                            <!--Jede Spalte wird in einer vertikalen Card dargestellt-->
                            <div class="card h-100 w-100">

                                <div class="card-header">
                                    <div class="fs-5 fw-semibold"><?= esc($spalte['spalte']) ?></div>
                                    <div class="small"><?= esc($spalte['spaltenbeschreibung']) ?></div>
                                </div>

                                <!--d-flex flex-column, zusammen mit align-items-stretch außen sorgt dafür,
                                dass alle Spalten in der div nach unten auf Höhe der längsten Spalte gezogen werden-->
                                <div class="card-body d-flex flex-column gap-3 bg-light">
                                    <?php foreach ($tasks as $task): ?>
                                        <!--In tasks sind alle Tasks für das ausgewählte Board enthalten, daher müssen wir hier nochmal explizit nach Spalte filtern-->
                                        <?php if ($task['spaltenid'] == $spalte['id']): ?>

                                            <!--Jeder Task wird als kleine Card innerhalb der Spalte dargestellt-->
                                            <div class="card">
                                                <div class="card-header bg-light-subtle fw-semibold p-0 d-flex align-items-start justify-content-between overflow-hidden">
                                                    <?php foreach ($taskarten as $taskart): ?>
                                                        <?php if ($task['taskartenid'] == $taskart['id']): ?>
                                                            <div class="d-flex align-items-stretch text-break flex-grow-1">
                                                                <div class="flex-grow-1 bg-primary bg-opacity-50 py-1 px-2 d-flex align-items-center justify-content-center text-center position-relative">
                                                                    <div class="card bg-white text-dark small position-absolute start-0 ms-2">
                                                                        <div class="card-body px-1 py-0">
                                                                            #<?= str_pad(esc($task['id']), 3, '0', STR_PAD_LEFT) ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ps-5">
                                                                        <span><?= esc($task['tasks']) ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-center text-nowrap bg-primary bg-opacity-25 p-2">
                                                                    <div class="d-flex flex-column align-items-center">
                                                                        <i class="fa-solid <?= esc($taskart['taskartenicon']) ?>"></i>
                                                                        <small><?= esc($taskart['taskart']) ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php break;?>
                                                        <?php endif;?>
                                                    <?php endforeach;?>
                                                    <div class="d-inline-flex gap-2 p-2 ps-3">
                                                        <a href="<?= base_url('public/tasks-erstellen/cards/' . $selected_board['id'] . '/copy/' . $task['id'])?>">
                                                            <i class="fa-solid fa-copy text-primary"></i>
                                                        </a>
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
                                                            <?= esc((new DateTime($task['erstelldatum']))->format('d M Y')) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-1">
                                                            <i class="fa-solid fa-bell text-muted"></i>
                                                        </div>
                                                        <div class="col">
                                                            <?php if (empty($task['erinnerungsdatum']) || $task['erinnerungsdatum'] == '0000-00-00 00:00:00'): ?>
                                                                -
                                                            <?php else: ?>
                                                                <?= esc((new DateTime($task['erinnerungsdatum']))->format('d M Y H:i')) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <?php if (!empty($task['notizen'])): ?>
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            <i class="fa-solid fa-sticky-note text-muted"></i>
                                                            <span class="text-muted small">Notiz</span>
                                                        </div>
                                                        <div class="card bg-light">
                                                            <div class="card-body p-2">
                                                                <?= esc($task['notizen']) ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Pfeile zum Verschieben der Task -->
                                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                                        <?php
                                                        $current_index = array_search($spalte['id'], array_column($spalten, 'id'));
                                                        $prev_spalte = $current_index > 0 ? $spalten[$current_index - 1] : null;
                                                        $next_spalte = $current_index < count($spalten) - 1 ? $spalten[$current_index + 1] : null;
                                                        ?>

                                                        <?php if ($prev_spalte): ?>
                                                            <a href="<?= base_url('public/tasks/move/' . $task['id'] . '/' . $prev_spalte['id']) ?>"
                                                               class="text-secondary"
                                                               title="← <?= esc($prev_spalte['spalte']) ?>">
                                                                <i class="fa-solid fa-arrow-left"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted opacity-25"><i class="fa-solid fa-arrow-left"></i></span>
                                                        <?php endif; ?>

                                                        <small class="text-muted">Spalte verschieben</small>

                                                        <?php if ($next_spalte): ?>
                                                            <a href="<?= base_url('public/tasks/move/' . $task['id'] . '/' . $next_spalte['id']) ?>"
                                                               class="text-secondary"
                                                               title="→ <?= esc($next_spalte['spalte']) ?>">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted opacity-25"><i class="fa-solid fa-arrow-right"></i></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <!-- Button zum Erstellen einer neuen Task in dieser Spalte -->
                                    <a href="<?= base_url('public/tasks-erstellen/cards/' . $selected_board['id'] . '/create?spalte=' . $spalte['id']) ?>"
                                       class="btn btn-primary w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Neue Task
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>


                    <!--Hacky workaround für Scrollbar an äußerster Card. Damit wird ein weiteres, sehr enges "Spaltenelement" erzeugt, sodass gap-3 nach rechts greift-->
                    <div class="d-flex flex-column flex-shrink-0 gap-3" style="width: 0.001rem;"></div>

                </div>
            </div>

        </div>
    </div>
</div>




