<div style="width: 960px; margin: auto;">
    <table>
        <tr>
            <td><span style="color: #666;">Debug info: </span>
                <span style="cursor: pointer; text-decoration: underline;" id="time_btn_">time</span> | 
                <span style="cursor: pointer; text-decoration: underline;" id="vars_btn_">vars</span> | 
                <span style="cursor: pointer; text-decoration: underline;" id="plugin_controllers_btn_">plugin controllers</span> |
                <span style="cursor: pointer; text-decoration: underline;" id="queries_btn_">queries</span>
            </td>
        </tr>
        
        <tr id="time_panel_" >
            <td>
                <?php Execution::showExecutionTime(); ?>
            </td>
        </tr>
        
        <tr id="vars_panel_" style="display: none;">
            <td>
                <pre>
GET: <?php  print_r($_GET);  ?>

POST: <?php  print_r($_POST);  ?>

SESSION:  <?php if(isset ($_SESSION) and $_SESSION){print_r($_SESSION);}  ?>

SERVER: <?php  print_r($_SERVER);  ?>
                </pre>
            </td>
        </tr>
        
        <tr id="queries_panel_" style="display: none;">
            <td>
                <?php $total = 0; foreach (Database::get_info() as $query) { ?>
                <b>query: </b> <span> <?php echo $query['query']; ?> </span> <br />
                <b>time: </b> <span> <?php echo round($query['time'],4); $total += $query['time']; ?> </span> <br /><br />
                <?php } ?>
                <b> total time: </b> <span><?php echo round($total,4); ?></span>
            </td>
        </tr>
        <tr id="plugins_panel_" style="display: none;" >
            <td><pre>
                <?php global $plugin_controllers; print_r($plugin_controllers); ?>
                </pre>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#time_btn_").click(function(){
            hide_all_banchmarks();
            $("#time_panel_").show();
        });
        $("#vars_btn_").click(function(){
            hide_all_banchmarks();
            $("#vars_panel_").show();
        });
        $("#queries_btn_").click(function(){
            hide_all_banchmarks();
            $("#queries_panel_").show();
        });
        $("#plugin_controllers_btn_").click(function(){
            hide_all_banchmarks();
            $("#plugins_panel_").show();
        });
        
    });
    
    function hide_all_banchmarks(){
        $('#time_panel_').hide();
        $('#vars_panel_').hide();
        $('#queries_panel_').hide();
        $('#plugins_panel_').hide();
    }
</script>
