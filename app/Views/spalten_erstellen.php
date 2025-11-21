<div class="container mt-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4">
            <b>Spalte erstellen</b>
        </div>

        <div class="card-body">
            <!-- onsubmit deaktiviert den "Speichern" button -->
            <form method="POST" action="<?= base_url('public/spalten_erstellen') ?>" onsubmit="return false;">

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
                        <textarea type="text" class="form-control" rows="5" id="Beschreibung" name="Beschreibung" required></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="SortID" class="col-form-label">SortID</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="SortID" name="SortID" placeholder="SortID angeben" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
                    <div class="col-md-10">
                        <select id="Board" name="Board" class="form-select">
                            <option value="1">Allgemeine Todos</option>
                            <option value="2">Dringende Aufgaben</option>
                            <option value="3">In Arbeit</option>
                            <option value="4">Warten auf Rückmeldung</option>
                            <option value="5">Langfristige Planung</option>
                            <option value="6">Abgeschlossen</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Speichern</button>
                <button type="reset" class="btn btn-secondary">Abbrechen</button> <!-- reset setzt das Formular zurück -->
            </form>
        </div>
    </div>
</div>
