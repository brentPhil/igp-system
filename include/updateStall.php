    <!-- Modal -->
    <div class="modal fade" id="editStall<?php echo ($row['stall_id']);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stall</h5>
                </div>
                <form action="" method="POST" id="stallUpdate">
                  <div class="modal-body">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stall Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="stall_id" value="<?php echo $row['stall_id'];?>">
                          <input type="text" name="stall_name" value="<?php echo $row['stall_name'];?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stall Price</label>
                        <div class="col-sm-9">
                          <input type="text" name="stall_price" value="<?php echo $row['stall_price'];?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                          <input type="text" name="stall_desc" value="<?php echo $row['stall_desc'];?>" class="form-control" />
                        </div>
                    </div>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" name="s_update" form="stallUpdate" type="submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>