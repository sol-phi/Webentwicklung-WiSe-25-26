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
    <div class="card blue-gradient-boards-card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 d-flex justify-content-between align-items-center fw-semibold blue-gradient-boards-header"
             >
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <span><?= esc($selected_board['board']) ?></span>

            <div class="d-flex justify-content-between align-items-center">
                <div class="dropdown">
                    <button class="btn blue-gradient-buttons dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Boards
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <!--Generiert die Dropdown-Einträge dynamisch basierend auf den Boards in der Datenbank-->
                        <?php foreach ($boards as $board): ?>
                            <li>
                                <!--URL wird generiert basierend auf der Board-ID, jeder einzelne Board ist seine eigene Unterseite-->
                                <a class="dropdown-item" href="<?= base_url('public/dashboard/' . $board['id']) ?>">
                                    <?= esc($board['board']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!--Klassen, damit obere Elemente nicht mit scrollen.-->
        <div class="card-body pt-3 pb-0 px-0">

            <div class="px-3">
                <div id="toolbar" class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <a href="<?= base_url('public/tasks-erstellen/dashboard/' . $selected_board['id'] . '/create')?>" class="btn blue-gradient-buttons">
                            <i class="fa-solid fa-plus"></i> Neu
                        </a>
                    </div>
                    <!--Funktioniert nicht, sollte aber auf jeder Seite drauf sein. Vielleicht für später?-->
                    <div class="input-group ms-3" style="max-width: 250px;">
                        <input id="taskSearch" type="search" class="form-control blue-gradient-fields-search" placeholder="Suchen...">
                        <button class="btn blue-gradient-buttons-search" type="button" id="button-search" disabled>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!--Sorgt dafür, dass die Scrollbar unten nicht aus den Ecken rausclippt-->
            <div class="boards-scroll-wrapper">
                <!--Klassen sorgen dafür, dass Scrollbar an der äußersten Card hängt-->
                <!--Flexbox-Klassen für responsives Layout, sodass Spalten bei zu wenig Platz nach unten rutschen-->
                <div class="kanban-scroll overflow-x-auto mt-3 px-3">
                    <!--Wenn keine Spalten vorhanden sind, Warnung ausgeben, sodass es nicht leer wirkt.-->
                    <?php if (empty($spalten)): ?>
                        <div class="alert alert-danger text-center">Keine Spalten vorhanden...</div>
                    <?php else: ?>

                        <div class="d-flex flex-nowrap gap-3 align-items-stretch mb-3 columns-container">
                            <?php foreach ($spalten as $spalte): ?>
                                <!--Width ist sehr genau gewählt, sodass die 5. Spalte in der Desktop-Sicht gerade so weit reinclippt,
                                dass Benutzer verstehen, dass sie horizontal scrollen können, auch wenn die Scrollbar nicht direkt sichtbar ist-->
                                <div class="d-flex flex-column flex-shrink-0 gap-3 draggable-column"  style="width: 300px;"
                                     data-col-id="<?= $spalte['id'] ?>">
                                    <!--Jede Spalte wird in einer vertikalen Card dargestellt-->
                                    <div class="card h-100 w-100 blue-gradient-spalten-card">

                                        <div class="card-header blue-gradient-spalten-header column-handle position-relative">
                                            <i class="fa-solid fa-grip blue-gradient-drag-icon"
                                               style="position: absolute; top: 0px; left: 50%; transform: translateX(-50%);"></i>
                                            <div class="fs-5 fw-semibold mt-2 spalten-title" style="display: inline-block; margin-top: 10px;">
                                                <?= esc($spalte['spalte']) ?>
                                            </div>
                                        </div>
                                        <div class="card-header blue-gradient-spalten-beschreibung">
                                            <div class="small"><?= esc($spalte['spaltenbeschreibung']) ?></div>
                                        </div>

                                        <!--d-flex flex-column, zusammen mit align-items-stretch außen sorgt dafür,
                                        dass alle Spalten in der div nach unten auf Höhe der längsten Spalte gezogen werden
                                        draggable-container ist der Rahmen, in dem Elemente hin-und-her gezogen werden können, also die Spalte.
                                        data-spalten-id ist für das Updaten der Spalte innerhalb der Task-Daten nach einem erfolgreichem Drop zuständig.-->
                                        <div class="card-body d-flex flex-column gap-3 draggable-container" data-spalten-id="<?= $spalte['id'] ?>">
                                            <?php foreach ($tasks as $task): ?>
                                                <!--In tasks sind alle Tasks für das ausgewählte Board enthalten, daher müssen wir hier nochmal explizit nach Spalte filtern-->
                                                <?php if ($task['spaltenid'] == $spalte['id']): ?>

                                                    <!--Jeder Task wird als kleine Card innerhalb der Spalte dargestellt-->
                                                    <!--draggable ist der Teil, der beim Drag mitkommt. data-task-id zur Identifikation des gezogenen ELements.-->
                                                    <div class="card blue-gradient-tasks-card draggable" data-task-id="<?= $task['id'] ?>">

                                                        <!--grabbable ist der Teil, über den man für einen Drag hovern muss.-->
                                                        <div class="card-header fw-semibold blue-gradient-tasks-header position-relative task-handle">
                                                            <!--Hack, um das Icon oben zentriert anzuzeigen-->
                                                            <i class="fa-solid fa-grip blue-gradient-drag-icon"
                                                               style="position: absolute; top: 0px; left: 50%; transform: translateX(-50%);"></i>

                                                            <div class="task-title" style="display: inline-block; margin-top: 10px;">
                                                                <?= esc($task['tasks']) ?>
                                                            </div>
                                                        </div>

                                                        <div class="card-header p-0 d-flex align-items-start justify-content-between overflow-hidden">
                                                            <?php foreach ($taskarten as $taskart): ?>
                                                                <?php if ($task['taskartenid'] == $taskart['id']): ?>
                                                                    <div class="d-flex align-items-stretch text-break flex-grow-1 blue-gradient-taskarten">
                                                                        <div class="flex-grow-1 py-2 ps-3 d-flex align-items-center justify-content-between text-start position-relative">
                                                                            <div class="d-flex align-items-baseline gap-2 text-break">
                                                                                <div class="tasks-align-icons">
                                                                                    <i class="fa-solid text-muted <?= esc($taskart['taskartenicon']) ?>"></i>
                                                                                </div>

                                                                                <div class="flex-grow-1">
                                                                                    <?= esc($taskart['taskart']) ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php break;?>
                                                                <?php endif;?>
                                                            <?php endforeach;?>
                                                            <div class="d-flex align-items-center justify-content-center text-nowrap py-2 px-3 blue-gradient-aktionen">
                                                                <div class="d-inline-flex gap-2">
                                                                    <a href="<?= base_url('public/tasks-erstellen/dashboard/' . $selected_board['id'] . '/copy/' . $task['id'])?>">
                                                                        <i class="fa-solid fa-copy blue-gradient-icons"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('public/tasks-erstellen/dashboard/' . $selected_board['id'] . '/update/' . $task['id'])?>">
                                                                        <i class="fa-solid fa-pen-to-square blue-gradient-icons"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('public/tasks-erstellen/dashboard/' . $selected_board['id'] . '/delete/' . $task['id'])?>">
                                                                        <i class="fa-solid fa-trash blue-gradient-icons"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--style ist dazu da, da ich ansonsten pb-2.5 gebraucht hätte, damit es gut aussieht-->
                                                        <div class="card-body pt-2 ps-3 pe-3 blue-gradient-tasks-body" style="padding-bottom: 0.75rem;">
                                                            <!--Ineffizient, aber bietet somit auch Support für mehrere Personen für einen Task-->
                                                            <?php foreach ($personen as $person): ?>
                                                                <?php if ($person['id'] == $task['personenid']): ?>
                                                                    <div class="d-flex align-items-start gap-2 mb-2">
                                                                        <div class="tasks-align-icons">
                                                                            <i class="fa-solid fa-user text-muted"></i>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                            <div class="d-flex align-items-start gap-2 <?= ($task['erinnerung'] == 1) ? "mb-2" : ""?> ">
                                                                <div class="tasks-align-icons">
                                                                    <i class="fa-solid fa-calendar text-muted"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <!--DateTime wird nur der Formatierung wegen on the fly erzeugt-->
                                                                    <?= esc((new DateTime($task['erstelldatum']))->format('d M Y')) ?>
                                                                </div>
                                                            </div>
                                                            <!--Nur wenn der Benutzer haben möchte, dass man erinnert wird, wird das entsprechende Datum angezeigt-->
                                                            <?php if ($task['erinnerung'] == 1): ?>
                                                                <div class="d-flex align-items-start gap-2">
                                                                    <div class="tasks-align-icons">
                                                                        <i class="fa-solid fa-bell text-muted"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <!--DateTime wird nur der Formatierung wegen on the fly erzeugt-->
                                                                        <?= esc((new DateTime($task['erinnerungsdatum']))->format('d M Y H:i')) ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <!--Falls leer, werden beide Footer komplett ausgeblendet-->
                                                        <?php if (!empty($task['notizen'])): ?>
                                                            <div class="card-footer d-flex align-items-start gap-2 blue-gradient-notizen">
                                                                <div class="tasks-align-icons">
                                                                    <i class="fa-solid fa-sticky-note text-muted"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    Notizen:
                                                                </div>
                                                            </div>
                                                            <!--style für bottom da, der Rest ist schon by default-->
                                                            <div class="card-footer blue-gradient-tasks-footer" style="padding-bottom: 0.75rem;">
                                                                <!--Verhindert komische Zeilenumbrüche-->
                                                                <div class="task-note"><?= esc($task['notizen']) ?></div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<!--Lädt die notwendige Dragula (Drag-and-Drop Funktionalität) Bibliothek, -->
<!--und übergibt die BaseURL (muss in PHP sein), um mit Ajax nachträglich das Verschieben von Tasks an den Server zu schicken und die DB zu updaten-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>
<script>
    // Quirk von Auto-Routing. update-position == postUpdatePosition
    updateTaskPositionUrl = "<?= base_url('public/tasks/update-position') ?>"
    // URL für Spalten
    updateColumnPositionUrl = "<?= base_url('public/spalten/update-position') ?>";
</script>
<script src="<?= base_url('public/assets/js/drag-and-drop.js') ?>"></script>
<script src="<?= base_url('public/assets/js/search.js') ?>"></script>



