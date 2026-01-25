<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card blue-gradient-boards-card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            Personen
        </div>
        <div class="card-body">
            <div id="toolbar">
                <a href="<?= base_url('public/personen-erstellen/create') ?>" class="btn blue-gradient-buttons">
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
                    <th class="text-nowrap" data-sortable="true">Vorname</th>
                    <th class="text-nowrap" data-sortable="true">Name</th>
                    <th class="text-nowrap" data-sortable="true">E-Mail</th>
                    <!--Sollte man besser nicht anzeigen-->
                    <!--<th class="text-nowrap" data-sortable="true">Passwort</th>-->
                    <th class="text-nowrap" data-sortable="true">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($personen as $person): ?>
                    <tr>
                        <td><?= esc($person['id']) ?></td>
                        <td><?= esc($person['vorname']) ?></td>
                        <td><?= esc($person['name']) ?></td>
                        <td><?= esc($person['email']) ?></td>
                        <!--<td><?php /*= esc($person['passwort']) */?></td>-->
                        <td>
                            <div class="d-inline-flex gap-2">
                                <a href="<?= base_url('public/personen-erstellen/copy/' . $person['id'])?>">
                                    <i class="fa-solid fa-copy blue-gradient-icons"></i>
                                </a>
                                <a href="<?= base_url('public/personen-erstellen/update/' . $person['id'])?>">
                                    <i class="fa-solid fa-pen-to-square blue-gradient-icons"></i>
                                </a>
                                <a href="<?= base_url('public/personen-erstellen/delete/' . $person['id'])?>">
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