<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            <?php if (isset($todo) && $todo == "create"): ?>
                Spalte erstellen
            <?php elseif (isset($todo) && $todo == "update"): ?>
                Spalte bearbeiten
            <?php elseif (isset($todo) && $todo == "delete"): ?>
                Spalte löschen
            <?php else: ?>
                Spalte erstellen
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!-- Form action varies based on mode -->
            <form method="POST" 
                <?php if (isset($todo) && $todo == "create"): ?>
                    action="<?= base_url('public/spalten-erstellen/submit/create') ?>"
                <?php elseif (isset($todo) && $todo == "update" && isset($selected_spalte)): ?>
                    action="<?= base_url('public/spalten-erstellen/submit/update/' . $selected_spalte['id']) ?>"
                <?php elseif (isset($todo) && $todo == "delete" && isset($selected_spalte)): ?>
                    action="<?= base_url('public/spalten-erstellen/submit/delete/' . $selected_spalte['id']) ?>"
                <?php else: ?>
                    action="<?= base_url('public/spalten-erstellen') ?>" onsubmit="return false;"
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
                        <input type="text" class="form-control <?= session('errors.Bezeichnung') ? 'is-invalid' : '' ?>" 
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für die Spalte" 
                               value="<?= old('Bezeichnung', $selected_spalte['spalte'] ?? '') ?>"
                               <?php if (isset($todo) && $todo == "delete"): ?>disabled<?php endif; ?>>
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
                    <div class="col-md-10"> <!-- rows="5" macht die textarea höher -->
                        <textarea class="form-control <?= session('errors.Beschreibung') ? 'is-invalid' : '' ?>" 
                                  rows="5" id="Beschreibung" name="Beschreibung"
                                  placeholder="Weitere Bemerkungen zur Spalte" 
                                  <?= (isset($todo) && $todo === "delete") ? 'disabled' : '' ?>><?= old('Beschreibung', $selected_spalte['spaltenbeschreibung'] ?? '') ?></textarea>
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
                               <?php if (isset($todo) && $todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.SortID')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.SortID')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Board" class="col-form-label">Board auswählen</label>
                    </div>
                    <div class="col-md-10">
                        <select id="Board" name="Board" class="form-select <?= session('errors.Board') ? 'is-invalid' : '' ?>"
                                <?= (isset($todo) && $todo === "delete") ? 'disabled' : '' ?>
                                <?= (isset($todo) && $todo === "create") ? 'style="color:#6c757d;" onchange="this.style.color=\'#212529\'"' : 'style="color:#212529;"' ?>>
                            <!--Die Default-Option ist die hier, ausgegraut, und sobald irgendetwas anderes gewählt wird, ändert sich die Farbe zu schwarz.-->
                            <!--Danach kann man auch nicht mehr zu dem hier zurückändern.-->
                            <?php if (!isset($todo) || $todo == "create"): ?>
                                <option value="" disabled selected hidden>Bitte Board wählen</option>
                            <?php endif; ?>
                            <?php foreach ($boards as $board): ?>
                                <option value="<?= esc($board['id']) ?>" style="color:#000;"
                                        <?php if ((isset($todo) && ($todo == "update" || $todo == "delete")) && isset($selected_spalte) && ($selected_spalte['boardsid'] == $board['id'])): ?>
                                            selected
                                        <?php endif; ?>>
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
                
                <?php if (isset($todo) && $todo == "delete"): ?>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-success">Speichern</button>
                <?php endif; ?>
                <!-- Abbrechen soll wie erwartet das Formular schließen -->
                <a href="<?= base_url('public/spalten') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
