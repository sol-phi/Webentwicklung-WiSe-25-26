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
                    <th class="text-nowrap" data-sortable="true">Aktionen</th>
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
                            <div class="d-inline-flex gap-2">
                                <a href="<?= base_url('public/spalten-erstellen/copy/' . $spalte['id'])?>">
                                    <i class="fa-solid fa-copy text-primary"></i>
                                </a>
                                <a href="<?= base_url('public/spalten-erstellen/update/' . $spalte['id'])?>">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>
                                <a href="<?= base_url('public/spalten-erstellen/delete/' . $spalte['id'])?>">
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
