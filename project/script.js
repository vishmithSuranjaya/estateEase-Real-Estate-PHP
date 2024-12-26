//------------------------ navbar fixing code----------------------

// Toggle search form
const searchForm = document.querySelector('.upper_nav');

document.querySelector('#search-button').onclick = () => {
    searchForm.classList.toggle('active');
}

// Scroll event handler
window.onscroll = () => {
    searchForm.classList.remove('active');

    const navbar = document.querySelector('.navbar');
    const myButton = document.getElementById('scrollTopBtn');

    if (navbar) {
        if (window.scrollY > 70) {
            navbar.classList.add('active');
        } else {
            navbar.classList.remove('active');
        }
    }

    if (myButton) {
        if (window.scrollY > 70) {
            myButton.style.display = "block";
        } else {
            myButton.style.display = "none";
        }
    }
}

//------------------------------------ scrolling button onclick function -----------------------
function scrollTotop(){
    document.body.scrollTop=0;//for safari
    document.documentElement.scrollTop=0;//for firefox,chrome and opera
}

//------------------------------------------ dark / light theme selecting----------------------
window.onload = () => {
    const savedTheme = localStorage.getItem('theme');
    if(savedTheme == 'dark'){
      lightThemeon();
    }else{
      darkThemeon();
    }
  };

  
var darkmode = document.getElementById('darkTheme');
var lightmode = document.getElementById('lightTheme');
function darkThemeon(){
    localStorage.setItem('theme', 'light');
    darkmode.style.display="none";
    lightmode.style.display="inline-block";
    document.documentElement.style.setProperty('--main-color', '#009966');
    document.documentElement.style.setProperty('--first-color','#ebebeb');
    document.documentElement.style.setProperty('--second-color','#099d02');
    document.documentElement.style.setProperty('--third-color','#fff');
    document.documentElement.style.setProperty('--hover-color','#099d02');
    document.documentElement.style.setProperty('--font-color','black');
    document.documentElement.style.setProperty('--btn-color','#099d02');
    document.documentElement.style.setProperty('--background-color',"#fff");
    
}

function lightThemeon(){
    localStorage.setItem('theme', 'dark');
    darkmode.style.display="inline-block";
    lightmode.style.display="none";
    document.documentElement.style.setProperty('--main-color', '#343634');
    document.documentElement.style.setProperty('--first-color','#343634');
    document.documentElement.style.setProperty('--second-color','#fff');
    document.documentElement.style.setProperty('--third-color','gray');
    document.documentElement.style.setProperty('--hover-color','#fff');
    document.documentElement.style.setProperty('--font-color','#fff');
    document.documentElement.style.setProperty('--btn-color','#fff');
    document.documentElement.style.setProperty('--background-color',"#4a4c4a");
}
 
//------------------------------------------------------------AJAX request to save to wishlist
    function saveToWishlist(adId, nic, btnElement) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_to_wishlist_inc.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          var heartIcon = btnElement.querySelector('i');
          if (response.action === 'added') {
            heartIcon.classList.remove('bi-heart');
            heartIcon.classList.add('bi-heart-fill');
          } else if (response.action === 'removed') {
            heartIcon.classList.remove('bi-heart-fill');
            heartIcon.classList.add('bi-heart');
          }
        } else {
          alert(response.message);
        }
      } else {
        alert('Request failed. Please try again later.');
      }
    };
    
    var data = 'ad_id=' + adId + '&nic=' + nic;
    xhr.send(data);
  }
//------------------------------------------ payhere script----------------------

