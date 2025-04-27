<?php
// $total, $activeCount, $inactiveCount, $latest (array of up to 5 contacts)
?>
<div class="dashboard-cards">
  <div class="dashboard-card">
    <h3>Total Contacts</h3>
    <div class="value"><?= $total ?></div>
  </div>
  <div class="dashboard-card">
    <h3>Active</h3>
    <div class="value"><?= $activeCount ?></div>
  </div>
  <div class="dashboard-card">
    <h3>Inactive</h3>
    <div class="value"><?= $inactiveCount ?></div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-light d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Latest Contacts</h4>
    <a href="<?= site_url('contacts') ?>" class="btn btn-sm btn-primary">View All</a>
  </div>
  <div class="card-body p-0">
    <?php if (empty($latest)): ?>
      <p class="p-3">No contacts yet. <a href="<?= site_url('contacts/create') ?>">Add one</a>.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr><th>#</th><th>Name</th><th>Phone</th><th>Status</th></tr>
          </thead>
          <tbody>
            <?php foreach ($latest as $c): ?>
            <tr>
              <td><?= $c->id ?></td>
              <td><?= htmlspecialchars($c->name, ENT_QUOTES) ?></td>
              <td><?= htmlspecialchars($c->phone, ENT_QUOTES) ?></td>
              <td>
                <span class="badge <?= $c->status=='active'? 'bg-success':'bg-secondary' ?>">
                  <?= ucfirst($c->status) ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
