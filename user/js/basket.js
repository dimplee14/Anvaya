const modal = document.getElementById('confirmModal');
const modalYes = document.getElementById('modalYes');
const modalNo = document.getElementById('modalNo');


// New: Confirm order for a specific order ID
function confirmOrderForOrderId(orderId, btn) {
    const form = btn.closest('.clientForm');
    const address = form.querySelector('.deliveryAddress').value.trim();
    let errorMsg = "";
    if(!address) errorMsg += "Delivery Address is required.\n";
    if(errorMsg) {
        showSuccessMessage(errorMsg, true);
        return;
    }
    // Send address and order_id to server via AJAX
    fetch('update_delivery_address.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'address=' + encodeURIComponent(address) + '&order_id=' + encodeURIComponent(orderId)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            showSuccessMessage("✅ Address saved! Order Confirmed! Admin will update further status.");
        } else {
            showSuccessMessage(data.message || "Failed to save address. Try again.", true);
        }
    })
    .catch(() => showSuccessMessage("Error saving address.", true));
}

// When user clicks Yes
modalYes.onclick = function() {
    modal.style.display = "none";
    // Mark only Order Received & Confirmed
    document.getElementById('status-received').classList.add('active');
    document.getElementById('status-confirmed').classList.add('active');
    // Show small success message in page
    showSuccessMessage("✅ Order Confirmed! Admin will update further status.");
}

function showSuccessMessage(msg, isError = false) {
    const el = document.getElementById('successMessage');
    el.innerText = msg;
    el.style.display = 'block';
    el.style.color = isError ? '#dc3545' : '#28a745';
    setTimeout(() => {
        el.style.display = 'none';
    }, isError ? 3500 : 4000);
}

// When user clicks No
modalNo.onclick = function() {
    modal.style.display = "none";
}

// Close modal if user clicks outside the box
window.onclick = function(event) {
    if(event.target == modal){
        modal.style.display = "none";
    }
}

// Optional: success message instead of alert
function showSuccessMessage(msg){
    let existing = document.getElementById('successMessage');
    if(existing) existing.remove();

    const div = document.createElement('div');
    div.id = 'successMessage';
    div.innerText = msg;
    div.style.position = 'fixed';
    div.style.top = '20px';
    div.style.right = '20px';
    div.style.backgroundColor = '#28a745';
    div.style.color = '#fff';
    div.style.padding = '15px 25px';
    div.style.borderRadius = '8px';
    div.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
    div.style.zIndex = 1000;
    document.body.appendChild(div);

    setTimeout(() => {
        div.remove();
    }, 3000);
}
