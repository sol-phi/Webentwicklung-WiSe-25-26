<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4">
            Personen
        </div>
        <div class="card-body">
            <div id="toolbar">
                <a href="<?= base_url('public/personen-erstellen') ?>" class="btn btn-primary disabled">
                    Erstellen
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
                    <th class="text-nowrap" data-sortable="true">Vorname</th>
                    <th class="text-nowrap" data-sortable="true">Name</th>
                    <th class="text-nowrap" data-sortable="true">E-Mail</th>
                    <th class="text-nowrap" data-sortable="true">Passwort</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($personen as $person): ?>
                    <tr>
                        <td><?= esc($person['id']) ?></td>
                        <td><?= esc($person['vorname']) ?></td>
                        <td><?= esc($person['name']) ?></td>
                        <td><?= esc($person['email']) ?></td>
                        <td><?= esc($person['passwort']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>