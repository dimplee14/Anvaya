// order_register.js - Handles UI interactions for order register page
// Placeholder for loading orders and handling approve/reject actions

document.addEventListener('DOMContentLoaded', function () {
  // Search and filter logic
  var searchInput = document.getElementById('orderSearchInput');
  var searchClear = document.getElementById('orderSearchClear');
  var statusFilter = document.getElementById('orderStatusFilter');
  var designerAssignedFilter = document.getElementById('designerAssignedFilter');
  var tbody = document.getElementById('orderTableBody');

  function filterOrders() {
    if (!tbody) return;
    var searchVal = searchInput.value.toLowerCase();
    var statusVal = statusFilter.value;
    var designerAssignedVal = designerAssignedFilter ? designerAssignedFilter.value : '';
    Array.from(tbody.rows).forEach(function (row) {
      var name = row.children[1].textContent.toLowerCase();
      var phone = row.children[2].textContent.toLowerCase();
      var designerCell = row.children[3];
      var designerRaw = designerCell.innerHTML.trim();
      var designerText = designerCell.textContent.trim();
      var status = row.children[4].textContent.trim();
      var matchesSearch = name.includes(searchVal) || phone.includes(searchVal) || designerText.toLowerCase().includes(searchVal) || status.toLowerCase().includes(searchVal);
      var matchesStatus = !statusVal || status === statusVal;
      var matchesDesignerAssigned = true;
      // Consider assigned if not empty, not dash, not HTML entity
      var notAssignedValues = ['', '—', '&mdash;'];
      var isAssigned = !(notAssignedValues.includes(designerText) || notAssignedValues.includes(designerRaw));
      if (designerAssignedVal === 'assigned') {
        matchesDesignerAssigned = isAssigned;
      } else if (designerAssignedVal === 'not-assigned') {
        matchesDesignerAssigned = !isAssigned;
      }
      row.style.display = (matchesSearch && matchesStatus && matchesDesignerAssigned) ? '' : 'none';
    });
  }
  if (searchInput) searchInput.addEventListener('input', filterOrders);
  if (searchClear) searchClear.addEventListener('click', function () { searchInput.value = ''; filterOrders(); });
  if (statusFilter) statusFilter.addEventListener('change', filterOrders);
  if (designerAssignedFilter) designerAssignedFilter.addEventListener('change', filterOrders);
  // Initial filter
  filterOrders();
  // Attach click event to all view buttons
  if (tbody) {
    Array.from(tbody.querySelectorAll('.view-btn')).forEach(function (btn) {
      btn.addEventListener('click', function () {
        const orderId = btn.getAttribute('data-order-id');
        showOrderDetails(orderId);
      });
    });
  }

  // Approve button in view modal
  document.getElementById('approveBtn').addEventListener('click', function () {
    var orderId = document.getElementById('orderViewModal').getAttribute('data-order-id');
    // Close the first popup
    var viewModal = bootstrap.Modal.getInstance(document.getElementById('orderViewModal'));
    if (viewModal) viewModal.hide();
    // Show final approval modal
    var finalModal = new bootstrap.Modal(document.getElementById('finalApproveModal'));
    setTimeout(function () { finalModal.show(); }, 300); // Wait for previous modal to close
  });

  // Reject button in view modal
  document.getElementById('rejectBtn').addEventListener('click', function () {
    var orderId = document.getElementById('orderViewModal').getAttribute('data-order-id');
    var row = document.querySelector('.view-btn[data-order-id="' + orderId + '"]').closest('tr');
    var statusCell = row.children[4];
    statusCell.innerHTML = '<span class="badge bg-danger">Rejected</span>';
    var modal = bootstrap.Modal.getInstance(document.getElementById('orderViewModal'));
    modal.hide();
  });

  // Assign Designer button in view modal
  document.getElementById('assignDesignerBtn').addEventListener('click', function () {
    var designerDropdown = document.getElementById('designerDropdown');
    var selectedDesignerId = designerDropdown.value;
    if (!selectedDesignerId) {
      alert('Please select a designer.');
      return;
    }
    var orderId = document.getElementById('orderViewModal').getAttribute('data-order-id');
    var formData = new FormData();
    formData.append('orderId', orderId);
    formData.append('designerId', selectedDesignerId);
    fetch('../php/process_assign_designer.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          var row = document.querySelector('.view-btn[data-order-id="' + orderId + '"]').closest('tr');
          var designerCell = row.children[3];
          designerCell.innerHTML = data.designerName || 'Assigned';
          designerDropdown.value = '';
          // Update the designer in the modal details if present
          var modalBody = document.getElementById('order-modal-body');
          if (modalBody) {
            var strongs = modalBody.querySelectorAll('div strong');
            strongs.forEach(function (strong) {
              if (strong.textContent.trim() === 'Designer:') {
                if (strong.nextSibling && strong.nextSibling.nodeType === Node.TEXT_NODE) {
                  strong.nextSibling.textContent = ' ' + (data.designerName || 'Assigned');
                } else if (strong.parentNode) {
                  // If not a text node, try to update the parent
                  var textNode = document.createTextNode(' ' + (data.designerName || 'Assigned'));
                  strong.parentNode.appendChild(textNode);
                }
              }
            });
          }
          alert('Designer assigned successfully.');
        } else {
          alert('Error: ' + (data.error || 'Could not assign designer.'));
        }
      })
      .catch(err => {
        alert('AJAX error: ' + err);
      });
  });

  // Final approval form submit
  document.getElementById('finalApprovalForm').addEventListener('submit', function (e) {
    e.preventDefault();
    var preferenceId = document.getElementById('orderViewModal').getAttribute('data-order-id');
    var finalStyle = document.getElementById('finalStyle').value;
    var finalMeasurement = document.getElementById('finalMeasurement').value;
    var finalPrice = document.getElementById('finalPrice').value;
    var expectedDeliveryDate = document.getElementById('expectedDeliveryDate').value;

    var formData = new FormData();
    formData.append('preferenceId', preferenceId);
    formData.append('finalStyle', finalStyle);
    formData.append('finalMeasurement', finalMeasurement);
    formData.append('finalPrice', finalPrice);
    formData.append('expectedDeliveryDate', expectedDeliveryDate);

    fetch('../php/process_final_approval.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          var row = document.querySelector('.view-btn[data-order-id="' + preferenceId + '"]').closest('tr');
          var statusCell = row.children[4];
          statusCell.innerHTML = '<span class="badge bg-success">Approved</span>';
          var modal = bootstrap.Modal.getInstance(document.getElementById('finalApproveModal'));
          modal.hide();
          alert('Final approval submitted successfully.');
        } else {
          alert('Error: ' + (data.error || 'Could not submit final approval.'));
        }
      })
      .catch(err => {
        alert('AJAX error: ' + err);
      });
  });
});


