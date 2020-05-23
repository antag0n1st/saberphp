<form method="post">

    <?php if (isset($_POST) and $_POST and !isset($_POST['_error'])): ?>

        <div class="table">
            Please try to login now with your new password
        </div>

    <?php else: ?>

        <div class="table">
            Set your new password
        </div>

        <div class="details1">
            <div class="collum1 text">
                password:<br />
                repeat password
            </div>

            <div class="collum2">
                <?php HTML::textfield('pass', '', '', array(), false, '', 'password'); ?> <br />
                <?php HTML::textfield('rpass', '', '', array(), false, '', 'password'); ?> <br /><br />

                <input type="submit" value="reset" />
            </div>
        </div>

    <?php endif; ?>

</form>