<?php
//require_once './classes/dbConnector.php';
session_start();
if (isset($_COOKIE['useremail']) && isset($_COOKIE['password'])) {
    include_once './include/cookie_logger.php';
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Search and filter</title>
        <link rel="icon" href="./images/logo.png" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="CSS/search_and_filter.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://fontawesome.com/icons/heart?f=classic&s=solid" >
    </head>
    <body class="container-fuild" style="background:var(--background-color);">

        <!--header-->
<?php
include 'include/header.php';
?>

        <div class="page_container row align-items-start">

            <!-- Search Bar -->

            <div class="left-side-bar col-3">
                <!-- Filter Section 1 -->
                <div class="filtersec1">
                    <!-- Form 1 -->
                    <form method="post" action="" class="filter-form">
                        <div class="input-group">
                            <div class="form-outline">
                                <input id="search-input" type="search" placeholder="Search properties..." name="search" class="form-control">

                                <button id="search-button" type="submit" class="btn btn-warning" name="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <script>
                        import { Input, initMDB } from "mdb-ui-kit";

                        initMDB({Input});

                        const searchButton = document.getElementById('search-button');
                        const searchInput = document.getElementById('search-input');
                        searchButton.addEventListener('click', () => {
                            const inputValue = searchInput.value;
                            alert(inputValue);
                        });
                    </script>
                    <hr>

                    <!--input-form2-->
                    <div class="quick-search">
                        <form method="post" action="">
                            <div class="form-group mb-3">
                                <label>
                                    <input type="radio" name="Category" value="All" /> All
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <label>
                                    <input type="radio" name="Category" value="Auction" /> Auction
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <label>
                                    <input type="radio" name="Category" value="Fixed" /> Fixed
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <label>
                                    <input type="radio" name="Category" value="Rent" /> Rent
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="quick-search" class="btn btn-info">Quick Search</button>
                            </div>
                        </form>

                    </div>
                    <hr>

                </div>



                <!-- Filter Section 2 -->
                <div class="filtersec2">
                    <!--input-form3-->
                    <form method="post" action="">
                        <div class="form_field">
                            <label for="district">District:</label>
                        <?php
                        include_once './classes/dbConnector.php';
                        $dbcon = new DbConnector();
                        $con = $dbcon->getConnection();

                        $sql = 'SELECT DISTINCT district FROM town';
                        $stmt = $con->prepare($sql);
                        $stmt->execute();
                        $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                            <select class="form-control" id="dropdown1" name="district" onchange="updateTowns()">
                                <option value=''>Select District</option>
                            <?php foreach ($districts as $district): ?>
                                    <option value="<?= htmlspecialchars($district['district']) ?>"><?= htmlspecialchars($district['district']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form_field">
                            <label for="town">Town:</label>
                            <select class="form-control" name="town" id="a" >
                                <option value=''>Select Town</option>
                            </select>
                        </div>
                </div>
                <hr>
                <!-- Filter Section 3 -->
                <div class="filtersec3">
                    <label class="filter_label" for="category">Select your Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value=''>Select a Category</option>
                        <option value="Fixed">Fixed</option>
                        <option value="Auction">Auction</option>
                        <option value="Rent">Rent</option>
                    </select>

                </div>
                <!-- Filter Section 4 -->
                <div class="filtersec4">
                    <label class="filter_label" for="type">Select your property type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value=''>Select a Property Type</option>
                        <option value="land">Land</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="commercial properties">Commercial Properties</option>
                    </select>
                </div>
                <hr>
                <!-- Filter Section 5 -->
                <div class="filtersec5">
                    <div class="slider">
                        <label for="min_price" class="filter_label">Minimum Price</label>
                        <input type="range" id="min_price" name="min_price" min="10000" max="1000000" step="10000" value="10000">
                        <output for="min_price" id="min_price_val">RS 10,000</output>
                    </div>
                    <div class="slider">
                        <label for="max_price" class="filter_label">Maximum Price</label>
                        <input type="range" id="max_price" name="max_price" min="1000000" max="100000000" step="1000000" value="1000000">
                        <output for="max_price" id="max_price_val">RS 1,000,000</output>
                    </div>
                    <div class="output">
                        <span>Min: RS <span id="min_display">10,000</span></span>
                        <span>Max: RS <span id="max_display">1,000,000</span></span>
                    </div>
                </div>
                <!-- Filter Section 6 -->
                <div class="filtersec6">
                    <div class="btn2">
                        <button type="submit" name="search" class="btn btn-success">Search</button>
                    </div>
                </div>
                </form>
            </div>

            <script>
                const minPrice = document.getElementById('min_price');
                const maxPrice = document.getElementById('max_price');
                const minPriceVal = document.getElementById('min_price_val');
                const maxPriceVal = document.getElementById('max_price_val');
                const minDisplay = document.getElementById('min_display');
                const maxDisplay = document.getElementById('max_display');

                minPrice.addEventListener('input', function () {
                    const formattedMinPrice = parseFloat(this.value).toLocaleString('en-US');
                    minPriceVal.innerHTML = 'RS ' + formattedMinPrice;
                    minDisplay.innerHTML = formattedMinPrice;
                });

                maxPrice.addEventListener('input', function () {
                    const formattedMaxPrice = parseFloat(this.value).toLocaleString('en-US');
                    maxPriceVal.innerHTML = 'RS ' + formattedMaxPrice;
                    maxDisplay.innerHTML = formattedMaxPrice;
                });
            </script>







            <!--add posting-->


            <div class="list_adds col-6">

<?php

// Function to display results
function displayResults($result) {
    $dbcon = new dbConnector;
    $con = $dbcon->getConnection();
    foreach ($result as $row) {
        $imageData = isset($row['image1']) ? base64_encode($row['image1']) : '';
        $imageTag = $imageData ? "<img src='data:image/jpeg;base64,$imageData' class='img-fluid rounded-start' alt='Advertisement Image'>" : '<img src="placeholder.jpg" class="img-fluid rounded-start" alt="No Image Available" >';
        echo "
        <section class='content9'  style='z-index:1;margin-top:15px;'>
            <div class='card mt-2' style='background-color:var(--background-color);z-index:1;margin-bottom:15px;'>
                <div class='row g-0'>
                    <div class='col-md-5' style='padding:0 0 0 20px;display: flex;align-items: center;justify-content: center;'>
                        $imageTag
                    </div>
                    <div class='col-md-7'>
                        <div class='card-body'>
                            <h3 class='card-title'>" . htmlspecialchars($row['title']) . "</h3>
                            <p class='card-text'>" . htmlspecialchars($row['description']) . "</p>
                            <p><b>Category</b>: " . htmlspecialchars($row['category']) . "&emsp; &emsp;<b>Type</b>: " . htmlspecialchars($row['type']) . "<br><b>Price</b>: " . htmlspecialchars($row['price']) . "</p>
                            <br>
                            <div class='button_group'> 
                                <a href='ad_redirector.php?ad_id=" . $row['ad_id'] . "' class='btn5' name='gotoDetails'>Details</a>";

        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $ad_id = $row['ad_id'];
            $nic = $_SESSION['id'];

            $sql9 = 'SELECT EXISTS (SELECT 1 FROM wishlist WHERE ad_id = :ad_id AND nic = :nic) AS record_exists;';
            $stmt10 = $con->prepare($sql9);
            $stmt10->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
            $stmt10->bindValue(':nic', $nic, PDO::PARAM_STR);
            $stmt10->execute();
            $result = $stmt10->fetch(PDO::FETCH_ASSOC);

            $heartType = $result['record_exists'] ? 'bi bi-heart-fill' : 'bi bi-heart';

            echo "
                                        <button type='submit' class='btn2' name='wishList' onclick='saveToWishlist(" . $ad_id . ",\"" . $nic . "\", this)'><i class='" . $heartType . "'></i></button>";
        }

        echo "
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Search bar used
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];

        $sql = "SELECT * FROM advertisement a JOIN town t ON a.town_id = t.town_id LEFT JOIN images i ON a.ad_id = i.ad_id WHERE 
                t.town LIKE :searchTerm OR 
                t.district LIKE :searchTerm OR 
                title LIKE :searchTerm OR 
                description LIKE :searchTerm OR 
                category LIKE :searchTerm OR 
                type LIKE :searchTerm";

        $stmt = $con->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            displayResults($result);
        } else {
            echo "No results found.";
        }
    }
    // Quick search button pressed
    elseif (isset($_POST['quick-search']) && isset($_POST['Category'])) {
        $category = $_POST['Category'];

        if ($category == "All") {
            $sql = "SELECT a.*,i.image1 FROM advertisement a  LEFT JOIN images i ON a.ad_id = i.ad_id";
            $stmt = $con->prepare($sql);
        } else {
            $sql = "SELECT a.*,i.image1 FROM advertisement a  LEFT JOIN images i ON a.ad_id = i.ad_id WHERE a.category = ?";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $category, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            displayResults($result);
        } else {
            echo "No results found.";
        }
    }
    // Search button pressed
    elseif (isset($_POST['search'])) {
        $district = (isset($_POST['district']) && ($_POST['district']) != '') ? $_POST['district'] : NULL;
        $town = (isset($_POST['town']) && ($_POST['town']) != '') ? $_POST['town'] : NULL;
        $category = (isset($_POST['category']) && ($_POST['category']) != '') ? $_POST['category'] : NULL;
        $type = (isset($_POST['type']) && ($_POST['type']) != '') ? $_POST['type'] : NULL;
        $min_price = (isset($_POST['min_price']) && ($_POST['min_price'] != 10000)) ? $_POST['min_price'] : NULL;
        $max_price = (isset($_POST['max_price']) && ($_POST['max_price'] != 1000000)) ? $_POST['max_price'] : NULL;



        $sql = "SELECT a.*,
                       i.image1, 
                       a.title, 
                       a.description, 
                       a.category, 
                       a.type, 
                       a.price 
                FROM advertisement a
                JOIN town t ON a.town_id = t.town_id
                LEFT JOIN images i ON a.ad_id = i.ad_id
                WHERE 
                  (:district IS NULL OR t.district = :district) AND
                  (:town IS NULL OR t.town = :town) AND
                  (:category IS NULL OR a.category = :category) AND
                  (:type IS NULL OR a.type = :type) AND
                  (:min_price IS NULL OR a.price >= :min_price) AND
                  (:max_price IS NULL OR a.price <= :max_price)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':district', $district, is_null($district) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':town', $town, is_null($town) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':category', $category, is_null($category) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, is_null($type) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':min_price', $min_price, is_null($min_price) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':max_price', $max_price, is_null($max_price) ? PDO::PARAM_NULL : PDO::PARAM_INT);


        try {
            // Prepare and execute the statement
            $stmt->execute();

            // Fetch results
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process results
            if (count($result) > 0) {
                displayResults($result);
            } else {
                echo "No results found.";
            }
        } catch (PDOException $e) {
            // Handle SQL errors
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    // Random advertisements before any search or filtering
    $randomSql = "SELECT a.*, i.image1 FROM advertisement a LEFT JOIN images i ON a.ad_id = i.ad_id ORDER BY RAND() LIMIT 5";
    $stmt = $con->prepare($randomSql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        displayResults($result);
    } else {
        echo "No advertisements available.";
    }
}

