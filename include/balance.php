<!-- Modal -->
<div class="modal fade" id="balance<?php echo ($row["billing_id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment details</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $i=0;
                $queryz = "SELECT * FROM tenant INNER JOIN users ON tenant.user = users.user_id WHERE tenant.stall_id = '" . $row['billing_stall'] . "'";
                $stalls = $conn->query($queryz);

                if ($stalls->num_rows > 0) {
                    $data = $stalls->fetch_assoc();?>
                    <h3><?php  echo $data["first_name"] .' '. $data["middle"] .' '. $data["last_name"]?></h3>
                    <h4><?php echo $row['stall_name'] ?></h4>
                    <h4><?php echo $datefiled ?></h4>
                <?php } else {
                    echo "No Assigned Tenants";
                }?>
                <div class="py-2 border-secondary my-3">
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Monthly Rent</span><span>₱ <?php echo number_format($row['rent_bal'], 2); ?></span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Water</span><span>₱ <?php echo number_format($row['water_bal'], 2); ?></span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Electricity</span><span>₱ <?php echo number_format($row['electricity_bal'], 2); ?></span></div>
                    <div class="d-flex justify-content-between py-2 border-secondary border-bottom"><span>Other</span><span>₱ <?php echo number_format($row['other_bal'], 2); ?></span></div>
                    <div class="d-flex justify-content-between py-3 font-weight-bold"><span>Total</span><span>₱ <?php echo number_format($row['amount'], 2); ?></span></div>
                </div>
                <p><b>Note:</b></p>
                <p>
                    <?php
                    if(empty($row['billing_note']))
                    {
                        // it's empty!
                        echo "Empty\n";
                    }
                    else
                    {
                        echo $row['billing_note'];
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>