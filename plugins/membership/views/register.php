<form class="form-signin" method="post">
    <h2 class="form-signin-heading"><?php echo TITLE; ?></h2>

    <div class="login-wrap">

        <div class="form-group">
            <input name="email" autofocus="true" required="true" type="email" class="form-control" placeholder="Email" />

        </div>

        <?php HTML::textfield('username', 'form-control', NULL, ['placeholder' => 'Username', 'required' => null]); ?>

        <input name="password" required="true" type="password" class="form-control" placeholder="Password" />

        <input name="repeat_password" required="true" type="password" class="form-control" placeholder="Repeat Password" />




        <?php HTML::textfield('first_name', 'form-control', '', ['required' => null, 'placeholder' => 'First Name']); ?>

        <?php HTML::textfield('last_name', 'form-control', '', ['required' => null, 'placeholder' => 'Last Name']); ?>

        <p>Registration requires approval from administrator! You will not be able to access the webpage immediately.</p>
        <button class="btn btn-lg btn-login btn-block" type="submit" value="login">Register</button>
        <i> <a href="<?php echo URL::abs('login'); ?>">&#8592; Back to login page</a> </i>
    </div>


</form>