$con = null;
?>




            </div>

            <!--calculator -->

            <div class="calculator1 col-md-3">
                <h4 style="text-align:center;color: blue">Installment<br>Calculator</h4>
                <hr>

                <form id="calculator-form" class="calculator-form"> 
                    <label for="loan_amount">Loan Amount:</label>
                    <input class="input_feild" type="number" id="loan_amount" name="loan_amount" required><br><br>

                    <label for="interest_rate">Interest Rate (%):</label>
                    <input type="number" step="0.01" id="interest_rate" name="interest_rate" required>
                    <select id="interest_period" name="interest_period">
                        <option value="monthly">Per Month</option>
                        <option value="yearly">Per Year</option>
                    </select><br><br>

                    <label for="term">Number of Terms:</label>
                    <input type="number" id="term" name="term" required>
                    <select id="term_period" name="term_period">
                        <option value="months">Months</option>
                        <option value="years">Years</option>
                    </select><br><br>

                    <button type="button" class="calculate" onclick="calculateInstallment()">Calculate</button>
                </form>

                <div class="result">
                    <div class="popup" id="popup" style="display:none;">
                        <div class="popup-content">
                            <img src="images/installment.jpeg" alt="Installment">
                            <h5>Congratulations</h5>
                            <p>Your monthly installment amount:</p>
                            <b style="font-size:30px;"><span id="installment-amount"></span></b><br>
                            <button type="button" class="ok" onclick="closePopup()">OK</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>

