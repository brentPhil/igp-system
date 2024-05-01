<!-- Bootstrap Modal -->
<div class="modal fade" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment details</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically populated here -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalContent = document.querySelector('#balanceModal .modal-body');
        const modal = new bootstrap.Modal(document.getElementById('balanceModal'));

        // Function to populate modal content
        function populateModalContent(data) {
            modalContent.innerHTML = `
                <h3>${data.tenant_name}</h3>
                <h4>${data.stall_name}</h4>
                <h4>${data.date_filed}</h4>
                <div class="py-2 border-secondary my-3">
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Monthly Rent</span><span>₱ ${data.rent_bal}</span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Water</span><span>₱ ${data.water_bal}</span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Electricity</span><span>₱ ${data.electricity_bal}</span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Other</span><span>₱ ${data.other_bal}</span></div>
                    <div class="d-flex justify-content-between py-3 font-weight-bold"><span>Total</span><span>₱ ${data.amount}</span></div>
                </div>
                <p><b>Note:</b> ${data.billing_note}</p>
            `;
            modal.show();
        }

        // Event listener for view payment details button
        const viewButtons = document.querySelectorAll('.view-payment-details');
        viewButtons.forEach(button => {
            button.addEventListener('click', function () {
                const billingId = this.dataset.billingId;
                // Send AJAX request to get payment details
                fetch(`get_billing_details.php?billing_id=${billingId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Populate modal content with payment details
                        populateModalContent(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Handle error (e.g., show error message to user)
                    });
            });
        });
    });

  </script>