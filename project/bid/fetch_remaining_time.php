<?php

header('Content-Type: application/json');

$ad_id = $_GET['ad_id'];

require_once '../classes/BidAds.php';

    if (isset($_SESSION['id'])) {
        $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
        $bid->update_time($ad_id);
        
    }

?>
