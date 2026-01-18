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
                        <!--Die $Bezeichnung-Variable (also die Variable mit dem gleichen Namen wie id und name) enthält den vom Benutzer eingegebenen Wert,
                        wenn ein Fehler aufgetreten ist und das Formular neu angezeigt wird.-->
                        <!--Diese hat für Update Priorität,
                        da $selected_spalte['spalte'] den alten Wert von dem zu bearbeitenden Spalten-Element enthält
                        und daher nur einmal am Anfang geladen werden soll.-->
                        <!--Class: Wenn ein Fehler auftritt, wird das Feld rot umrandet.-->
                        <input type="text" class="form-control <?=(isset($error['Bezeichnung']))?'is-invalid':''?>"
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte"
                                <?php if (($todo == "create" || $todo == "update") && isset($Bezeichnung)): ?>
                                    value="<?= esc($Bezeichnung) ?>"
                                <?php elseif ($todo == "update"): ?>
                                    value="<?= esc($selected_spalte['spalte']) ?>"
                                <?php elseif ($todo == "delete"): ?>
                                    value="<?= esc($selected_spalte['spalte']) ?>"
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

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Beschreibung" class="col-form-label">Beschreibung</label>
                    </div>
                    <div class="col-md-10"> <!-- rows="5" macht die textarea höher -->
                        <textarea type="text" class="form-control <?=(isset($error['Beschreibung']))?'is-invalid':''?>"
                                  rows="5" id="Beschreibung" name="Beschreibung" placeholder="Weitere Bemerkungen zur Spalte"
                        <?php if ($todo == "delete"): ?>
                            disabled
                        <?php endif; ?>
                        ><?php if (($todo == "create" || $todo == "update") && isset($Beschreibung)): ?><?= esc($Beschreibung) ?><?php elseif ($todo == "update" || $todo == "delete"): ?><?= esc($selected_spalte['spaltenbeschreibung']) ?><?php endif; ?></textarea>
                        <!--Auf einer Zeile, damit keine Einschübe in der Textarea entstehen-->
                        <?php if (isset($error['Beschreibung'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['Beschreibung']) ?>
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
                                    value="<?= esc($selected_spalte['sortid']) ?>"
                                <?php elseif ($todo == "delete"): ?>
                                    value="<?= esc($selected_spalte['sortid']) ?>"
                                    disabled
                                <?php endif; ?>>
                        <?php if (isset($error['SortID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['SortID']) ?>
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
                        <select id="BoardID" name="BoardID" class="form-select <?=(isset($error['BoardID']))?'is-invalid':''?>"
                                <?php if ($todo == "create" && !isset($BoardID)): ?>
                                    style="color:#6c757d;"
                                    onchange="this.style.color='#212529'"
                                <?php elseif ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>>
                            <!--Die Default-Option ist die hier, ausgegraut, und sobald irgendetwas anderes gewählt wird, ändert sich die Farbe zu schwarz.-->
                            <!--Danach kann man auch nicht mehr zu dem hier zurückändern.-->
                            <?php if ($todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Board wählen</option>
                            <?php endif; ?>
                            <?php foreach ($boards as $board): ?>
                                <?php // Komplizierte Logik, um die richtige Option als ausgewählt zu markieren
                                $isSelected = '';
                                // Nach einem Validierungsfehler bei einem anderen Element wird das vorhin ausgewählte Element ($BoardID) in dem Dropdown ausgefüllt.
                                if (($todo === "create" || $todo === "update") && isset($BoardID)) {
                                    $isSelected = ($BoardID == $board['id']) ? 'selected' : '' ;
                                } // Beim Laden des Formulars zum Bearbeiten oder Löschen wird das Element ausgewählt, das zu dem betroffenen Spalten-Element gehört.
                                elseif (($todo === "update" || $todo === "delete")) {
                                    $isSelected = ($selected_board['id'] == $board['id']) ? 'selected' : '' ;
                                }
                                ?>
                                <option value="<?= esc($board['id']) ?>"
                                        style="color:#000;"
                                        <?=$isSelected?>>
                                    <?= esc($board['board']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($error['BoardID'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($error['BoardID']) ?>
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
