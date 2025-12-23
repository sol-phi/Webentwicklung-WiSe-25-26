<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4">
            Tasks
        </div>
        <div class="card-body">
            <div id="toolbar">
                <a href="<?= base_url('public/tasks/crud/0/0') ?>" class="btn btn-primary">Neu</a>
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
                    <th class="text-nowrap" data-sortable="true">Bearbeiten</th>
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
                            <div class="ml-1 d-inline-flex gap-3 ms-2">
                                <a href="<?= base_url('public/tasks/crud/' . esc($task['id']) . '/1') ?>" title="Bearbeiten" class="text-decoration-none">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>

                                <a href="<?= base_url('public/tasks/crud/' . esc($task['id']) . '/2') ?>" title="Löschen" class="text-decoration-none">
                                    <i class="fa-solid fa-trash text-danger"></i>
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