<?php // expects optional $contact object and CI validation_errors() ?>
<div class="card mb-4">
    <div class="card-header bg-light">
        <h2><?= isset($contact) ? 'Edit' : 'Add' ?> Contact</h2>
    </div>
    <div class="card-body">
        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required
                    value="<?= set_value('name', isset($contact) ? $contact->name : '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required
                    value="<?= set_value('phone', isset($contact) ? $contact->phone : '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= set_select('status', 'active', isset($contact) && $contact->status === 'active') ?>>Active</option>
                    <option value="inactive" <?= set_select('status', 'inactive', isset($contact) && $contact->status === 'inactive') ?>>Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Region</label>
                <select name="region" class="form-select" required>
                    <?php
                    $regions = [
                        'east coast',
                        'central',
                        'north',
                        'south',
                        'west coast',
                        'east malaysia'
                    ];
                    foreach ($regions as $r):
                        ?>
                        <option value="<?= $r ?>" <?= set_select('region', $r, isset($contact) && $contact->region === $r) ?>>
                            <?= ucwords($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($contact) ? 'Update' : 'Save' ?></button>
            <a href="<?= site_url('contacts') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>