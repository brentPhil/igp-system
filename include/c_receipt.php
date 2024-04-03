<!-- Modal -->
<div class="modal fade" id="c_receipt<?php echo ($row["billing_id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" id="payment">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Concessionaire's Receipt</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mt-2 text-center">
                        <?php
                        if(empty($row['c_receipt'])) {
                            echo "No Receipt Submitted.\n";
                        } else {
                            echo '<a href="receipts/'.$row['c_receipt'].'" target="_blank"><img src="receipts/'.$row['c_receipt'].'" width="100%" alt=".jpg file"></a>';
                            echo '<br>';
                            echo '<h4>Amount Paid: ₱ '.number_format($row['amount_paid'], 2).'</h4>';
                        }
                        ?>
                    </p>
                    <input type="hidden" name="billing_id" value="<?php echo ($row["billing_id"]); ?>">
                </div>
                <div class="modal-footer">
                    <button <?php echo $row['c_receipt'] && $row['status'] == 0 ? '' : 'disabled'?> class="btn btn-<?php echo $row['c_receipt'] && $row['status'] == 0 ? 'success' : 'secondary'?> w-100" type="submit" name="pay">Approve Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>