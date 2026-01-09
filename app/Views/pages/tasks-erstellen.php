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
                    <div class="col-md-10">
                        <!--Im Voraus ausgefüllt, wenn ein Task zum Bearbeiten oder Löschen ausgewählt wurde-->
                        <!--Beim Löschen soll das Feld deaktiviert sein-->
                        <!--Für die anderen Felder analog-->
                        <input type="text" class="form-control" id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für den Task" required
                               <?php if ($todo == "update" || $todo == "delete"): ?>
                                   value="<?= esc($selected_task['tasks']) ?>"
                               <?php endif; ?>
                               <?php if ($todo == "delete"): ?>
                                   disabled
                               <?php endif; ?>>
                    </div>
                </div>

                <!--Mit Dropdowns gelöst, sodass nur IDs ausgewählt werden können, die auch existieren. Für die nächsten ID-Felder analog-->
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="TaskartID" class="col-form-label">Taskart</label>
                    </div>
                    <div class="col-md-10">
                        <!--Bei Create wird der Dropdown leer und ausgegraut angezeigt. Sobald etwas ausgewählt wird, ändert sich die Schriftfarbe zu schwarz.-->
                        <!--Bei Edit und Delete hingegen ist schon ein Wert eingefüllt, daher immer schwarz als Default.-->
                        <!--Bei Delete ist der Dropdown wie bei den anderen Feldern deaktiviert.-->
                        <!--Für die anderen Dropdowns analog-->
                        <select class="form-select" id="TaskartID" name="TaskartID" required
                                <?php if ($todo === "create"): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Taskart wählen</option>
                            <?php endif; ?>

                            <?php foreach ($taskarten as $taskart): ?>
                                <!--style="color:#000;" dient dazu, die Dropdown-Einträge selbst direkt schwarz anzuzeigen-->
                                <!--Die Taskarten werden dynamisch aus der Datenbank geladen,-->
                                <!--und beim Bearbeiten/Löschen wird die Taskart, die zu dem Task gehört, im Voraus ausgewählt.-->-->
                                <!--Für die anderen Dropdowns analog-->
                                <option value="<?= esc($taskart['id']) ?>" style="color:#000;"
                                        <?php if (($todo == "update" || $todo == "delete") && ($selected_taskart['id'] == $taskart['id'])): ?>
                                            selected
                                        <?php endif; ?>>
                                    <?= esc($taskart['taskart']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="PersonID" class="col-form-label">Zugewiesene Person</label>
                    </div>
                    <div class="col-md-10">
                        <select class="form-select" id="PersonID" name="PersonID" required
                                <?php if ($todo === "create"): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Person wählen</option>
                            <?php endif; ?>

                            <?php foreach ($personen as $person): ?>
                                <option value="<?= esc($person['id']) ?>" style="color:#000;"
                                        <?php if (($todo == "update" || $todo == "delete") && ($selected_person['id'] == $person['id'])): ?>
                                            selected
                                        <?php endif; ?>>
                                    <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SpaltenID" class="col-form-label">Spalte</label>
                    </div>
                    <div class="col-md-10">
                        <select class="form-select" id="SpaltenID" name="SpaltenID" required
                                <?php if ($todo === "create"): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Spalte wählen</option>
                            <?php endif; ?>

                            <?php foreach ($spalten as $spalte): ?>
                                <!--Falls in der Kartenansicht, nur Spalten des ausgewählten Boards anzeigen-->
                                <?php if (isset($table) || (isset($cards) && $spalte['boardsid'] == $selected_board['id'])): ?>
                                    <!--Falls beim Bearbeiten/Löschen, dann die Spalte, die zum Task gehört, im Voraus auswählen-->
                                    <option value="<?= esc($spalte['id']) ?>" style="color:#000;"
                                            <?php if (($todo == "update" || $todo == "delete") &&
                                                    ($selected_spalte['id'] == $spalte['id'])): ?>
                                                selected
                                            <?php endif; ?>>
                                        <?= esc($spalte['spalte']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="SortID" name="SortID" placeholder="ID zum Sortieren" required
                                <?php if ($todo == "update" || $todo == "delete"): ?>
                                    value="<?= esc($selected_task['sortid']) ?>"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
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
                        <input type="datetime-local" class="form-control" id="Erinnerungsdatum" name="Erinnerungsdatum" placeholder="Erinnerungsdatum" required
                               oninput="this.style.color = this.value ? '#212529' : '#6c757d'"
                                <?php if ($todo == "create"): ?>
                                    style="color:#6c757d;"
                               <?php elseif ($todo == "update" || $todo == "delete"): ?>
                                   value="<?= esc($selected_task['erinnerungsdatum']) ?>"
                               <?php endif; ?>
                               <?php if ($todo == "delete"): ?>
                                   disabled
                               <?php endif; ?>>
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
                                <?= (($todo === "update" || $todo === "delete") && !empty($selected_task['erinnerung'])) ? 'checked' : '' ?>
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
                        <textarea type="text" class="form-control" rows="5" id="Notizen" name="Notizen" placeholder="Weitere Bemerkungen zum Task" required
                        <?php if ($todo == "delete"): ?>
                            disabled
                        <?php endif; ?>
                        ><?php if ($todo == "update" || $todo == "delete"): ?><?= esc($selected_task['notizen']) ?><?php endif; ?></textarea>
                        <!--Auf einer Zeile, damit keine Einschübe in der Textarea entstehen-->
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