function paymentGateway(){
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200){
            var obj = JSON.parse(xhttp.responseText);
        
        
        payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer
        
        var paymentXhttp = new XMLHttpRequest();
        paymentXhttp.onreadystatechange = function() {
            if (paymentXhttp.readyState == 4 && paymentXhttp.status == 200) {
                console.log("Payment database is getting updated.");
            }
        };
        
        if(document.querySelector('input[name="category"]:checked').value === "Fixed"){
            paymentXhttp.open("POST", "adPostingPaymentFixed.php", true);
        }
        
        else if(document.querySelector('input[name="category"]:checked').value === "Rent"){
            paymentXhttp.open("POST", "adPostingPaymentRent.php", true);
        }
        
        else if(document.querySelector('input[name="category"]:checked').value === "Auction"){
            paymentXhttp.open("POST", "adPostingPayment.php", true);
        }

        //paymentXhttp.open("POST", "adPostingPayment.php", true);
        paymentXhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        paymentXhttp.send();

        document.getElementById("submitBtn").style.display = "inline-block";
        document.getElementById("button-div").style.display = "none";
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
            // Note: Prompt user to pay again or show an error page
            console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
            // Note: show an error page
            console.log("Error:"  + error);
        };

        // Put the payment variables here
        var payment = {
            "sandbox": true,
            "merchant_id": "1228265",    // Replace your Merchant ID
            "return_url": "http://localhost/Project_Final/Ad_posting_form.php",     // Important
            "cancel_url": "http://localhost/Project_Final/Ad_posting_form.php",     // Important
            "notify_url": "http://localhost/Project_Final/Ad_posting_form.php",
            "order_id": obj["order_id"],
            "items": obj["item"],
            "amount": obj["amount"],
            "currency": obj["currency"],
            "hash": obj["hash"],// *Replace with generated hash retrieved from backend
            "first_name": obj["first name"],
            "last_name":obj["last name"],
            "email": obj["email"],
            "phone": obj["phone"],
            "address": obj["address"],
            "city": obj["city"],
            "country": "Sri Lanka",
            "delivery_address": obj["address"],
            "delivery_city": obj["city"],
            "delivery_country": "Sri Lanka",
            "custom_1": "",
            "custom_2": ""
        };

        payhere.startPayment(payment);
        }

        };
        if(document.querySelector('input[name="category"]:checked').value === "Fixed"){
            xhttp.open("GET","payhereProcessFixed_Rent.php",true);
        }
        
        else if(document.querySelector('input[name="category"]:checked').value === "Rent"){
            xhttp.open("GET","payhereProcessFixed_Rent.php",true);
        }
        
        else if(document.querySelector('input[name="category"]:checked').value === "Auction"){
            xhttp.open("GET","payhereProcess.php",true);
        }
        
        
        xhttp.send();
}


//------------------------------------------ payhere script for bid----------------------

function bidPayment(){
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200){
            var obj = JSON.parse(xhttp.responseText);
        
        
        payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer
        window.location.href = "./thank_you.php";
        var paymentXhttp = new XMLHttpRequest();
        paymentXhttp.onreadystatechange = function() {
            if (paymentXhttp.readyState == 4 && paymentXhttp.status == 200) {
                console.log("Payment database is getting updated.");
            }
        };

        paymentXhttp.open("POST", "bidPaymentDatabase.php", true);
        paymentXhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        paymentXhttp.send();

            
        
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
            // Note: Prompt user to pay again or show an error page
            console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
            // Note: show an error page
            console.log("Error:"  + error);
        };

        // Put the payment variables here
        var payment = {
            "sandbox": true,
            "merchant_id": "1228265",    // Replace your Merchant ID
            "return_url": "http://localhost/Project_Final/bidPayment.php",     // Important
            "cancel_url": "http://localhost/Project_Final/bidPayment.php",     // Important
            "notify_url": "http://localhost/Project_Final/bidPayment.php",
            "order_id": obj["order_id"],
            "items": obj["item"],
            "amount": obj["amount"],
            "currency": obj["currency"],
            "hash": obj["hash"],// *Replace with generated hash retrieved from backend
            "first_name": obj["first name"],
            "last_name":obj["last name"],
            "email": obj["email"],
            "phone": obj["phone"],
            "address": obj["address"],
            "city": obj["city"],
            "country": "Sri Lanka",
            "delivery_address": obj["address"],
            "delivery_city": obj["city"],
            "delivery_country": "Sri Lanka",
            "custom_1": "",
            "custom_2": ""
        };

        payhere.startPayment(payment);
        }

        };
        xhttp.open("GET","payhereProcess_1.php",true);
        xhttp.send();
}