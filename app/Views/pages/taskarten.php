<div class="container mt-4 mb-4">

    <?php
    // Zeige Flash-Messages (Bootstrap Alerts)
    if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif;
    if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card blue-gradient-boards-card">
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            Taskarten
        </div>
        <div class="card-body">
            <!-- Klasse mb-3 entfernt, um dem Layout von spalten.php zu entsprechen -->
            <div id="toolbar">
                <a href="<?= base_url('public/taskarten-erstellen/create') ?>" class="btn blue-gradient-buttons">
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
                    <th class="text-nowrap" data-sortable="true">Taskart</th>
                    <th class="text-nowrap" data-sortable="true">Icon</th>
                    <th class="text-nowrap">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($taskarten) && is_array($taskarten)): ?>
                    <?php foreach ($taskarten as $taskart): ?>
                        <tr>
                            <td><?= esc($taskart['id']) ?></td>
                            <td><?= esc($taskart['taskart']) ?></td>
                            <td>
                                <i class="fa-solid fa-fw text-muted <?= esc($taskart['taskartenicon']) ?>"></i>
                                <?= esc($taskart['taskartenicon']) ?>
                            </td>
                            <td>
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= base_url('public/taskarten-erstellen/copy/' . $taskart['id'])?>">
                                        <i class="fa-solid fa-copy blue-gradient-icons"></i>
                                    </a>
                                    <a href="<?= base_url('public/taskarten-erstellen/update/' . $taskart['id'])?>">
                                        <i class="fa-solid fa-pen-to-square blue-gradient-icons"></i>
                                    </a>
                                    <a href="<?= base_url('public/taskarten-erstellen/delete/' . $taskart['id'])?>">
                                        <i class="fa-solid fa-trash blue-gradient-icons"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>