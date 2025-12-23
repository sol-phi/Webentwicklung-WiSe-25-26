<?php
// Datei: app/Views/pages/tasks-erstellen.php
$todo = (int) ($todo ?? 0);
$tasks = is_array($tasks) ? $tasks : []; // sicherstellen, dass $tasks definiert ist

// datetime-local benötigt Format "Y-m-d\TH:i"
$erinnerungsValue = '';
if (!empty($tasks['erinnerungsdatum'])) {
    try {
        $dt = new \DateTime($tasks['erinnerungsdatum']);
        $erinnerungsValue = $dt->format('Y-m-d\TH:i');
    } catch (\Exception $e) {
        $erinnerungsValue = '';
    }
}

switch ($todo) {
    case 1:
        $text = 'Task bearbeiten';
        break;
    case 2:
        $text = 'Task löschen';
        break;
    default:
        $text = 'Task erstellen';
}
?>
<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header fs-4"><?= esc($text) ?></div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('public/tasks/submit/' . ($tasks['id'] ?? 0) . '/' . $todo) ?>">

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Taskbezeichnung" class="col-form-label">Taskbezeichnung</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="Taskbezeichnung" name="tasks"
                               placeholder="<?= esc($tasks['tasks'] ?? 'Taskbezeichnung') ?>"
                               value="<?= esc($tasks['tasks'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="IDTaskart" class="col-form-label">ID der Task Art</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="IDTaskart" name="taskartenid"
                               placeholder="<?= esc($tasks['taskartenid'] ?? 'ID der Task Art eingeben') ?>"
                               value="<?= esc($tasks['taskartenid'] ?? '') ?>" required min="1" step="1" inputmode="numeric">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="IDPerson" class="col-form-label">ID der Person</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="IDPerson" name="personenid"
                               placeholder="<?= esc($tasks['personenid'] ?? 'ID der Person eingeben') ?>"
                               value="<?= esc($tasks['personenid'] ?? '') ?>" required min="1" step="1" inputmode="numeric">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="IDSpalte" class="col-form-label">ID der Spalte</label>
                    </div>
                    <div class="col-md-10">
                        <input type="number" class="form-control" id="IDSpalte" name="spaltenid"
                               placeholder="<?= esc($tasks['spaltenid'] ?? 'ID der Spalte eingeben') ?>"
                               value="<?= esc($tasks['spaltenid'] ?? '') ?>" required min="1" step="1" inputmode="numeric">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Erinnerungsdatum" class="col-form-label">Erinnerungsdatum</label>
                    </div>
                    <div class="col-md-10">
                        <input type="datetime-local" class="form-control" id="Erinnerungsdatum" name="erinnerungsdatum"
                               value="<?= esc($erinnerungsValue) ?>"
                               placeholder="JJJJ-MM-TT hh:mm">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Erinnerung" class="col-form-label">Erinnerung</label>
                    </div>
                    <div class="col-md-10 d-flex align-items-center">
                        <input type="hidden" name="erinnerung" value="0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="Erinnerung" name="erinnerung" value="1"
                                    <?= (($tasks['erinnerung'] ?? 0) == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="Erinnerung">Benachrichtigung aktiv</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Notizen" class="col-form-label">Notiz</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="Notizen" name="notizen" rows="4"
                                  placeholder="<?= esc($tasks['notizen'] ?? 'Notizen / Details') ?>"><?= esc($tasks['notizen'] ?? '') ?></textarea>
                    </div>
                </div>

                <input type="hidden" name="erledigt" value="<?= esc($tasks['erledigt'] ?? 0) ?>">
                <input type="hidden" name="geloescht" value="<?= esc($tasks['geloescht'] ?? 0) ?>">
                <input type="hidden" name="sortid" value="<?= esc($tasks['sortid'] ?? '100') ?>">

                <?php
                switch ($todo) {
                    case 1:
                        $textButton = 'Bearbeiten';
                        break;
                    case 2:
                        $textButton = 'Löschen';
                        break;
                    default:
                        $textButton = 'Erstellen';
                }
                ?>
                <button type="submit" class="btn btn-success"><?= esc($textButton) ?></button>
                <a href="<?= base_url('public/tasks') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>

