<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            Spalte erstellen
        </div>

        <div class="card-body">
            <!-- onsubmit deaktiviert den "Speichern" button -->
            <form method="POST" action="<?= base_url('public/spalten-erstellen') ?>" onsubmit="return false;">

                <div class="form-group row mb-3">
                    <!-- col-sm: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-sm kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Bezeichnung" class="col-form-label">Bezeichnung</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Beschreibung" class="col-form-label">Beschreibung</label>
                    </div>
                    <div class="col-md-10"> <!-- rows="5" macht die textarea höher -->
                        <textarea type="text" class="form-control" rows="5" id="Beschreibung" name="Beschreibung" placeholder="Weitere Bemerkungen zur Spalte" required></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="SortID" name="SortID" placeholder="ID zum Sortieren" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
                    <div class="col-md-10">
                        <select id="Board" name="Board" class="form-select" style="color:#6c757d;" onchange="this.style.color='#212529'">
                            <!--Die Default-Option ist die hier, ausgegraut, und sobald irgendetwas anderes gewählt wird, ändert sich die Farbe zu schwarz.-->
                            <!--Danach kann man auch nicht mehr zu dem hier zurückändern.-->
                            <option value="" disabled selected hidden>Bitte Board wählen</option>
                            <?php foreach ($boards as $board): ?>
                                <option value="<?= esc($board['id']) ?>" style="color:#000;"><?= esc($board['board']) ?></option>
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
