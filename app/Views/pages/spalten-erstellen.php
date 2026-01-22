<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            <!--Bestimmt Titel des Formulars je nach Aktion-->
            <?php if ($todo == "create"): ?>
                <span>Spalte erstellen</span>
            <?php elseif ($todo == "update"): ?>
                <span>Spalte bearbeiten</span>
            <?php elseif ($todo == "delete"): ?>
                <span>Spalte löschen</span>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <form method="POST"
                    <?php if ($todo == "create"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/create') ?>"
                    <?php elseif ($todo == "update"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/update/' . $selected_spalte['id']) ?>"
                    <?php elseif ($todo == "delete"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/delete/' . $selected_spalte['id']) ?>"
                    <?php endif; ?>>

                <div class="form-group row mb-3">
                    <!-- col-sm: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-sm kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Bezeichnung" class="col-form-label">Bezeichnung</label>
                    </div>
                    <!--Für die anderen Felder analog-->
                    <div class="col-md-10">
                        <!--Im Voraus ausgefüllt, wenn eine Spalte zum Bearbeiten oder Löschen ausgewählt wurde-->
                        <!--Beim Löschen soll das Feld deaktiviert sein-->
                        <!--Class: Wenn ein Fehler auftritt, wird das Feld rot umrandet.-->
                        <input type="text" class="form-control <?= session('errors.Bezeichnung') ? 'is-invalid' : '' ?>"
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte"
                               value="<?= old('Bezeichnung', $selected_spalte['spalte'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.Bezeichnung')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Bezeichnung')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Beschreibung" class="col-form-label">Beschreibung</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control <?= session('errors.Beschreibung') ? 'is-invalid' : '' ?>"
                                  rows="5" id="Beschreibung" name="Beschreibung"
                                  placeholder="Weitere Bemerkungen zur Spalte"
                                  <?= ($todo === "delete") ? 'disabled' : '' ?>><?= old('Beschreibung', $selected_spalte['spaltenbeschreibung'] ?? '') ?></textarea>
                        <?php if (session('errors.Beschreibung')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Beschreibung')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control <?= session('errors.SortID') ? 'is-invalid' : '' ?>"
                               id="SortID" name="SortID" placeholder="ID zum Sortieren"
                               value="<?= old('SortID', $selected_spalte['sortid'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.SortID')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.SortID')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Mit Dropdowns gelöst, sodass nur IDs ausgewählt werden können, die auch existieren. Für die nächsten ID-Felder analog-->
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
                    <!--Für die anderen Dropdowns analog-->
                    <div class="col-md-10">
                        <!--Bei Create wird der Dropdown leer und ausgegraut angezeigt, wenn der Benutzer keine Probleme bei der Validierung kriegt.-->
                        <!--Sobald etwas ausgewählt wird, ändert sich die Schriftfarbe zu schwarz.-->
                        <!--Bei Edit und Delete hingegen ist schon ein Wert eingefüllt, daher immer schwarz als Default.-->
                        <!--Bei Delete ist der Dropdown wie bei den anderen Feldern deaktiviert.-->
                        <select id="Board" name="Board" class="form-select <?= session('errors.Board') ? 'is-invalid' : '' ?>"
                                <?= ($todo === "delete") ? 'disabled' : '' ?>
                                <?php if ($todo === "create"): ?>
                                    style="color:<?= old('Board') ? '#212529' : '#6c757d' ?>;"
                                    onchange="this.style.color='#212529'"
                                <?php else: ?>
                                    style="color:#212529;"
                                <?php endif; ?>>
                            <?php if ($todo === "create"): ?>
                                <option value="" disabled <?= !old('Board') ? 'selected' : '' ?> hidden>Bitte Board wählen</option>
                            <?php endif; ?>

                            <?php foreach ($boards as $board): ?>
                                <option value="<?= esc($board['id']) ?>" style="color:#000;"
                                        <?= (old('Board', $selected_spalte['boardsid'] ?? '') == $board['id']) ? 'selected' : '' ?>>
                                    <?= esc($board['board']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.Board')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Board')) ?>
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
                <!-- Abbrechen soll wie erwartet das Formular schließen -->
                <a href="<?= base_url('public/spalten') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
