<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4">
            Spalten
        </div>
        <div class="card-body">
            <!-- <a> funktioniert durch Bootstrap-Klassen wie ein Button, und href ist hier viel cleaner als bei echten <button>-->
            <!-- class: btn sind die abgerundeten Kanten, btn-primary die Farbe und mb-3 der Abstand zur Tabelle -->
            <a href="<?= base_url('public/spalten_erstellen') ?>" class="btn btn-primary mb-3">
                Erstellen
            </a>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr> <!-- Table Row -->
                        <th scope="col">ID</th> <!-- Table Head -->
                        <th scope="col">Board</th>
                        <th scope="col">SortID</th>
                        <th scope="col">Spalte</th>
                        <th scope="col">Spaltenbeschreibung</th>
                        <th scope="col">Bearbeiten</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Iteriert als eindimensionale Arrays über den einen zweidimensionalen Array -->
                    <?php if (!empty($spalten)): ?>
                        <?php foreach ($spalten as $board): ?>
                            <tr>
                                <td><?= esc($board['id']) ?></td>
                                <td><?= esc($board['board']) ?></td>
                                <td><?= esc($board['sortid']) ?></td>
                                <td><?= esc($board['spalte']) ?></td>
                                <td><?= esc($board['spaltenbeschreibung']) ?></td>
                                <td>
                                    <div class="ms-2 d-inline-flex gap-3">
                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                        <i class="fa-solid fa-trash text-primary"></i>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Keine Spalten gefunden.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
