</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const colSel     = document.getElementById('search-column');
  const textWrap   = document.getElementById('text-input-wrapper');
  const statusWrap = document.getElementById('status-select-wrapper');
  const regionWrap = document.getElementById('region-select-wrapper');

  function toggleInputs() {
    const col = colSel.value;
    textWrap.classList.toggle('d-none',   col==='status' || col==='region');
    statusWrap.classList.toggle('d-none', col!=='status');
    regionWrap.classList.toggle('d-none', col!=='region');
  }

  // Initialize
  toggleInputs();

  // On column change, reset values
  colSel.addEventListener('change', () => {
    document.getElementById('text-input').value = '';
    document.getElementById('status-select').value = '';

    // Uncheck all region checkboxes
    document.querySelectorAll('.region-checkbox')
      .forEach(cb => cb.checked = false);
    // Clear hidden inputs
    document.getElementById('region-inputs').innerHTML = '';

    toggleInputs();
  });

  // Whenever a region checkbox toggles, sync hidden inputs
  document.querySelectorAll('.region-checkbox').forEach(cb => {
    cb.addEventListener('change', syncRegionInputs);
  });

  function syncRegionInputs() {
    const container = document.getElementById('region-inputs');
    container.innerHTML = ''; // clear
    document.querySelectorAll('.region-checkbox:checked').forEach(cb => {
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'value[]';
      inp.value = cb.value;
      container.appendChild(inp);
    });
  }
});
</script>

</body>

</html>