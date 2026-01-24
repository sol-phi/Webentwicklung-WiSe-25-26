<div class="container mt-4 mb-4">
    <!-- margin_top-4 -->
    <div class="card">
        <!-- font_size-4 -->
        <div class="card-header fs-4 fw-semibold">
            <!--Bestimmt Titel des Formulars je nach Aktion-->
            <?php if ($todo == "create"): ?>
                <span>Person erstellen</span>
            <?php elseif ($todo == "copy"): ?>
                <span>Person kopieren</span>
            <?php elseif ($todo == "update"): ?>
                <span>Person bearbeiten</span>
            <?php elseif ($todo == "delete"): ?>
                <span>Person löschen</span>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <!--Je nach Ursprungsort wird der submit-Befehl anders gestaltet, damit dieser weiß, wohin anschließend zurückgeleitet werden soll.-->
            <form method="POST"
                    <?php if ($todo == "create"): ?>
                        action="<?= base_url('public/personen-erstellen/submit/create') ?>"
                    <?php elseif ($todo == "copy"): ?>
                        action="<?= base_url('public/personen-erstellen/submit/copy/' . $selected_person['id']) ?>"
                    <?php elseif ($todo == "update"): ?>
                        action="<?= base_url('public/personen-erstellen/submit/update/' . $selected_person['id']) ?>"
                    <?php elseif ($todo == "delete"): ?>
                        action="<?= base_url('public/personen-erstellen/submit/delete/' . $selected_person['id']) ?>"
                    <?php endif; ?>>

                <div class="form-group row mb-3">
                    <!-- mb-3 als Abstand nach unten zum nächsten Element -->
                    <!-- col-md: 2 Spalten von dem Bootstrap-Grid für die Beschreibung vorgesehen, die anderen 10 für den Input -->
                    <!-- col-md kann nicht in die class von <input> und <textarea> gepackt werden, daher hier für Konsistenz überall außen -->
                    <!-- Für die anderen Elemente analog -->
                    <div class="col-md-2">
                        <label for="Vorname" class="col-form-label">Vorname</label>
                    </div>
                    <!--Für die anderen Felder analog-->
                    <div class="col-md-10">
                        <!--Class: Wenn ein Fehler auftritt, wird das Feld rot umrandet.-->
                        <!--old(): Priorität in der Reihenfolge:-->
                        <!--    Falls Validierung fehlgeschlagen, dann vorherige Werte. -->
                        <!--    Wenn Copy, Update oder Delete, dann Daten von der DB.-->
                        <!--    Als Default '' für Create-->
                        <!--Bei Delete soll das Feld deaktiviert sein-->
                        <input type="text" class="form-control <?= session('errors.Vorname') ? 'is-invalid' : '' ?>"
                               id="Vorname" name="Vorname" placeholder="Vorname(n) für die Person"
                               value="<?= old('Vorname', $selected_person['vorname'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.Vorname')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Vorname')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Nachname" class="col-form-label">Nachname</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control <?= session('errors.Nachname') ? 'is-invalid' : '' ?>"
                               id="Nachname" name="Nachname" placeholder="Nachname(n) für die Person"
                               value="<?= old('Nachname', $selected_person['name'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.Nachname')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Nachname')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="EMail" class="col-form-label">E-Mail</label>
                    </div>
                    <div class="col-md-10">
                        <!--type="text" und nicht email, da Validierung serverside-->
                        <input type="text" class="form-control <?= session('errors.EMail') ? 'is-invalid' : '' ?>"
                               id="EMail" name="EMail" placeholder="E-Mail für die Person"
                               value="<?= old('EMail', $selected_person['email'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.EMail')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.EMail')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Passwort" class="col-form-label">Passwort</label>
                    </div>
                    <div class="col-md-10">
                        <!--type="text" und nicht password, da Validierung serverside. Beim Erstellen sollte man das Passwort sehen könnenb.-->
                        <input type="text" class="form-control <?= session('errors.Passwort') ? 'is-invalid' : '' ?>"
                               id="Passwort" name="Passwort" placeholder="Passwort für die Person"
                               value="<?= old('Passwort', $selected_person['passwort'] ?? '') ?>"
                               <?php if ($todo == "delete"): ?>disabled<?php endif; ?>>
                        <?php if (session('errors.Passwort')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Passwort')) ?>
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
                <a href="<?= base_url('public/personen') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
