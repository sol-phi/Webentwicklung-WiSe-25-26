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
        <div class="card-header fs-4 d-flex justify-content-between align-items-center fw-semibold blue-gradient-boards-header">
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <span>Tasks</span>
        </div>

        <div class="card-body">

            <div id="toolbar">
                <a href="<?= base_url('public/tasks-erstellen/tasks/create') ?>" class="btn blue-gradient-buttons">
                    <i class="fa-solid fa-plus"></i> Neu
                </a>
            </div>

            <table class="table table-responsive table-bordered table-striped table-hover d-table"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-toggle="table"
                   data-search="true"
                   data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th class="text-nowrap" data-sortable="true">ID</th>
                        <th class="text-nowrap" data-sortable="true">Task</th>
                        <th class="text-nowrap" data-sortable="true">Spalte</th>
                        <th class="text-nowrap" data-sortable="true">Board</th>
                        <th class="text-nowrap" data-sortable="true">Taskart</th>
                        <th class="text-nowrap" data-sortable="true">Person</th>
                        <th class="text-nowrap" data-sortable="true">Erstelldatum</th>
                        <th class="text-nowrap" data-sortable="true">Erinnerungsdatum</th>
                        <th class="text-nowrap" data-sortable="true">Notizen</th>
                        <th class="text-nowrap" data-sortable="true">Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= esc($task['id']) ?></td>
                            <td>
                                <!--Verhindert, dass extrem lange Strings das Layout zerstören-->
                                <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 200px;"
                                     title="<?= esc($task['tasks']) ?>">
                                    <?= esc($task['tasks']) ?>
                                </div>
                            </td>
                            <?php foreach ($spalten as $spalte): ?>
                                <?php if ($task['spaltenid'] == $spalte['id']): ?>
                                    <td>
                                        <!--Verhindert, dass extrem lange Strings das Layout zerstören-->
                                        <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 200px;"
                                             title="<?= esc($spalte['spalte']) ?>">
                                            <?= esc($spalte['spalte']) ?>
                                        </div>
                                    </td>
                                    <?php foreach ($boards as $board): ?>
                                        <?php if ($spalte['boardsid'] == $board['id']): ?>
                                            <td>
                                                <!--Verhindert, dass extrem lange Strings das Layout zerstören-->
                                                <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 200px;"
                                                     title="<?= esc($board['board']) ?>">
                                                    <?= esc($board['board']) ?>
                                                </div>
                                            </td>
                                            <?php break;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endforeach;?>
                            <?php foreach ($taskarten as $taskart): ?>
                                <!--Hier durchlaufen wir alle Taskarten, um den passenden Taskart-Namen für den dazugehörigen Task zu laden.-->
                                <!--Für weitere Einträge analog-->
                                <?php if ($task['taskartenid'] == $taskart['id']): ?>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="tasks-align-icons">
                                                <i class="fa-solid fa-fw text-muted <?= esc($taskart['taskartenicon']) ?>"></i>
                                            </div>
                                            <!--Verhindert, dass extrem lange Strings das Layout zerstören-->
                                            <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 125px;"
                                                 title="<?= esc($taskart['taskart']) ?>">
                                                <?= esc($taskart['taskart']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <?php break;?>
                                <?php endif;?>
                            <?php endforeach;?>
                            <?php foreach ($personen as $person): ?>
                                <?php if ($task['personenid'] == $person['id']): ?>
                                    <td>
                                        <!--Verhindert, dass extrem lange Strings das Layout zerstören-->
                                        <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 225px;"
                                             title="<?= esc($person['vorname']) ?> <?= esc($person['name']) ?>">
                                            <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                        </div>
                                    </td>
                                    <?php break;?>
                                <?php endif;?>
                            <?php endforeach;?>

                            <td><?= esc((new DateTime($task['erstelldatum']))->format('d M Y')) ?></td>

                            <!--Typsicherheit des Erinnerungsdatums durch Default in der View task-erstellen garantiert.
                            Wenn Erinnerung == 0, dann hat es den Default-Wert, sollte aber nicht angezeigt werden.-->
                            <td><?php if ($task['erinnerung'] == 1): ?>
                                    <?= esc((new DateTime($task['erinnerungsdatum']))->format('d M Y H:i')) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td> <!--Sorgt dafür, dass Notizen abgeschnitten und in title komplett angezeigt werden, wenn sie zu lang sind-->
                                <?php if (!empty($task['notizen'])): ?>
                                    <div class="flex-grow-1 text-truncate" style="min-width: 0; max-width: 300px;"
                                         title="<?= esc($task['notizen']) ?>">
                                        <?= esc($task['notizen']) ?>
                                    </div>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= base_url('public/tasks-erstellen/tasks/copy/' . $task['id'])?>">
                                        <i class="fa-solid fa-copy blue-gradient-icons"></i>
                                    </a>
                                    <a href="<?= base_url('public/tasks-erstellen/tasks/update/' . $task['id'])?>">
                                        <i class="fa-solid fa-pen-to-square blue-gradient-icons"></i>
                                    </a>
                                    <a href="<?= base_url('public/tasks-erstellen/tasks/delete/' . $task['id'])?>">
                                        <i class="fa-solid fa-trash blue-gradient-icons"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>