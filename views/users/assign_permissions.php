<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3 class="">List of Permissions</h3>

            </header>
            <div class="panel-body">

                <form method="post">


                    <?php $i = 0; ?>
                    <?php foreach ($permissions as $permission) : /* @var $permission Permission */
                        ?>
                        <div class="col-lg-3 ">
                            <div class="checkbox" >
                                <label class="h4" style="padding-left: 0px;">
                                    <input value="<?php echo $permission->id; ?>" name="permissions[]" <?php echo $permission->is_assigned ? 'checked' : ''; ?> class="" type="checkbox"> <?php echo $permission->name; ?>
                                </label>
                            </div>

                            <p><?php echo $permission->description; ?></p>
                        </div>
                        <?php if (++$i % 4 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <div class="col-lg-12">
                        <input name="submit" class="btn btn-send" type="submit" value="Update Permissions" />
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>

