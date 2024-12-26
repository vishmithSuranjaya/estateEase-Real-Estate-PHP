<div class="popup-content">
    <h2>Pending User Account Approvals</h2>
    
    <div class="table-container">
        <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th scope="col">#</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact No</th>
                    <th scope="col" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                require_once '../classes/Admin.php';

                if (isset($_SESSION['useremail'])) {
                    $admin = new Admin($_SESSION['useremail']);
                    $result = $admin->viewPendingUsers();
                }
                
                
                $rowNumber=1;
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr id="row_' . $rowNumber . '" onclick="openApproveUserDetails(\''.htmlspecialchars($row['nic']).'\',' . $rowNumber . ')">';
                        echo '<th scope="row">' . $rowNumber . '</th>';
                        echo '<td>' . htmlspecialchars($row['nic']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_No']) . '</td>';
                        echo '<td><button class="btn btn-sm btn-primary" data-nic="' . htmlspecialchars($row['nic']) . '" onclick="event.stopPropagation(),approveUser(' . $rowNumber . ')">Approve</button></td>';
                        echo '<td><button class="btn btn-sm btn-warning" data-nic="' . htmlspecialchars($row['nic']) . '" onclick="event.stopPropagation(),declineUser(' . $rowNumber . ')">Decline</button></td>';
                        echo '</tr>';
                        $rowNumber++;
                    }
                    
                }else {
                echo '<tr><td colspan="6">No Pending Users Found</td></tr>';
                }
                
                
                ?>
            </tbody>
        </table>
    </div>
    <button class="close-btn">Close</button>
</div>
</div>
