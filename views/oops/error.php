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
<style type="text/css"> 
    .error-buffer{ 
        width:600px;
        height:400px;
        position:fixed;
        z-index:10000000000;
        left:50%;
        top:50%;
        margin-left:-300px;
        margin-top:-200px;
        overflow-y: scroll; 
        overflow-x: hidden;
        background-color: #252a2e;
        border:2px solid black;
        padding:20px;
        border-radius:5pt;
    }
</style>

<div class="error-buffer">
    <div class="btn btn-xs btn-danger" id="close-error" style="position:absolute;right:0; top:0; margin:5px; ">
        x
    </div>
    <script type='text/javascript' >
        $('#close-error').click(function () {
            $('.error-buffer').hide();
        });
    </script>
    <h2 style='color:white;'>There where some Warnings/Errors</h2>

    <?php echo $_error_message; ?>    

</div>