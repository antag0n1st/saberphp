<form method="post">

    <?php if (isset($_POST) and $_POST): ?>

        <div class="table">
            Please check your email for a link that will help you reset your password.
        </div>

    <?php else: ?>

        <div class="table">
            This will send you a link to reset the password
        </div>

        <div class="details1">
            <div class="collum1 text">
                email:
            </div>

            <div class="collum2">
                <?php HTML::textfield('email', 'input-text'); ?> <br />

                <input type="submit" value="send" />
            </div>
        </div>

    <?php endif; ?>

</form>