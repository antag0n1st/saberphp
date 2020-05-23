<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3 class="">List of Permissions</h3>
                
            </header>
            <div class="panel-body">
                                
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th> 
                            <th>Description</th> 
                        </tr>
                    </thead>
                    <tbody>

                        <?php  foreach ($permissions as $permission) :  ?>

                            <tr>                              
                                <td><?php echo $permission->id; ?></td>                                
                                 <td><?php echo $permission->name; ?></td>                                 
                                 <td><?php echo $permission->description; ?></td>                                
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

