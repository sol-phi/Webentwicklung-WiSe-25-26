<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card blue-gradient-boards-card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            <!--Bestimmt Titel des Formulars je nach Aktion-->
            <?php if ($todo == "create"): ?>
                <span>Board erstellen</span>
            <?php elseif ($todo == "copy"): ?>
                <span>Board kopieren</span>
            <?php elseif ($todo == "update"): ?>
                <span>Board bearbeiten</span>
            <?php elseif ($todo == "delete"): ?>
                <span>Board löschen</span>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <form method="POST"
                    <?php if ($todo == "create"): ?>
                        action="<?= base_url('public/boards-erstellen/submit/create') ?>"
                    <?php elseif ($todo == "copy"): ?>
                        action="<?= base_url('public/boards-erstellen/submit/copy/' . $selected_board['id']) ?>"
                    <?php elseif ($todo == "update"): ?>
                        action="<?= base_url('public/boards-erstellen/submit/update/' . $selected_board['id']) ?>"
                    <?php elseif ($todo == "delete"): ?>
                        action="<?= base_url('public/boards-erstellen/submit/delete/' . $selected_board['id']) ?>"
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
                               id="Bezeichnung" name="Bezeichnung" placeholder="Bezeichnung für das Board"
                               value="<?= old('Bezeichnung', $selected_board['board'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.Bezeichnung')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Bezeichnung')) ?>
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
                <a href="<?= base_url('public/boards') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
