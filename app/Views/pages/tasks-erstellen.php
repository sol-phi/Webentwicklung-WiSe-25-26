<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card blue-gradient-boards-card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <!--Bestimmt Titel des Formulars je nach Herkunft und Aktion-->
            <?php if ($view == 'dashboard'): ?>
                <?php if ($todo == "create"): ?>
                    <span>Task erstellen - <?= esc($selected_board['board']) ?></span>
                <?php elseif ($todo == "copy"): ?>
                    <span>Task kopieren - <?= esc($selected_board['board']) ?></span>
                <?php elseif ($todo == "update"): ?>
                    <span>Task bearbeiten - <?= esc($selected_board['board']) ?></span>
                <?php elseif ($todo == "delete"): ?>
                    <span>Task löschen - <?= esc($selected_board['board']) ?></span>
                <?php endif; ?>
            <?php elseif ($view == 'tasks'): ?>
                <?php if ($todo == "create"): ?>
                    <span>Task erstellen</span>
                <?php elseif ($todo == "copy"): ?>
                    <span>Task kopieren</span>
                <?php elseif ($todo == "update"): ?>
                    <span>Task bearbeiten</span>
                <?php elseif ($todo == "delete"): ?>
                    <span>Task löschen</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <!--Für Tasks dient die Board-ID von 0 dazu, dass die Parameterreihenfolge in der submit-Funktion konsistent bleibt.-->
            <form method="POST"
                <?php if ($view == 'dashboard' && $todo == "create"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/dashboard/' . $selected_board['id'] . '/create') ?>"
                <?php elseif ($view == 'dashboard' && $todo == "copy"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/dashboard/' . $selected_board['id'] . '/copy/' . $selected_task['id']) ?>"
                <?php elseif ($view == 'dashboard' && $todo == "update"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/dashboard/' . $selected_board['id'] . '/update/' . $selected_task['id']) ?>"
                <?php elseif ($view == 'dashboard' && $todo == "delete"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/dashboard/' . $selected_board['id'] . '/delete/' . $selected_task['id']) ?>"
                <?php elseif ($view == 'tasks' && $todo == "create"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/tasks/0/create') ?>"
                <?php elseif ($view == 'tasks' && $todo == "copy"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/tasks/0/copy/' . $selected_task['id']) ?>"
                <?php elseif ($view == 'tasks' && $todo == "update"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/tasks/0/update/' . $selected_task['id']) ?>"
                <?php elseif ($view == 'tasks' && $todo == "delete"): ?>
                    action="<?= base_url('public/tasks-erstellen/submit/tasks/0/delete/' . $selected_task['id']) ?>"
                <?php endif; ?>>

                <div class="form-group row mb-3">
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- col-md: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-md kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Bezeichnung" class="col-form-label">Bezeichnung</label>
                    </div>
                    <!--Für die anderen Felder analog-->
                    <div class="col-md-10">
                        <!--Class: Wenn ein Fehler auftritt, wird das Feld rot umrandet.-->
                        <!--old(): Priorität in der Reihenfolge:-->
                        <!--    Falls Validierung fehlgeschlagen, dann vorherige Werte. -->
                        <!--    Wenn Copy, Update oder Delete, dann Daten von der DB.-->
                        <!--    Als Default '' für Create-->
                        <!--Bei Delete soll das Feld deaktiviert sein-->
                        <input type="text" class="form-control <?= session('errors.Bezeichnung') ? 'is-invalid' : '' ?>"
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für den Task"
                               value="<?= old('Bezeichnung', $selected_task['tasks'] ?? '') ?>"
                               <?= $todo == "delete" ? 'disabled' : '' ?>>
                        <?php if (session('errors.Bezeichnung')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Bezeichnung')) ?>
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
                        <!--Bei Create wird der Dropdown leer und ausgegraut angezeigt. Sobald etwas ausgewählt wird, ändert sich die Schriftfarbe zu schwarz.-->
                        <!--Bei Edit und Delete hingegen ist schon ein Wert eingefüllt, daher immer schwarz als Default.-->
                        <!--Bei Delete ist der Dropdown wie bei den anderen Feldern deaktiviert.-->
                        <!--Für die anderen Dropdowns analog-->
                        <select class="form-select <?= session('errors.TaskartID') ? 'is-invalid' : '' ?>"
                                id="TaskartID" name="TaskartID"
                                <?php if ($todo === "create"): ?>
                                    style="color:<?= old('TaskartID') ? '#212529' : '#6c757d' ?>;"
                                    onchange="this.style.color='#212529'"
                                <?php else: ?>
                                    style="color:#212529;"
                                <?php endif; ?>
                                <?= $todo == "delete" ? 'disabled' : '' ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled <?= !old('TaskartID') ? 'selected' : '' ?> hidden>Bitte Taskart wählen</option>
                            <?php endif; ?>

                            <?php foreach ($taskarten as $taskart): ?>
                                <option value="<?= esc($taskart['id']) ?>" style="color:#000;"
                                        <?= (old('TaskartID', $selected_taskart['id'] ?? '') == $taskart['id']) ? 'selected' : '' ?>>
                                    <?= esc($taskart['taskart']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.TaskartID')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.TaskartID')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="PersonID" class="col-form-label">Zugewiesene Person</label>
                    </div>
                    <div class="col-md-10">
                        <select class="form-select <?= session('errors.PersonID') ? 'is-invalid' : '' ?>"
                                id="PersonID" name="PersonID"
                                <?php if ($todo === "create"): ?>
                                    style="color:<?= old('PersonID') ? '#212529' : '#6c757d' ?>;"
                                    onchange="this.style.color='#212529'"
                                <?php else: ?>
                                    style="color:#212529;"
                                <?php endif; ?>
                                <?= $todo == "delete" ? 'disabled' : '' ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled <?= !old('PersonID') ? 'selected' : '' ?> hidden>Bitte Person wählen</option>
                            <?php endif; ?>

                            <?php foreach ($personen as $person): ?>
                                <option value="<?= esc($person['id']) ?>" style="color:#000;"
                                        <?= (old('PersonID', $selected_person['id'] ?? '') == $person['id']) ? 'selected' : '' ?>>
                                    <?= esc($person['vorname']) ?> <?= esc($person['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.PersonID')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.PersonID')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SpaltenID" class="col-form-label">Spalte</label>
                    </div>
                    <div class="col-md-10">
                        <select class="form-select <?= session('errors.SpaltenID') ? 'is-invalid' : '' ?>"
                                id="SpaltenID" name="SpaltenID"
                                <?php if ($todo === "create"): ?>
                                    style="color:<?= (old('SpaltenID') || isset($selected_spalte['id'])) ? '#212529' : '#6c757d' ?>;"
                                    onchange="this.style.color='#212529'"
                                <?php else: ?>
                                    style="color:#212529;"
                                <?php endif; ?>
                                <?= $todo == "delete" ? 'disabled' : '' ?>>
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled <?= !old('SpaltenID') ? 'selected' : '' ?> hidden>Bitte Spalte wählen</option>
                            <?php endif; ?>

                            <?php foreach ($spalten as $spalte): ?>
                                <?php if ($view == 'tasks' || ($view == 'dashboard' && $spalte['boardsid'] == $selected_board['id'])): ?>
                                    <option value="<?= esc($spalte['id']) ?>" style="color:#000;"
                                            <?= (old('SpaltenID', $selected_spalte['id'] ?? '') == $spalte['id']) ? 'selected' : '' ?>>
                                        <?= esc($spalte['spalte']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.SpaltenID')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.SpaltenID')) ?>
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
                        <!--und je nach $selected_task['erinnerung'] aus der Datenbank oder nach old() aus der vorherigen Validierung ein 'checked' gesetzt,-->
                        <!--was den Wert 1 sendet, welcher den Wert 0 vom versteckten Input überschreibt.-->
                        <!--Hacky workaround, da unchecked Checkboxes keinen Wert senden.-->
                        <input type="hidden" name="Erinnerung" value="0">
                        <input type="checkbox" class="form-check-input" id="Erinnerung" name="Erinnerung"
                               value="1"
                               <?= old('Erinnerung', $selected_task['erinnerung'] ?? 0) ? 'checked' : '' ?>
                               <?= $todo == "delete" ? 'disabled' : '' ?>>
                    </div>
                </div>

                <!--Beim ersten Laden der Seite (um Flashes durch JavaScript zu verhindern): Verstecke Erinnerungsdatum, wenn Erinnerung == 0-->
                <div class="form-group row mb-3" id="erinnerungsdatum-container"
                     style="display: <?= old('Erinnerung', $selected_task['erinnerung'] ?? 0) == 1 ? 'flex' : 'none' ?>;">
                    <div class="col-md-2">
                        <label for="Erinnerungsdatum" class="col-form-label">Erinnerungsdatum</label>
                    </div>
                    <div class="col-md-10">
                        <!--value: Falls nix in vorheriger Validation und DB, erzeuge Default-Wert, das aktuelle Datum.
                         So werden Probleme mit 00:00:00 vermieden, Erinnerungsdatum besitzt immer einen Wert.-->
                        <input type="datetime-local"
                               class="form-control <?= session('errors.Erinnerungsdatum') ? 'is-invalid' : '' ?>"
                               id="Erinnerungsdatum"
                               name="Erinnerungsdatum"
                               value="<?= esc(old('Erinnerungsdatum', $selected_task['erinnerungsdatum'] ?? date('Y-m-d\TH:i'))) ?>"
                                <?= $todo == "delete" ? 'disabled' : '' ?>>
                        <?php if (session('errors.Erinnerungsdatum')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Erinnerungsdatum')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Notizen" class="col-form-label">Notizen</label>
                    </div>
                    <div class="col-md-10">
                        <!-- rows="5" macht die textarea höher. Komische Einschübe hier, damit in der Textarea keine Einschübe auftauchen.
                        Bei Delete sollte der Placeholder nicht auftauchen, daher der if-else-Block-->
                        <textarea class="form-control <?= session('errors.Notizen') ? 'is-invalid' : '' ?>"
                                  rows="5" id="Notizen" name="Notizen"
                                  <?php if ($todo == "delete"): ?>disabled<?php else: ?>placeholder="Weitere Bemerkungen zum Task"<?php endif; ?>
                                  ><?= old('Notizen', $selected_task['notizen'] ?? '') ?></textarea>
                        <?php if (session('errors.Notizen')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Notizen')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Verschiedene Buttons je nach Aktion-->
                <?php if ($todo == "delete"): ?>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                <?php elseif ($todo == "create" || $todo == "copy" || $todo == "update"): ?>
                    <button type="submit" class="btn btn-success">Speichern</button>
                <?php endif; ?>

                <!--Verschiedene Abbrechen-Weiterleitungen je nach Ursprungsort-->
                <?php if ($view == 'tasks'): ?>
                    <a href="<?= base_url('public/tasks/') ?>" class="btn btn-secondary">Abbrechen</a>
                <?php elseif ($view == 'dashboard'): ?>
                    <a href="<?= base_url('public/dashboard/' . $selected_board['id']) ?>" class="btn btn-secondary">Abbrechen</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/erinnerungsdatum.js') ?>"></script>