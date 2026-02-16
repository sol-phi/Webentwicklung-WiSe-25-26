<div class="container mt-4 mb-4">
    <div class="card blue-gradient-boards-card">
        <div class="card-header fs-4 fw-semibold blue-gradient-boards-header">
            <?php if ($todo == "create"): ?>
                <span>Taskart erstellen</span>
            <?php elseif ($todo == "update"): ?>
                <span>Taskart bearbeiten</span>
            <?php elseif ($todo == "delete"): ?>
                <span>Taskart löschen</span>
            <?php elseif ($todo == "copy"): ?>
                <span>Taskart kopieren</span>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <form method="POST"
                  action="<?= base_url('public/taskarten-erstellen/submit/' . $todo . ($todo != 'create' ? '/' . $selected_taskart['id'] : '')) ?>">

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="Taskart" class="col-form-label">Bezeichnung</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control <?= session('errors.Taskart') ? 'is-invalid' : '' ?>"
                               id="Taskart" name="Taskart" placeholder="Bezeichnung der Taskart"
                               value="<?= old('Taskart', $selected_taskart['taskart'] ?? '') ?>"
                            <?= $todo == "delete" ? 'disabled' : '' ?>>
                        <?php if (session('errors.Taskart')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.Taskart')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-2">
                        <label for="TaskartenIcon" class="col-form-label">Icon (FontAwesome)</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control <?= session('errors.TaskartenIcon') ? 'is-invalid' : '' ?>"
                               id="TaskartenIcon" name="TaskartenIcon" placeholder="z.B. fa-solid fa-code"
                               value="<?= old('TaskartenIcon', $selected_taskart['taskartenicon'] ?? '') ?>"
                            <?= $todo == "delete" ? 'disabled' : '' ?>>
                        <small class="text-muted">Geben Sie die komplette FontAwesome Klasse an.</small>
                        <?php if (session('errors.TaskartenIcon')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.TaskartenIcon')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($todo == "delete"): ?>
                    <div class="alert alert-warning">
                        Möchten Sie diese Taskart wirklich löschen? (Dazugehörige Tasks werden dabei gelöscht!)
                    </div>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-success">Speichern</button>
                <?php endif; ?>

                <a href="<?= base_url('public/taskarten') ?>" class="btn btn-secondary">Abbrechen</a>
            </form>
        </div>
    </div>
</div>
