<!-- Update Modal -->
<div class="modal fade" id="editUserModal<?php echo $row['user_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <?php if ($row['user_type'] !== 'Faculty'): ?>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="first_name" value="<?php echo $row['first_name'];?>" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Middle</label>
                            <div class="col-sm-9">
                                <input type="text" name="middle" value="<?php echo $row['middle'];?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="last_name" value="<?php echo $row['last_name'];?>" class="form-control" required/>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id'];?>"/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" value="EVSUTC2021" name="password" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Contact #</label>
                        <div class="col-sm-9">
                            <input type="number" name="phone" value="<?php echo $row['phone'];?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" name="update" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>