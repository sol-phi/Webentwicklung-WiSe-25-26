<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            Boards
        </div>
        <div class="card-body">
            <div id="toolbar">
                <a href="<?= base_url('public/boards-erstellen') ?>" class="btn btn-primary disabled">
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
                    <th class="text-nowrap" data-sortable="true">Board</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($boards as $board): ?>
                    <tr>
                        <td><?= esc($board['id']) ?></td>
                        <td><?= esc($board['board']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
