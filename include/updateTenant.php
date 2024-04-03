<!-- Modal -->
<div class="modal fade" id="editTenantModal<?php echo $row['tid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Tenant</h5>
            </div>
            <form action="" method="POST" id="tenantUpdate<?php echo $row['tid'];?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Current Stall</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $row['stall_name'];?>" readonly>
                        </div>
                        <label class="col-sm-3 col-form-label">Stall Name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="tid" value="<?php echo $row['tid'];?>">
                            <input type="hidden" name="user" value="<?php echo $row['user'];?>">
                            <select class="form-control" name="sid" aria-label="Default select example" required>
                                <?php
                                $queryx = "SELECT stalls.stall_id, stalls.stall_name FROM stalls
                                LEFT JOIN users ON stalls.stall_id = users.stall_id
                                WHERE users.stall_id IS NULL
                                ORDER BY stalls.stall_name ASC";
                                $resultx = mysqli_query($conn, $queryx);
                                while ($rowz = mysqli_fetch_array($resultx)){
                                    $selected = ($rowz['stall_id'] == $row['sid']) ? 'selected' : '';
                                    $stalls = ($rowz['stall_id'] == $row['sid']) ? 'selected' : $rowz['stall_id'];
                                    echo "<option value ='{$stalls}' {$selected}>{$rowz['stall_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success" name="t_update" form="tenantUpdate<?php echo $row['tid'];?>" type="submit">Save changes</button>
            </div>
        </div>
    </div>
</div>