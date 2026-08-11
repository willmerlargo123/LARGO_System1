/**
 * Fetches employee data from the Microservice System (System 2)
 * running on port 81, and populates a <select> dropdown with it.
 *
 * This is the core "system integration" requirement: the Main
 * System's CREATE and UPDATE forms pull their dropdown options
 * live from the Microservice's JSON API.
 *
 * @param {string} selectId       id of the <select> element to fill
 * @param {string} hiddenNameId   id of the hidden input that stores the selected staff's name
 * @param {number|null} preselectId  employee_id to pre-select (used on the Update form)
 */
function loadStaffDropdown(selectId, hiddenNameId, preselectId = null) {
  // The microservice is exposed on port 81 on the host machine.
  // If the page is loaded on a different hostname, that same
  // hostname is reused so this also works in staging/prod.
  const apiUrl = `${window.location.protocol}//${window.location.hostname}:81/api.php`;

  const select = document.getElementById(selectId);
  const hiddenName = document.getElementById(hiddenNameId);

  fetch(apiUrl)
    .then(res => {
      if (!res.ok) throw new Error(`API responded with status ${res.status}`);
      return res.json();
    })
    .then(json => {
      if (!json.success) throw new Error(json.error || 'Unknown API error');

      select.innerHTML = '<option value="">-- Select Staff --</option>';

      json.data.forEach(emp => {
        const opt = document.createElement('option');
        opt.value = emp.employee_id;
        opt.textContent = `${emp.full_name} (${emp.position})`;
        opt.dataset.name = emp.full_name;
        if (preselectId && parseInt(emp.employee_id) === parseInt(preselectId)) {
          opt.selected = true;
        }
        select.appendChild(opt);
      });

      // Keep the hidden "assigned_staff_name" input in sync
      updateHiddenName();
    })
    .catch(err => {
      console.error('Failed to load employees from microservice:', err);
      select.innerHTML = '<option value="">⚠ Could not load staff list</option>';
    });

  function updateHiddenName() {
    const opt = select.options[select.selectedIndex];
    hiddenName.value = opt && opt.dataset.name ? opt.dataset.name : '';
  }

  select.addEventListener('change', updateHiddenName);
}
