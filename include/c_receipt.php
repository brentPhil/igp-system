<!-- Modal -->
<!-- PHP/HTML code -->
<div class="modal fade" id="c_receiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Concessionaire's Receipt</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="payment">
                <div class="modal-body">
                    <div class="mt-2 text-center" id="receiptContent"></div>
                    <input type="hidden" id="billingIdInput" name="billing_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary w-100" id="approvePaymentBtn" type="submit" name="pay" disabled>Approve Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript code
document.addEventListener('DOMContentLoaded', function () {
    const modalContent = document.getElementById('receiptContent');
    const approvePaymentBtn = document.getElementById('approvePaymentBtn');
    const billingIdInput = document.getElementById('billingIdInput'); // Hidden input for billing ID
    const modal = new bootstrap.Modal(document.getElementById('c_receiptModal'));

    // Event listener for view receipt button
    const viewButtons = document.querySelectorAll('.view-receipt');
    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const billingId = this.dataset.billingId;
            billingIdInput.value = billingId;
            // Send AJAX request to get receipt details
            fetch(`get_billing_details.php?billing_id=${billingId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal content with receipt details
                    if (data.c_receipt) {
                        modalContent.innerHTML = `
                            <a href="receipts/${data.c_receipt}" target="_blank"><img src="receipts/${data.c_receipt}" width="100%" alt=".jpg file"></a>
                            <br>
                            <br>
                            <h4>Amount Paid: ₱ ${data.amount_paid}</h4>
                        `;
                        
                        if (data.status !== '1'){
                            approvePaymentBtn.disabled = false;
                            approvePaymentBtn.classList.remove('btn-secondary');
                            approvePaymentBtn.classList.add('btn-success');
                        } else {
                            approvePaymentBtn.classList.remove('btn-secondary');
                            approvePaymentBtn.classList.add('btn-primary');
                            approvePaymentBtn.textContent = 'Payment Approved';
                        }

                    } else {
                        modalContent.textContent = 'No Receipt Submitted.';
                    }

                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});

</script>