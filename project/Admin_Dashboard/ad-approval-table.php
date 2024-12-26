<div class="popup-content">
    <h2>Pending Bid-Avertisement Approvals</h2>
    
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th scope="col">#</th>
                    <th scope="col">Ad Reference Number</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">District</th>
                    <th scope="col">Town</th>
                    <th scope="col" colspan="2">Action</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                
                session_start();
                require_once '../classes/Admin.php';

                if (isset($_SESSION['useremail'])) {
                    $admin = new Admin($_SESSION['useremail']);
                    $result = $admin->viewAdApproval();
                }
                
                $rowNumber=1;
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr id="row_' . $rowNumber . '" onclick="viewApprovalAdDetails(\''.htmlspecialchars($row['Ad_ID']).'\',' . $rowNumber . ')">';
                        echo '<th scope="row">' . $rowNumber . '</th>';
                        echo '<td>' . htmlspecialchars($row['Ad_ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Category']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['District']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Town']) . '</td>';
                        echo '<td><button class="btn btn-sm btn-primary" data-ad="' . htmlspecialchars($row['Ad_ID']) . '" onclick="event.stopPropagation(),approveAd(' . $rowNumber . ')">Approve</button></td>';
                        echo '<td><button class="btn btn-sm btn-warning" data-ad="' . htmlspecialchars($row['Ad_ID']) . '" onclick="event.stopPropagation(),declineAd(' . $rowNumber . ')">Decline</button></td>';
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
    <button class="close-btn">Close</button>
</div>
