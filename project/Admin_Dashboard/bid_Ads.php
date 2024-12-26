<div class="bidAd">
    <h2>Bidding Advertisements</h2>
    
    <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th scope="col">#</th>
                    <th scope="col">Ad Reference Number</th>
                    <th scope="col">District</th>
                    <th scope="col">Town</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                session_start();
                require_once '../classes/Admin.php';

                if (isset($_SESSION['useremail'])) {
                    $admin = new Admin($_SESSION['useremail']);
                    $result = $admin->viewBidAds();
                }
                
                $rowNumber=1;
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr id="row_' . $rowNumber . '" onclick="viewAdDetails(\''.htmlspecialchars($row['Ad_ID']).'\',' . $rowNumber . ')">';
                        echo '<th scope="row">' . $rowNumber . '</th>';
                        echo '<td>' . htmlspecialchars($row['Ad_ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['District']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Town']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Category']) . '</td>';
                        echo '</tr>';
                        $rowNumber++;
                    }
                    
                }else {
                echo '<tr><td colspan="6">No Ads found</td></tr>';
                }
                
                
                ?>
            </tbody>
        </table>
</div>