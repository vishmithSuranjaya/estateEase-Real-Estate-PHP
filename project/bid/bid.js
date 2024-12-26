document.addEventListener('DOMContentLoaded', function() {
    
    let adIdElement = document.getElementById('session-ad');
    let adId;
    if (adIdElement) {
        adId = adIdElement.value;
        console.log(adId);
    } else {
        console.error('Element with id "session-ad" not found');
        return; 
    }

    let remainingTime;
    let intervalId;
    let currentBid = 0;

    function updateTimer() {
        const daysElem = document.querySelector('.day');
        const hoursElem = document.querySelector('.hour');
        const minutesElem = document.querySelector('.minute');
        const secondsElem = document.querySelector('.second');
        const currentBidElem = document.querySelector('#current-bid');
        const number_of_bidsElem = document.querySelector('#number_of_bids');
        const min_auc_priceElem = document.querySelector('#min_auc_price');
        
        if (remainingTime <= 0) {
            clearInterval(intervalId);
            removeBid(adId);
            return;
        }

        let days = Math.floor(remainingTime / (24 * 60 * 60)).toString().padStart(2, '0');
        let hours = Math.floor((remainingTime % (24 * 60 * 60)) / (60 * 60)).toString().padStart(2, '0');
        let minutes = Math.floor((remainingTime % (60 * 60)) / 60).toString().padStart(2, '0');
        let seconds = (remainingTime % 60).toString().padStart(2, '0');

        daysElem.innerText = days;
        hoursElem.innerText = hours;
        minutesElem.innerText = minutes;
        secondsElem.innerText = seconds;
        
        remainingTime--;
        
        fetchCurrentBid();
    }

    function fetchRemainingTime() {
        fetch(`./bid/fetch_remaining_time.php?ad_id=${adId}`)
            .then(response => response.json())
            .then(data => {
                if(data.error === 'Bid not found'){
                    clearInterval(intervalId);
                    return;
                }
                
                if (data.remaining_time !== undefined) {
                    remainingTime = data.remaining_time.total_seconds;
                    if (intervalId) {
                        clearInterval(intervalId);          // clearing up the existing interval before setting the new interval
                    }
                    intervalId = setInterval(updateTimer, 1000);
                } else {
                    console.error('Error fetching remaining time:', data.error);
                }
            })
            .catch(error => console.error('Error fetching remaining time:', error));
    }
    
    function fetchCurrentBid() {
        fetch(`./bid/current_bid.php?ad_id=${adId}`)
            .then(response => response.json())
            .then(data => {
                if (data.current_bid !== undefined) {
                    currentBid = data.current_bid;
                    document.getElementById('current-bid').innerText = currentBid;
                    let numberOfBids =  data.number_of_bids;
                    document.getElementById('number_of_bids').innerText = numberOfBids;
                    let minAucPrice = data.min_auc_price;
                    document.getElementById('min_auc_price').innerText = minAucPrice; 
                    
                } else {
                    console.error('Error fetching current bid:', data.error);
                }
            })
            .catch(error => console.error('Error fetching current bid:', error));
    }

    function placeBid(){
        const bidAmountElem = document.getElementById('bidAmount');
        const bidAmount = parseFloat(bidAmountElem.value.replace(/,/g, ''));

        if (currentBid === null && bidAmount <= minAucPrice){
            alert("The Initial Bid must be higher than the Minimum Auction Price");
            return;
        }

        if (isNaN(bidAmount) || bidAmount <= currentBid ) {
            alert("Your bid must be higher than the current bid");
            return;
        }
        
        const nic = document.getElementById('session-nic').value; 
        const email = document.getElementById('session-email').value;
        
        const formData = new FormData();
        formData.append('ad_id',adId);
        formData.append('bid_amount',bidAmount);
        formData.append('nic',nic);
        formData.append('email',email);
        
        fetch('./bid/place_bid.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                alert ("Bid placed Successfully!");
                fetchRemainingTime();
                if(data.sendEmails){
                    sendEmails(nic,email,data.previous_email);
                }
            }else{
                alert("Error placing the bid : "+ data.error);
           }
        })
        .catch(error => console.error('Error placing bid: ', error));
    }
    
    function sendEmails(currentNic,currentEmail,previousEmail){
        fetch('./bid/send_emails.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                current_nic: currentNic,
                current_email: currentEmail,
                previous_email: previousEmail
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if(data.success){
                console.log("Emails sent successfully!");
            }else{
                console.error("Error sending Emails: "+ data.error);
            }
        })
        .catch(error => console.error('Error sending emails: ',error));
    }

    function removeBid(adId) {
    fetch(`./bid/remove_bid.php?ad_id=${adId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("The bid has ended and was removed.");
                window.location.href = `./bidOver.php?s=${adId}`;
            } else {
                console.error('Error removing bid:', data.error);
            }
        })
        .catch(error => console.error('Error removing bid: ', error));
    }

    
    fetchRemainingTime();

    
    const placeBidBtn = document.querySelector('#place-bid');
    if (placeBidBtn) {
        placeBidBtn.addEventListener('click', placeBid);
    } else {
        console.error('Element with id "place-bid" not found');
    }
});
