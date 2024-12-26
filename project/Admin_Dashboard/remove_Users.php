<div class="removeUser">
    <h2>Remove Users from the System</h2>
    
    <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th scope="col">#</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                require_once '../classes/Admin.php';

                if (isset($_SESSION['useremail'])) {
                    $admin = new Admin($_SESSION['useremail']);
                    $result = $admin->viewRemoveUsers();
                }

                
                
                $rowNumber=1;
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr id="row_' . $rowNumber . '" onclick="openRemoveUserDetails(\''.htmlspecialchars($row['nic']).'\',' . $rowNumber . ')">';
                        echo '<th scope="row">' . $rowNumber . '</th>';
                        echo '<td>' . htmlspecialchars($row['nic']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_No']) . '</td>';
                        echo '<td><button class="btn btn-sm btn-warning" data-nic="' . htmlspecialchars($row['nic']) . '" onclick="event.stopPropagation(),removeUser(' . $rowNumber . ')">Remove</button></td>';
                        echo '</tr>';
                        $rowNumber++;
                    }
                    
                }else {
                echo '<tr><td colspan="6">No users found</td></tr>';
                }
                
                
                ?>
            </tbody>
        </table>
</div>