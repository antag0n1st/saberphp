
    <form method="post">
        
        
        <div class="table">
            Requirements:
            <ul>
                <li>Username must be at least 6 characters long</li>
                <li>Password must be at least 6 characters long</li>
                <li>Password must not contain the username in it</li>
            </ul>
            
        </div>

        <div class="details1">
            <div class="collum1 text">
                username:<br />
                password:<br />
                password:<br /><br />
                email: <br />
                full name: <br />
            </div>

            <div class="collum2">
                <?php HTML::textfield('username', 'input-text'); ?> <br />
                <?php HTML::textfield('pass', '', '', array(), false, '', 'password'); ?> <br />
                <?php HTML::textfield('rpass', '', '', array(), false, '', 'password'); ?> <br /><br />
                <?php HTML::textfield('email', 'input-text'); ?> <br />
                <?php HTML::textfield('full_name', 'input-text'); ?> <br />

                <input type="submit" value="register" />
            </div>
        </div>

    </form>

