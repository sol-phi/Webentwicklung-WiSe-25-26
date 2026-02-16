<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card blue-gradient-boards-card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            <!--Bestimmt Titel des Formulars je nach Aktion-->
            <?php if ($todo == "create"): ?>
                <span>Spalte erstellen</span>
            <?php elseif ($todo == "copy"): ?>
                <span>Spalte kopieren</span>
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
                    <?php elseif ($todo == "copy"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/copy/' . $selected_spalte['id']) ?>"
                    <?php elseif ($todo == "update"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/update/' . $selected_spalte['id']) ?>"
                    <?php elseif ($todo == "delete"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/delete/' . $selected_spalte['id']) ?>"
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
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte"
                               value="<?= old('Bezeichnung', $selected_spalte['spalte'] ?? '') ?>"
                               <?= $todo == "delete" ? 'disabled' : '' ?>>
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
                        <input type="text" class="form-control <?= session('errors.Beschreibung') ? 'is-invalid' : '' ?>"
                                  id="Beschreibung" name="Beschreibung" placeholder="Weitere Bemerkungen zur Spalte"
                                  value="<?= old('Beschreibung', $selected_spalte['spaltenbeschreibung'] ?? '') ?>"
                                  <?= ($todo === "delete") ? 'disabled' : '' ?>>
                        <?php if (session('errors.Beschreibung')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Beschreibung')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Mit Dropdowns gelöst, sodass nur IDs ausgewählt werden können, die auch existieren.-->
                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
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
                <?php elseif ($todo == "create" || $todo == "copy" || $todo == "update"): ?>
                    <button type="submit" class="btn btn-success">Speichern</button>
                <?php endif; ?>
                <!-- Abbrechen soll wie erwartet das Formular schließen -->
                <a href="<?= base_url('public/spalten') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
