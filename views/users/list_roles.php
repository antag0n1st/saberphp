<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3 class="">List of Roles</h3>
                
            </header>
            <div class="panel-body">
                
                <a href="<?php echo URL::abs('users/add-role'); ?>" class="btn btn-send pull-right">
                    <i class="fa fa-plus"></i> Add
                </a>
                
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>                             
                            <th>Description</th>
                            <th style="width: 160pt;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($roles as $role) : /* @var $role Role */ ?>

                            <tr>
                                <td><?php echo $role->id; ?></td>
                              
                                <td><?php echo $role->name; ?></td>
                                <td><?php echo $role->description; ?></td>
                                <td>
                                    
                                    <a href="<?php echo URL::abs('users/assign-permissions/'.$role->id); ?>" class="btn btn-success btn-xs">
                                        <i class="fa fa-key"></i>  permissions
                                    </a>

                                    <a href="<?php echo URL::abs('users/edit-role/'.$role->id); ?>" class="btn btn-info btn-xs">
                                        edit
                                    </a>
                                    
                                    <a onclick="return confirm('Are you sure ?');" href="<?php echo URL::abs('users/delete-role/'.$role->id); ?>" class="btn btn-danger btn-xs">
                                        delete
                                    </a>
                                    
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

