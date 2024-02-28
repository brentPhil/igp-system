    <!-- Modal -->
    <div class="modal fade" id="uploadReceipt<?php echo ($row["billing_id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Receipt: </h5>
                </div>
                  <form action="" id="receiptSave<?php echo $row['billing_id'];?>" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Receipt</label>
                          <div class="col-sm-9">
                            <input type="hidden" name="billing_id" value="<?php echo $row['billing_id'];?>">
                            <input type="file" name="c_receipt" accept="image/jpg, image/jpeg, image/png" class="form-control" required/>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Amount Paid</label>
                          <div class="col-sm-9">
                            <input type="number" name="amount_paid" class="form-control" required/>
                          </div>
                      </div>
                    </div>
                  </form>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" type="submit" name="submit" form="receiptSave<?php echo $row['billing_id'];?>">Save</button>
                </div>
            </div>
        </div>
    </div>