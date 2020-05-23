<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3 class="">List of Users</h3>

            </header>
            <div class="panel-body">

                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Role</th>     
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Created At</th>
                            <th>Last Login</th>
                            <th class="text-center">Number of Logins</th>
                            <th style="width: 140pt;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($users as $user) : /* @var $user User */ ?>

                            <tr>
                                <td><?php echo $user->user_id; ?></td>
                                <td><?php echo $user->username; ?></td>
                                <td>
                                    <?php if (Membership::instance()->user->user_id != $user->user_id): ?>


                                        <div class="btn-group">

                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">                                
                                                <?php echo Role::match($user->role_id, $roles); ?> <span class="caret"></span>
                                            </button>

                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="<?php echo URL::abs('users/change-role/0/' . $user->user_id); ?>"> NONE </a></li>
                                                <?php foreach ($roles as $role) : /* @var $role Role */ ?>
                                                    <li><a href="<?php echo URL::abs('users/change-role/' . $role->id . '/' . $user->user_id); ?>"><?php echo $role->name; ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>

                                        </div>                    

                                    <?php else: ?>
                                        <i class="fa fa-user"></i> <?php echo Role::match(Membership::instance()->user->role_id, $roles); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $user->email; ?></td>
                                <td class="text-center"><?php echo $user->full_name; ?></td>
                                <td><?php echo TimeHelper::to_date($user->created_at, 'd M. Y H:i'); ?></td>
                                <td><?php echo TimeHelper::RelativeTime($user->last_logged_at); ?></td>
                                <td class="text-center"><?php echo $user->login_count; ?></td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="<?php echo URL::abs('users/kick-out/' . $user->user_id); ?>">
                                        <i class="fa fa-bolt"></i> Kick
                                    </a>

                                    <?php if (Membership::instance()->user->user_id != $user->user_id): ?>
                                        <a onclick="return confirm('Are you sure ?');" href="<?php echo URL::abs('users/delete/' . $user->user_id); ?>" class="btn btn-danger btn-xs">
                                            delete
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
        </section>
    </div>
</div>
