<style type="text/css">    
    .error {
        font-family:Arial, Helvetica, sans-serif; 
        font-size:13px;
        border: 1px solid;
        margin: 10px 0px;
        padding:15px 10px 15px 50px;
        background-repeat: no-repeat;
        background-position: 10px center;
        color: #D8000C;
        background-color: #FFBABA;
        text-align: left;
    }
</style>
<div class="error" style="background-image: url('<?php echo URL::image('error.png'); ?>')">    
        <?php echo $_error_message; ?>   
</div>