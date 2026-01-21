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
        <div class="card-header fs-4 fw-semibold">
            Spalten
        </div>
        <div class="card-body">
            <!-- <a> funktioniert durch Bootstrap-Klassen wie ein Button, und href ist hier viel cleaner als bei echten <button>-->
            <!-- class: btn sind die abgerundeten Kanten, btn-primary die Farbe und mb-3 der Abstand zur Tabelle -->
            <!-- id="toolbar" dient dazu, den Knopf zu der Zeile über der Tabelle hinzuzufügen, zu den anderen Elementen wie das Suchfeld -->
            <div id="toolbar">
                <a href="<?= base_url('public/spalten-erstellen/create') ?>" class="btn btn-primary">
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
                    <th class="text-nowrap" data-sortable="true">Sort-ID</th>
                    <th class="text-nowrap" data-sortable="true">Spalte</th>
                    <th class="text-nowrap" data-sortable="true">Spaltenbeschreibung</th>
                    <th class="text-nowrap" data-sortable="true">Bearbeiten</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($spalten as $spalte): ?>
                    <tr>
                        <td><?= esc($spalte['id']) ?></td>
                        <td><?= esc($spalte['board']) ?></td>
                        <td><?= esc($spalte['sortid']) ?></td>
                        <td><?= esc($spalte['spalte']) ?></td>
                        <td><?= esc($spalte['spaltenbeschreibung']) ?></td>
                        <td>
                            <div class="ml-1 d-inline-flex gap-3 ms-2"> <!-- class für besseres Spacing -->
                                <a href="<?= base_url('public/spalten-erstellen/update/'. $spalte['id'])?>">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>
                                <a href="<?= base_url('public/spalten-erstellen/delete/'. $spalte['id'])?>">
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