<?php
include 'include/footer.php';
?>


        <script>
            function calculateInstallment() {
                const loanAmount = parseFloat(document.getElementById('loan_amount').value);
                const interestRate = parseFloat(document.getElementById('interest_rate').value);
                const interestPeriod = document.getElementById('interest_period').value;
                const term = parseInt(document.getElementById('term').value);
                const termPeriod = document.getElementById('term_period').value;

                if (isNaN(loanAmount) || isNaN(interestRate) || isNaN(term)) {
                    alert('Invalid input. Please enter valid numbers.');
                    return;
                }

                const monthlyInterestRate = interestPeriod === 'yearly' ? (interestRate / 100) / 12 : interestRate / 100;
                const months = termPeriod === 'years' ? term * 12 : term;
                const monthlyPayment = (loanAmount * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -months));
                const roundedMonthlyPayment = monthlyPayment.toFixed(2);

                document.getElementById('installment-amount').innerText = `Rs ${roundedMonthlyPayment}`;
                document.getElementById('popup').style.display = 'block';
            }

            function closePopup() {
                document.getElementById('popup').style.display = 'none';
            }

            function updateTowns() {
                var district = document.getElementById("dropdown1").value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', './townlist_update.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("a").innerHTML = xhr.responseText;
                    }
                };

                xhr.send("district=" + encodeURIComponent(district));
            }
        </script>


    </body>
</html>
