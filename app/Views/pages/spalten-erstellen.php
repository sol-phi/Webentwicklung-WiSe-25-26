<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!--Die data-Werte sollten allesamt datensicher sein, durch vorherige Abfänge von URL-Manipulationen.-->
            <!--Bestimmt Titel des Formulars je nach Herkunft und Aktion-->
                <?php if ($todo == "create"): ?>
                    <span>Spalte erstellen</span>
                <?php elseif ($todo == "update"): ?>
                    <span>Spalte bearbeiten</span>
                <?php elseif ($todo == "delete"): ?>
                    <span>Spalte löschen</span>
                <?php endif; ?>
        </div>

        <div class="card-body">
            <!-- onsubmit deaktiviert den "Speichern" button -->
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <form method="POST"
                    <?php if ($todo == "create"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/create') ?>"
                    <?php elseif ($todo == "update"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/update/'. $selected_spalte['id']) ?>"
                    <?php elseif ($todo == "delete"): ?>
                        action="<?= base_url('public/spalten-erstellen/submit/delete/'. $selected_spalte['id']) ?>"
                    <?php endif; ?>>

                <div class="form-group row mb-3">
                    <!-- col-sm: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-sm kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Bezeichnung" class="col-form-label">Bezeichnung</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte" required
                                <?php if ($todo == "update" || $todo == "delete"): ?>
                                    value="<?= esc($selected_spalte['spalte']) ?>"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>
                        >
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Beschreibung" class="col-form-label">Beschreibung</label>
                    </div>
                    <div class="col-md-10">
                        <!-- komisch formatiert weil sonst Platzhalter wegen dem Zeilenumbruch in der Textarea weggeht -->
                        <textarea class="form-control" rows="5" id="Beschreibung" name="Beschreibung"
                                  placeholder="Weitere Bemerkungen zur Spalte" required <?= ($todo === "delete") ? 'disabled'
                                : '' ?>><?= esc($selected_spalte['spaltenbeschreibung'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="SortID" name="SortID" placeholder="ID zum Sortieren" required
                                <?php if ($todo == "update" || $todo == "delete"): ?>
                                    value="<?= esc($selected_spalte['sortid']) ?>"
                                <?php endif; ?>
                                <?php if ($todo == "delete"): ?>
                                    disabled
                                <?php endif; ?>
                        >
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
                    <div class="col-md-10">
                        <select id="Board" name="Board" class="form-select"
                                <?= ($todo === "delete") ? 'disabled' : '' ?>
                                <?= ($todo === "create") ? 'style="color:#6c757d;" onchange="this.style.color=\'#212529\'"' : 'style="color:#212529;"' ?>>
                            <?php if ($todo === "create"): ?>
                                <option value="" disabled selected hidden>Bitte Board wählen</option>
                            <?php endif; ?>

                            <?php foreach ($boards as $board): ?>
                                <option value="<?= esc($board['id']) ?>" style="color:#000;"
                                        <?= (isset($selected_spalte) && $selected_spalte['boardsid'] == $board['id']) ? 'selected' : '' ?>>
                                    <?= esc($board['board']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Speichern</button>
                <!-- Abbrechen soll wie erwartet das Formular schließen -->
                <a href="<?= base_url('public/spalten') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
