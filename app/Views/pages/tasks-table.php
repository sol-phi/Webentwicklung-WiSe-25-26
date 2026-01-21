<div class="container mt-4 mb-4">

    <?php
    $success = session()->getFlashdata('success');
    $error = session()->getFlashdata('error');
    $errors = session('errors');
    ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= esc($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 d-flex justify-content-between align-items-center fw-semibold">
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <span>Tasks</span>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Ansicht
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!--Cards sendet zu der Cards-Ansicht auf dem ersten verfügbaren Board.-->
                    <li><a class="dropdown-item" href="<?= base_url('public/tasks/cards/' . $boards[0]['id']) ?>">Cards</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('public/tasks/table') ?>">Tabelle</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <div id="toolbar">
                <a href="<?= base_url('public/tasks-erstellen/table/create') ?>" class="btn btn-primary">
                    Neu
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
                        <th class="text-nowrap" data-sortable="true">Personen-ID</th>
                        <th class="text-nowrap" data-sortable="true">Taskarten-ID</th>
                        <th class="text-nowrap" data-sortable="true">Spalten-ID</th>
                        <th class="text-nowrap" data-sortable="true">Sort-ID</th>
                        <th class="text-nowrap" data-sortable="true">Tasks</th>
                        <th class="text-nowrap" data-sortable="true">Erstelldatum</th>
                        <th class="text-nowrap" data-sortable="true">Erinnerungsdatum</th>
                        <th class="text-nowrap" data-sortable="true">Erinnerung</th>
                        <th class="text-nowrap" data-sortable="true">Notizen</th>
                        <th class="text-nowrap" data-sortable="true">Erledigt</th>
                        <th class="text-nowrap" data-sortable="true">Gelöscht</th>
                        <th class="text-nowrap" data-sortable="true">Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= esc($task['id']) ?></td>
                            <td><?= esc($task['personenid']) ?></td>
                            <td><?= esc($task['taskartenid']) ?></td>
                            <td><?= esc($task['spaltenid']) ?></td>
                            <td><?= esc($task['sortid']) ?></td>
                            <td><?= esc($task['tasks']) ?></td>
                            <td><?= esc($task['erstelldatum']) ?></td>
                            <td><?= esc($task['erinnerungsdatum']) ?></td>
                            <td><?= esc($task['erinnerung']) ?></td>
                            <td><?= esc($task['notizen']) ?></td>
                            <td><?= esc($task['erledigt']) ?></td>
                            <td><?= esc($task['geloescht']) ?></td>
                            <td>
                                <div class="d-inline-flex gap-3">
                                    <a href="<?= base_url('public/tasks-erstellen/table/update/' . $task['id'])?>">
                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                    </a>

                                    <a href="<?= base_url('public/tasks-erstellen/table/delete/' . $task['id'])?>">
                                        <i class="fa-solid fa-trash text-primary"></i>
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