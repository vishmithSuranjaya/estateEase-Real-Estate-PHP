<?php

header('Content-Type: application/json');

$ad_id = $_GET['ad_id'];

try {
    require_once '../classes/BidAds.php';

    if (isset($_SESSION['id'])) {
        $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
        $result = $bid->count_and_update_bids($ad_id);
        
        
 }

    
    if ($result) {
        echo json_encode([
            'current_bid' => $result['current_bid'],
            'number_of_bids' => $result['number_of_bids'],
            'min_auc_price' => $result['min_auc_price']
        ]);
    } else {
        echo json_encode(['error' => 'No bid found']);
    }
    
   
} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['error' => $ex->getMessage()]);
}
?>
