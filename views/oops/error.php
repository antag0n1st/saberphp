<style type="text/css">    
    .warning {
        font-family:Arial, Helvetica, sans-serif; 
        font-size:13px;
        border: 1px solid;
        margin: 10px 0px;
        padding:15px 10px 15px 50px;
        background-repeat: no-repeat;
        background-position: 10px center;
        color: #9F6000;
        background-color: #FEEFB3;
        text-align: left;
    }
</style>
<div class="warning" style="background-image: url('<?php echo URL::image('warning.png'); ?>')">   
    <?php echo $_error_message; ?>    
</div>