<?php if(!isset($student)){ $student = new Student(); } ?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Student
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" name="form" method="post" >
                    
                    <div class="form-group">
                        <label for="counter" class="col-lg-2 col-sm-2 control-label ">counter</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield('counter', 'form-control', null, null, false, $student->counter ); ?>
                        </div>
                    </div><div class="form-group">
                        <label for="name" class="col-lg-2 col-sm-2 control-label ">name</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield('name', 'form-control', null, null, false, $student->name ); ?>
                        </div>
                    </div><div class="form-group">
                        <label for="email" class="col-lg-2 col-sm-2 control-label ">email</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield('email', 'form-control', null, null, false, $student->email ); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-send">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>



