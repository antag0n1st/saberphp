<?php // @chdir('/public_html/mojtrener.mk/cronjobs/'); ?>
<?php include_once 'cronjobs.php'; ?>
<?php 

//    Load::helper('time_helper');
//    Load::helper('mailer');
//    
//    $query  = " SELECT * , q.id as mailer_id FROM mailer_queue as q ";
//    $query .= " JOIN emails as e ON q.email_id = e.id ";
//    $query .= " WHERE q.is_sent = 0 ";
//    $query .= " LIMIT 25 ";
//    
//    $result = Model::db()->query($query);
//    
//    while($row = Model::db()->fetch_assoc($result)){
//        
//        $id    = $row['mailer_id'];
//        $title = $row['title'];
//        $body  = $row['content'];
//        $from  = $row['from'];
//        $to    = $row['to'];
//        
//        $query  = " UPDATE mailer_queue ";
//        $query .= " SET is_sent = 1 ";
//        $query .= " , date_sent = '".TimeHelper::DateTimeAdjusted()."' ";
//        $query .= " WHERE id = '".Model::db()->prep($id)."' ";
//        
//        Model::db()->query($query);
//        
//        Mailer::send($from, $to, $title, $body,false);
//        
//        sleep(5);
//    }

?>