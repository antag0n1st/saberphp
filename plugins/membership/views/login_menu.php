<div>
<?php if (!Membership::instance()->user->id): /* @var $user User */ /* @var $membership Membership */ ?>   

    <div>
                             
    <script type="text/javascript">
        //<![CDATA[
        document.write('<a href="<?php echo URL::abs('membership/login/facebook?redirect_url=' . urlencode(Membership::instance()->getCurrentUrl())); ?>" id="loginButton" style="cursor: pointer; padding: 5px 8px 2px 8px;" > Најава со Facebook </a>');
        //]]>
    </script>
    | <a href="#"  onclick="return show_anonymous_login();" ><input  type="button" class="buttonBlue" value="Анонимно" /></a>
    </div>
<?php else: ?>  
    <div style="">
        <span style="margin-top: 7px;font-size: 18px;"><?php echo Membership::instance()->user->username; ?></span>
        <img style="width: 22px; height: 22px; margin: 2px 5px 0px 5px; " alt="<?php echo Membership::instance()->user->username; ?>" src="<?php echo Membership::instance()->user->image_url; ?>" />
        
        <a style="" href="<?php echo URL::abs('membership/logout'); ?>"><input type="button" class="buttonBlue" value="Одјави Се" /></a>
    </div>


    
                                  
<?php endif; ?>
    </div>
<?php if(!Membership::instance()->user->id): ?>    
    <div id="anonymous-login-panel" class="great-white">

            <div class="anonymous-login-panel" >

                <h2>Анонимна Најава</h2>

                <form style="margin-top: 10px;" action="<?php echo URL::abs('membership/login-anonymous'); ?>" method="post" onsubmit="return validate_anonymous_login();" >
                    <div>
                    <span>Изберете Име:</span> <input id="user-name" name="user-name" type="text" style="width: 160px;margin-bottom: 10px;" />
                    <br />
                    <span>Изберете Аватар:</span>
                    <select name="select-image" id="select-image" style="width:200px;margin-bottom: 10px;" >
                        <option value="maria-sharapova"  title="<?php echo URL::image('../plugins/membership/images/maria-sharapova.jpg'); ?>" selected="selected">Maria Sharapova</option>
                        <option value="michael-phelps" title="<?php echo URL::image('../plugins/membership/images/michael-phelps.jpg'); ?>">Michael Phelps</option>
                        <option value="marion-jones" title="<?php echo URL::image('../plugins/membership/images/marion-jones.jpg'); ?>">Merion Jones</option>
                        <option value="roger-federer" title="<?php echo URL::image('../plugins/membership/images/roger-federer.jpg'); ?>">Roger Federer</option>
                        <option value="bruce-lee" title="<?php echo URL::image('../plugins/membership/images/bruce-lee.jpg'); ?>">Bruce Lee</option>

                    </select>
                    <br />
                    <input type="submit" value="Најави Се" class="buttonBlue" />
                    <input id="cancel-login" type="button" value="Откажи" class="buttonRed" />
                    </div>
                </form>

            </div>

        </div>
<?php endif; ?>