function showOrderDetails(orderId) {
  // Find the order object from the global orders array
  var order = null;
  if (typeof orders !== 'undefined' && Array.isArray(orders)) {
    order = orders.find(function (o) { return String(o.id) === String(orderId); });
  }
  if (!order) {
    alert('Order data not found!');
    return;
  }
  var imagesHtml = Array.isArray(order.images) ? order.images.map(function (img) { return `<span class='badge bg-secondary'>${img}</span>`; }).join(' ') : '';
  // Build designer dropdown options from global designers array
  var designerOptions = '<option value="">-- Select Designer --</option>';
  if (typeof designers !== 'undefined' && Array.isArray(designers)) {
    designers.forEach(function (d) {
      designerOptions += `<option value="${d.designer_id}">${d.designer_name}</option>`;
    });
  }
  var modalHtml = `
        <div><strong>Name:</strong> ${order.name || ''}</div>
        <div><strong>Phone:</strong> ${order.phone_number || ''}</div>
        <div><strong>Designer:</strong> ${order.designer || '—'}</div>
        <div class="mb-3" id="designerDropdownContainer">
            <label for="designerDropdown" class="form-label">Assign Designer</label>
            <select class="form-select" id="designerDropdown">
                ${designerOptions}
            </select>
        </div>
        <div><strong>Status:</strong> ${order.status || ''}</div>
        <hr>
        <div><strong>Occasion:</strong> ${order.occasion || ''}</div>
        <div><strong>Style:</strong> ${order.style || ''}</div>
        <div><strong>Budget:</strong> ${order.budget || ''}</div>
        <div><strong>Selected Products:</strong> ${order.selected_products || ''}</div>
        <div><strong>Uploaded Images:</strong> ${imagesHtml}</div>
        <div><strong>Age:</strong> ${order.age || ''}</div>
        <div><strong>Height:</strong> ${order.height || ''}</div>
        <div><strong>Approximate Size:</strong> ${order.size || ''}</div>
        <div><strong>Colour Preferences:</strong> ${order.color || ''}</div>
    `;
  document.getElementById('order-modal-body').innerHTML = modalHtml;
  document.getElementById('orderViewModal').setAttribute('data-order-id', orderId);
  // Always show the modal, re-initialize if needed
  var modalEl = document.getElementById('orderViewModal');
  var modal = bootstrap.Modal.getInstance(modalEl);
  if (!modal) {
    modal = new bootstrap.Modal(modalEl);
  }
  modal.show();
}
