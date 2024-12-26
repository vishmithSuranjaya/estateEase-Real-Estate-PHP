<div class="removeAd">
    <h2>Remove Advertisements from the System</h2>
    
    <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th scope="col">#</th>
                    <th scope="col">Ad Reference Number</th>
                    <th scope="col">District</th>
                    <th scope="col">Town</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include 'DbConnector.php';

                $dbcon= new Dbconnector();
                $con = $dbcon->getConnection();

                $sql = 'SELECT
                            a.ad_id as Ad_ID,
                            t.district as District,
                            t.town as Town,
                            a.title as Title,
                            a.category as Category
                        FROM 
                            advertisement a
                        JOIN 
                            town t ON a.town_id = t.town_id;
                        ';
                $result = $con->query($sql);
                
                $rowNumber=1;
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr id="row_' . $rowNumber . '" onclick="viewRemoveAdDetails(\''.htmlspecialchars($row['Ad_ID']).'\',' . $rowNumber . ')">';
                        echo '<th scope="row">' . $rowNumber . '</th>';
                        echo '<td>' . htmlspecialchars($row['Ad_ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['District']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Town']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Category']) . '</td>';
                        echo '<td><button class="btn btn-sm btn-primary" data-ads="' . htmlspecialchars($row['Ad_ID']) . '" onclick="event.stopPropagation(),removeAd(' . $rowNumber . ')">Remove Ad</button></td>';
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