<?php 
/* @var $role Role */
$role = isset($role) ? $role : new Role();

?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Role
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" name="form" method="post" >

                    <div class="form-group">
                        <label for="" class="col-lg-2 col-sm-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield('name', 'form-control','', ['autofocus' => null], false, $role->name); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-lg-2 col-sm-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <?php HTML::textarea('description', 'form-control', '', [], false, $role->description); ?>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="" class="col-lg-2 col-sm-2 control-label"></label>
                        <div class="col-lg-10">
                            <input type="submit" class="btn btn-send" value="Save" /> 
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
