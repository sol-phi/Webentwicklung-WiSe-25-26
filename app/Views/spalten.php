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

                    <!-- Könnte zwar als HTML hardcoded werden, als PHP-Array ist die Tabelle jedoch flexibler -->
                    <?php $boards = array(
                            "1" => array("ID" => "1", "Board" => "Allgemeine Todos", "SortID" => "106",
                                    "Spalte" => "Zu besprechen", "Spaltenbeschreibung" => "Noch zu besprechende Todos"
                            ),
                            "2" => array(
                                    "ID" => "2", "Board" => "Dringende Aufgaben", "SortID" => "215",
                                    "Spalte" => "Sofort erledigen", "Spaltenbeschreibung" => "Tasks, die höchste Priorität haben"
                            )
                    );
                    ?>

                    <!-- Iteriert als eindimensionale Arrays über den einen zweidimensionalen Array -->
                    <?php foreach ($boards as $board): ?>
                        <tr> <!-- Table Row -->
                            <td><?=$board['ID']?></td> <!-- Table Data -->
                            <td><?=$board['Board']?></td>
                            <td><?=$board['SortID']?></td>
                            <td><?=$board['Spalte']?></td>
                            <td><?=$board['Spaltenbeschreibung']?></td>
                            <td> <!-- Die Icons können nicht gut im Array gespeichert werden. Da sie aber immer gleich sind, sind sie hier -->
                                <div class="ml-1 d-inline-flex gap-3 ms-2"> <!-- class für besseres Spacing -->
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                    <i class="fa-solid fa-trash text-primary"></i>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
