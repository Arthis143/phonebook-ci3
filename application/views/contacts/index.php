<!-- Search & Sort Form -->
<form method="get" class="row g-2 mb-4" id="search-form">
  <div class="col-auto">
    <select name="column" id="search-column" class="form-select form-select-sm">
      <option value="">-- Search Column --</option>
      <option value="name" <?= $column === 'name' ? 'selected' : '' ?>>Name</option>
      <option value="phone" <?= $column === 'phone' ? 'selected' : '' ?>>Phone</option>
      <option value="status" <?= $column === 'status' ? 'selected' : '' ?>>Status</option>
      <option value="region" <?= $column === 'region' ? 'selected' : '' ?>>Region</option>
    </select>
  </div>

  <!-- Text input for name/phone -->
  <div class="col-auto" id="text-input-wrapper">
    <input type="text" name="value" id="text-input" class="form-control form-control-sm" placeholder="Search term"
      value="<?= htmlspecialchars(is_array($value) ? '' : $value) ?>">
  </div>

  <!-- Dropdown for status (single select) -->
  <div class="col-auto d-none" id="status-select-wrapper">
    <select name="value" id="status-select" class="form-select form-select-sm">
      <option value="">-- Select Status --</option>
      <option value="active" <?= $value === 'active' ? 'selected' : '' ?>>Active</option>
      <option value="inactive" <?= $value === 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
  </div>

  <!-- Dropdown for region (multi‐select via checkboxes) -->
  <div class="col-auto d-none" id="region-select-wrapper">
    <div class="dropdown">
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="regionDropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        Region
      </button>
      <ul class="dropdown-menu p-2" aria-labelledby="regionDropdown" style="min-width:200px;">
        <?php foreach (['east coast', 'central', 'north', 'south', 'west coast', 'east malaysia'] as $r): ?>
          <li class="form-check">
            <input class="form-check-input region-checkbox" type="checkbox" value="<?= $r ?>"
              id="region-<?= str_replace(' ', '-', $r) ?>" <?= (is_array($value) && in_array($r, $value, TRUE)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="region-<?= str_replace(' ', '-', $r) ?>">
              <?= ucwords($r) ?>
            </label>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <!-- hidden inputs to POST the selected regions -->
    <div id="region-inputs"></div>
  </div>


  <div class="col-auto">
    <select name="sort" class="form-select form-select-sm">
      <option value="latest" <?= $sort === 'latest' ? 'selected' : '' ?>>Newest</option>
      <option value="earliest" <?= $sort === 'earliest' ? 'selected' : '' ?>>Oldest</option>
      <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name</option>
    </select>
  </div>
  <div class="col-auto">
    <select name="dir" class="form-select form-select-sm">
      <option value="asc" <?= $dir === 'asc' ? 'selected' : '' ?>>Asc</option>
      <option value="desc" <?= $dir === 'desc' ? 'selected' : '' ?>>Desc</option>
    </select>
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
  </div>
</form>


<!-- Bulk Delete & Add Buttons -->
<form id="bulk-delete-form" method="post" action="<?= site_url('contacts/bulk_delete') ?>">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <button type="submit" class="btn btn-danger btn-sm me-2" onclick="return confirm('Delete selected contacts?')"
        id="btn-delete-selected" disabled>
        Delete Selected
      </button>
      <a href="<?= site_url('contacts/create') ?>" class="btn btn-primary btn-sm">
        + Add New
      </a>
    </div>
  </div>

  <!-- Contacts Table -->
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th><input type="checkbox" id="select-all"></th>
          <th>#</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Region</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contacts as $c): ?>
          <tr>
            <td><input type="checkbox" name="selected[]" value="<?= $c->id ?>" class="row-checkbox"></td>
            <td><?= $c->id ?></td>
            <td>
              <a href="<?= site_url('contacts/edit/' . $c->id) ?>" class="text-decoration-none">
                <?= htmlspecialchars($c->name, ENT_QUOTES) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($c->phone, ENT_QUOTES) ?></td>
            <td>
              <span class="badge <?= $c->status === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                <?= ucfirst($c->status) ?>
              </span>
            </td>
            <td><?= ucwords(htmlspecialchars($c->region, ENT_QUOTES)) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</form>