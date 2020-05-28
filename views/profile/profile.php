<?php 
/* @var $profile UserProfile */ 
/* @var $uploadify Uploadify */
?>
<!-- page start-->
<div class="row">
    <aside class="profile-nav col-lg-3">
        <section class="panel">
            <div class="user-heading round">
                <a href="#">
                    <div style="width: 112px;
                         height: 112px;
                         border-radius: 50%;
                         background-position: center;
                         background-size: cover;
                         background-image: url('<?php  echo $profile_image->url(); ?>');">
                    </div>
                </a>
                <h1><?php echo Membership::instance()->user->full_name; ?></h1>
                <p><?php echo Membership::instance()->user->email; ?></p>
            </div>

        </section>
    </aside>
    <aside class="profile-info col-lg-9">
        <section class="panel">
            <div class="panel-body bio-graph-info">
                <h1> Profile Info</h1>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="form" value="profile"/>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Full Name</label>
                        <div class="col-lg-6">
                            <?php HTML::textfield('full_name', 'form-control', null, [], false, Membership::instance()->user->full_name ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">E-Mail</label>
                        <div class="col-lg-6">
                            <?php HTML::textfield('email', 'form-control', null, [], false, Membership::instance()->user->email); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Birthday</label>
                        <div class="col-lg-6">
                            <?php HTML::date_picker('birthday', $profile->date_of_birth ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Phone</label>
                        <div class="col-lg-6">
                            <?php HTML::textfield('contact', 'form-control', null, [], false, $profile->contact); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Update Avatar</label>
                        <div class="col-lg-6">
                            <?php $uploadify->display('profile_image'); ?>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section>
            <div class="panel panel-primary">
                <div class="panel-heading"> Update Password</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post">
                        <input type="hidden" name="form" value="password"/>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Current Password</label>
                            <div class="col-lg-6">
                                <input name="old_password" type="password" class="form-control" id="old_password" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">New Password</label>
                            <div class="col-lg-6">
                                <input name="new_password" type="password" class="form-control" id="new_password" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Re-type New Password</label>
                            <div class="col-lg-6">
                                <input name="new_password_repeat" type="password" class="form-control" id="new_password_repeat" placeholder=" ">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </aside>
</div>

<!-- page end-->



