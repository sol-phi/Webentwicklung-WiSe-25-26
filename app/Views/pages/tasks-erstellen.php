<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <!--Bestimmt Titel des Formulars je nach Herkunft und Aktion-->
            <?php if (isset($cards)): ?>
                <?php if ($todo == "create"): ?>
                    <span>Task erstellen - <?= esc($selected_board['board']) ?></span>
                <?php elseif ($todo == "update"): ?>
                    <span>Task bearbeiten - <?= esc($selected_board['board']) ?></span>
                <?php elseif ($todo == "delete"): ?>
                    <span>Task löschen - <?= esc($selected_board['board']) ?></span>
                <?php endif; ?>
            <?php elseif (isset($table)): ?>
                <?php if ($todo == "create"): ?>
                    <span>Task erstellen</span>
                <?php elseif ($todo == "update"): ?>
                    <span>Task bearbeiten</span>
                <?php elseif ($todo == "delete"): ?>
                    <span>Task löschen</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <!--Für Table dient die Board-ID von 0 dazu, dass die Parameterreihenfolge in der submit-Funktion konsistent bleibt.-->
            <form method="POST"
                <?php if (isset($cards) && $todo == "create"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/cards/' . $selected_board['id'] . '/create') ?>"
                <?php elseif (isset($cards) && $todo == "update"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/cards/' . $selected_board['id'] . '/update/' . $selected_task['id']) ?>"
                <?php elseif (isset($cards) && $todo == "delete"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/cards/' . $selected_board['id'] . '/delete/' . $selected_task['id']) ?>"
                <?php elseif (isset($table) && $todo == "create"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/table/0/create') ?>"
                <?php elseif (isset($table) && $todo == "update"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/table/0/update/' . $selected_task['id']) ?>"
                <?php elseif (isset($table) && $todo == "delete"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/table/0/delete/' . $selected_task['id']) ?>"
                <?php endif; ?>>

                <div class="form-group row mb-3">
                    <!-- col-md: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-md kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Bezeichnung" class="col-form-label">Bezeichnung</label>
                    </div>
                    <!--Für die anderen Felder analog-->
                    <div class="col-md-10">
                        <!--Im Voraus ausgefüllt, wenn ein Task zum Bearbeiten oder Löschen ausgewählt wurde-->
                        <!--Beim Löschen soll das Feld deaktiviert sein-->
                        <!--Die $Bezeichnung-Variable (also die Variable mit dem gleichen Namen wie id und name) enthält den vom Benutzer eingegebenen Wert,
                        wenn ein Fehler aufgetreten ist und das Formular neu angezeigt wird.-->
                        <!--Diese hat für Update Priorität,
                        da $selected_spalte['spalte'] den alten Wert von dem zu bearbeitenden Spalten-Element enthält
                        und daher nur einmal am Anfang geladen werden soll.-->
                        <!--Class: Wenn ein Fehler auftritt, wird das Feld rot umrandet.-->
                        <input type="text" class="form-control <?=(isset($error['Bezeichnung']))?'is-invalid':''?>"
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für den Task"
                                <?php if (($todo == "create" || $todo == "update") && isset($Bezeichnung)): ?>
                                    value="<?= esc($Bezeichnung) ?>"
                                <?php elseif ($todo == "update"): ?>
                                    value="<?= esc($selected_task['tasks']) ?>"
                                <?php elseif ($todo == "delete"): ?>
                                    value="<?= esc($selected_task['tasks']) ?>"
                                    disabled
                                <?php endif; ?>>
                        <!--Wenn ein Fehler auftritt, erscheint die Fehlermeldung in einem div unter dem Eingabefeld.-->
                        <?php if (isset($error['Bezeichnung'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['Bezeichnung']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Mit Dropdowns gelöst, sodass nur IDs ausgewählt werden können, die auch existieren. Für die nächsten ID-Felder analog-->
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="TaskartID" class="col-form-label">Taskart</label>
                    </div>
                    <!--Für die anderen Dropdowns analog-->
                    <div class="col-md-10">
                        <!--Bei Create wird der Dropdown leer und ausgegraut angezeigt, wenn der Benutzer keine Probleme bei der Validierung kriegt.-->
                        <!--Sobald etwas ausgewählt wird, ändert sich die Schriftfarbe zu schwarz.-->
                        <!--Bei Edit und Delete hingegen ist schon ein Wert eingefüllt, daher immer schwarz als Default.-->
                        <!--Bei Delete ist der Dropdown wie bei den anderen Feldern deaktiviert.-->
                        <select id="TaskartID" name="TaskartID" class="form-select <?=(isset($error['TaskartID']))?'is-invalid':''?>"
                                <?php if ($todo === "create" && !isset($TaskartID)): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php elseif ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <!--Die Default-Option ist die hier, ausgegraut, und sobald irgendetwas anderes gewählt wird, ändert sich die Farbe zu schwarz.-->
                            <!--Danach kann man auch nicht mehr zu dem hier zurückändern.-->
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Taskart wählen</option>
                            <?php endif; ?>
                            <?php foreach ($taskarten as $taskart): ?>
                                <?php // Komplizierte Logik, um die richtige Option als ausgewählt zu markieren
                                $isSelected = '';
                                // Nach einem Validierungsfehler bei einem anderen Element wird das vorhin ausgewählte Element ($TaskartID) in dem Dropdown ausgefüllt.
                                if (($todo === "create" || $todo === "update") && isset($TaskartID)) {
                                    $isSelected = ($TaskartID == $taskart['id']) ? 'selected' : '' ;
                                } // Beim Laden des Formulars zum Bearbeiten oder Löschen wird das Element ausgewählt, das zu dem betroffenen Spalten-Element gehört.
                                elseif (($todo === "update" || $todo === "delete")) {
                                    $isSelected = ($selected_taskart['id'] == $taskart['id']) ? 'selected' : '' ;
                                }
                                ?>
                                <option value="<?= esc($taskart['id']) ?>"
                                        style="color:#000;"
                                        <?=$isSelected?>>
                                    <?= esc($taskart['taskart']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($error['TaskartID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['TaskartID']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="PersonID" class="col-form-label">Zugewiesene Person</label>
                    </div>
                    <div class="col-md-10">
                        <select id="PersonID" name="PersonID" class="form-select <?=(isset($error['PersonID']))?'is-invalid':''?>"
                                <?php if ($todo === "create" && !isset($PersonID)): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php elseif ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Person wählen</option>
                            <?php endif; ?>
                            <?php foreach ($personen as $person): ?>
                                <?php
                                $isSelected = '';
                                if (($todo === "create" || $todo === "update") && isset($PersonID)) {
                                    $isSelected = ($PersonID == $person['id']) ? 'selected' : '' ;
                                }
                                elseif (($todo === "update" || $todo === "delete")) {
                                    $isSelected = ($selected_person['id'] == $person['id']) ? 'selected' : '' ;
                                }
                                ?>
                                <option value="<?= esc($person['id']) ?>"
                                        style="color:#000;"
                                        <?=$isSelected?>>
                                    <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($error['PersonID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['PersonID']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SpaltenID" class="col-form-label">Spalte</label>
                    </div>
                    <div class="col-md-10">
                        <select id="SpaltenID" name="SpaltenID" class="form-select <?=(isset($error['SpaltenID']))?'is-invalid':''?>"
                                <?php if ($todo === "create" && !isset($SpaltenID)): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php elseif ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Spalte wählen</option>
                            <?php endif; ?>
                            <?php foreach ($spalten as $spalte): ?>
                                <?php if (isset($table) || (isset($cards) && $spalte['boardsid'] == $selected_board['id'])): ?>
                                    <?php
                                        $isSelected = '';
                                        if (($todo === "create" || $todo === "update") && isset($SpaltenID)) {
                                            $isSelected = ($SpaltenID == $spalte['id']) ? 'selected' : '' ;
                                        }
                                        elseif (($todo === "update" || $todo === "delete")) {
                                            $isSelected = ($selected_spalte['id'] == $spalte['id']) ? 'selected' : '' ;
                                        }
                                    ?>
                                    <option value="<?= esc($spalte['id']) ?>"
                                            style="color:#000;"
                                            <?=$isSelected?>>
                                        <?= esc($spalte['spalte']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($error['SpaltenID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['SpaltenID']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control <?=(isset($error['SortID']))?'is-invalid':''?>"
                               id="SortID" name="SortID" placeholder="ID zum Sortieren"
                                <?php if (($todo == "create" || $todo == "update") && isset($SortID)): ?>
                                    value="<?= esc($SortID) ?>"
                                <?php elseif ($todo == "update"): ?>
                                    value="<?= esc($selected_task['sortid']) ?>"
                                <?php elseif ($todo == "delete"): ?>
                                    value="<?= esc($selected_task['sortid']) ?>"
                                    disabled
                                <?php endif; ?>>
                        <?php if (isset($error['SortID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['SortID']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Erinnerungsdatum" class="col-form-label">Erinnerungsdatum</label>
                    </div>
                    <div class="col-md-10">
                        <!--Zu Beginn beim Erstellen ist es leer und ausgegraut.-->
                        <!--Beim Bearbeiten/Löschen ist es schon befüllt, daher immer schwarz als Default.-->
                        <!--Sobald ein Datum komplett eingegeben wurde, wird die Schrift schwarz. Wenn nicht mehr vollständig, wird es wieder grau.-->
                        <!-- Wenn nicht null, setzt zuerst auf $Erinnerungsdatum, und nur wenn der erste null ist, auf $selected_task['erinnerungsdatum'].-->
                        <?php
                        $inputValue = $Erinnerungsdatum ?? ($selected_task['erinnerungsdatum'] ?? '');
                        ?>
                        <!--Wenn wahr, wird die Farbe auf Schwarz gesetzt, ansonsten grau.-->
                        <!--Leere Werte werden in Erinnerungsdatum als '0000-00-00 00:00:00' in der DB gespeichert, daher müssen wir danach testen.-->
                        <input class="form-control <?=(isset($error['Erinnerungsdatum']))?'is-invalid':''?>"
                               id="Erinnerungsdatum" name="Erinnerungsdatum" placeholder="Erinnerungsdatum" type="datetime-local"
                               oninput="this.style.color = this.value ? '#212529' : '#6c757d'"
                               style="color: <?= ($inputValue === '' || $inputValue === '0000-00-00 00:00:00') ? '#6c757d' : '#212529' ?>;"
                                <?php if (($todo == "create" || $todo == "update") && isset($Erinnerungsdatum)): ?>
                                    value="<?= esc($Erinnerungsdatum) ?>"
                                <?php elseif ($todo == "update"): ?>
                                    value="<?= esc($selected_task['erinnerungsdatum']) ?>"
                                <?php elseif ($todo == "delete"): ?>
                                    value="<?= esc($selected_task['erinnerungsdatum']) ?>"
                                    disabled
                                <?php endif; ?>
                                <?php if (false): ?>
                                    disabled
                                <?php endif; ?>>
                        <?php if (isset($error['Erinnerungsdatum'])): ?>
                        <div class="invalid-feedback">
                            <?= esc($error['Erinnerungsdatum']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Erinnerung" class="col-form-label">Erinnerung</label>
                    </div>
                    <div class="col-md-10 d-flex align-items-center">
                        <!--Der versteckte Input sendet normalerweise den Wert "0".-->
                        <!--Wenn die Checkbox angehakt ist, wird die PHP-Bedingung getriggert,-->
                        <!--und je nach $selected_task['erinnerung'] aus der Datenbank ein 'checked' gesetzt,-->
                        <!--was den Wert 1 sendet, welcher den Wert 0 vom versteckten Input überschreibt.-->
                        <!--Hacky workaround, da unchecked Checkboxes keinen Wert senden.-->
                        <input type="hidden" name="Erinnerung" value="0">
                        <input type="checkbox" class="form-check-input" id="Erinnerung" name="Erinnerung"
                                value="1"
                                <?php
                                $isChecked = false;
                                if (isset($Erinnerung)) {
                                    $isChecked = ($Erinnerung == 1);
                                }
                                elseif (($todo === "update" || $todo === "delete")) {
                                    $isChecked = (!empty($selected_task['erinnerung']));
                                }
                                ?>
                                <?= $isChecked ? 'checked' : '' ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Notizen" class="col-form-label">Notizen</label>
                    </div>
                    <div class="col-md-10"> <!-- rows="5" macht die textarea höher. So formatiert, damit in der Textarea keine Einschübe auftauchen -->
                        <textarea type="text" class="form-control <?=(isset($error['Notizen']))?'is-invalid':''?>"
                                  rows="5" id="Notizen" name="Notizen" placeholder="Weitere Bemerkungen zum Task"
                        <?php if ($todo == "delete"): ?>
                            disabled
                        <?php endif; ?>
                        ><?php if (($todo == "create" || $todo == "update") && isset($Notizen)): ?><?= esc($Notizen) ?><?php elseif ($todo == "update" || $todo == "delete"): ?><?= esc($selected_task['notizen']) ?><?php endif; ?></textarea>
                        <!--Auf einer Zeile, damit keine Einschübe in der Textarea entstehen-->
                        <?php if (isset($error['Notizen'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['Notizen']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Verschiedene Buttons je nach Aktion-->
                <?php if ($todo == "delete"): ?>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                <?php elseif ($todo == "create" || $todo == "update"): ?>
                    <button type="submit" class="btn btn-success">Speichern</button>
                <?php endif; ?>

                <!--Verschiedene Abbrechen-Weiterleitungen je nach Ursprungsort-->
                <?php if (isset($table)): ?>
                    <a href="<?= base_url('public/tasks/table/') ?>" class="btn btn-secondary">Abbrechen</a>
                <?php elseif (isset($cards)): ?>
                    <a href="<?= base_url('public/tasks/cards/' . $selected_board['id']) ?>" class="btn btn-secondary">Abbrechen</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
