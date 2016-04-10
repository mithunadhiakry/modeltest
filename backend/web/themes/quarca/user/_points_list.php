<?php
        if(isset($packages_info)){
    ?>

        <table class="table table-striped table-bordered">
            <tr>
                <th>Package</th>
                <th>Expire Date</th>
                <th>Points Remaining</th>
            </tr>
            <?php
                if(!empty($packages_info)){
                    foreach ($packages_info as $package) {
            ?>

                <tr>
                    <td><?= $package->package_name; ?></td>
                    <td><?= $package->expired_date; ?></td>
                    <td><?= $package->points; ?></td>
                </tr>

            <?php
                    }
                }
            ?>
            <tr>
                <td>Free</td>
                <td>N/A</td>
                <td><?= $model->free_point; ?></td>
            </tr>
        </table>

    <?php
        }
    ?>

<div class="col-md-12">
    <div class="col-md-3">
        <div class="row">
            <input type="text" name="point" id="point" class="form-control" placeholder="Points">
            <input type="hidden" name="user_id" id="user_id" value="<?= $model->id; ?>" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
            <input style="height:39px;" type="button" name="button" class="btn btn-sm btn-primary send_point_btn" value="Send"> 
    </div>
</div>