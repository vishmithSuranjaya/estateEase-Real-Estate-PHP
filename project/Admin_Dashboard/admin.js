/* global google */

document.addEventListener("DOMContentLoaded", function() {
    const hamBurger = document.querySelector("#toggle-btn");

    hamBurger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });

    const userAppDiv = document.querySelector('.card.border-0.user-app');
    const adAppDiv = document.querySelector('.card.border-0.ad-app');
    const view_profileAppDiv = document.querySelector('.view_profile');
    
    if (view_profileAppDiv) {
        view_profileAppDiv.addEventListener('click', function () {
            openPopup('view_admin_profile.php');
        });
    }
    if (userAppDiv) {
        userAppDiv.addEventListener('click', function () {
            openPopup('user-approval-table.php');
        });
    }

    if (adAppDiv) {
        adAppDiv.addEventListener('click', function () {
            openPopup('ad-approval-table.php');
        });
    }
});
    function openPopup(url) {
        const overlay = document.createElement('div');
        overlay.classList.add('overlay');

        const popup = document.createElement('div');
        popup.classList.add('popup');

        fetch(url)
            .then(response => response.text())
            .then(data => {
                popup.innerHTML = data;
                overlay.appendChild(popup);
                document.body.appendChild(overlay);
                $(document).ready(function() {
                    var swiper = new Swiper(".mySwiper", {
                    spaceBetween: 30,
                    centeredSlides: true,
                    autoplay: {
                      delay: 1500,
                      disableOnInteraction: false,
                    },
                    pagination: {
                      el: ".swiper-pagination",
                      clickable: true,
                    },
                    navigation: {
                      nextEl: ".swiper-button-next",
                      prevEl: ".swiper-button-prev",
                    },
                  });
                });

                const closeBtn = popup.querySelector('.close-btn');
                closeBtn.addEventListener('click', () => {
                    document.body.removeChild(overlay);
                    document.body.style.overflow = '';
                });

                overlay.addEventListener('click', (event) => {
                    if (event.target === overlay) {
                        document.body.removeChild(overlay);
                        document.body.style.overflow = '';
                    }
                });

                document.body.style.overflow = 'hidden';
            })
            .catch(error => console.error('Error fetching popup content:', error));
    }
    




function popupApproveAd(rowNumber){
    var test = document.querySelector('#approveAdBtn');
    
    if ((test.classList.contains('btn-primary') && test.textContent === 'Approve')){
    approveAd(rowNumber);
    test.textContent = 'Approved';
    test.classList.toggle('btn-success');
}
}    

function approveAd(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-primary');
    var ad = approveButton.dataset.ad;

    if (approveButton.classList.contains('btn-primary') && approveButton.textContent === 'Approve') {
        approveButton.classList.toggle('btn-success');
        approveButton.textContent = 'Approved';
        
        
    } 
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'approve_Ad_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'ad=' + encodeURIComponent(ad);
        
        xhr.send(params);
}

function declineAd(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-warning');
    var ad = approveButton.dataset.ad;

    if (approveButton.classList.contains('btn-warning') && approveButton.textContent === 'Decline') {
        approveButton.classList.toggle('btn-danger');
        approveButton.textContent = 'Declined';
        
        
    } 
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'decline_Ad_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'ad=' + encodeURIComponent(ad);
        
        xhr.send(params);
}


function popupApproveUser(rowNumber){
    var test = document.querySelector('#approveUserBtn');
    
    if ((test.classList.contains('btn-primary') && test.textContent === 'Approve')){
    approveUser(rowNumber);
    test.textContent = 'Approved';
    test.classList.toggle('btn-success');
}
}    

function approveUser(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-primary');
    var nic = approveButton.dataset.nic;

    if (approveButton.classList.contains('btn-primary') && approveButton.textContent === 'Approve') {
        approveButton.classList.toggle('btn-success');
        approveButton.textContent = 'Approved';
        
        
    } 
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'approve_user_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'nic=' + encodeURIComponent(nic);
        
        xhr.send(params);
}
function declineUser(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-warning');
    var nic = approveButton.dataset.nic;

    if (approveButton.classList.contains('btn-warning') && approveButton.textContent === 'Decline') {
        approveButton.classList.toggle('btn-danger');
        approveButton.textContent = 'Declined';
        
        
    } 
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'decline_user_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'nic=' + encodeURIComponent(nic);
        
        xhr.send(params);
}
function popupRemoveUser(rowNumber){
    var test = document.querySelector('#removeUserBtn');
    
    if ((test.classList.contains('btn-warning') && test.textContent === 'Remove')){
    removeUser(rowNumber);
    test.textContent = 'Removed';
    test.classList.toggle('btn-danger');
}
}

function removeUser(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-warning');
    var nic = approveButton.dataset.nic;

    if (approveButton.classList.contains('btn-warning') && approveButton.textContent === 'Remove') {
        approveButton.classList.toggle('btn-danger');
        approveButton.textContent = 'Removed';
        
        
    } 
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_user_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'nic=' + encodeURIComponent(nic);
        
        xhr.send(params);
}

function popupBanUser(rowNumber){
    var test = document.querySelector('#banUserBtn');
    
    if ((test.classList.contains('btn-secondary') && test.textContent === 'Ban')){
    banUser(rowNumber);
    test.textContent = 'Banned';
    test.classList.toggle('btn-danger');
}
}

function banUser(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-secondary');
    var nic = approveButton.dataset.nic;
    
    if ((approveButton.classList.contains('btn-secondary') && approveButton.textContent === 'Ban')) {
        approveButton.classList.toggle('btn-danger');
        approveButton.textContent = 'Banned';
        
        
        
    }
    
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ban_user_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'nic=' + encodeURIComponent(nic);
        
        xhr.send(params);
}

function popupRemoveAd(rowNumber){
    var test = document.querySelector('#removeAdBtn');
    
    if ((test.classList.contains('btn-primary') && test.textContent === 'Remove Ad')){
    removeAd(rowNumber);
    test.textContent = 'Removed Ad';
    test.classList.toggle('btn-danger');
}
}    


function removeAd(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-primary');
    var ads = approveButton.dataset.ads;
    
    if ((approveButton.classList.contains('btn-primary') && approveButton.textContent === 'Remove Ad')) {
        approveButton.classList.toggle('btn-danger');
        approveButton.textContent = 'Removed Ad';
        
        
        
    }
    
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_ad_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'ads=' + encodeURIComponent(ads);
        
        xhr.send(params);
}

function popupRemoveBanUser(rowNumber){
    var test = document.querySelector('#removeBanButton');
    
    if ((test.classList.contains('btn-warning') && test.textContent === 'Remove Ban')){
    removeBanUser(rowNumber);
    test.textContent = 'Ban Removed';
    test.classList.toggle('btn-success');
}
} 

function removeBanUser(rowNumber) {
    var rowId = 'row_' + rowNumber;
    var approveButton = document.querySelector('#' + rowId + ' .btn-warning');
    var nic = approveButton.dataset.nic;
    
    if (approveButton.classList.contains('btn-warning') && approveButton.textContent === 'Remove Ban') {
        approveButton.classList.toggle('btn-success');
        approveButton.textContent = 'Ban Removed';
        
        
    } 
    function toggleBan() {
        removeBanUser(rowNumber);
    }
    approveButton.addEventListener('click', toggleBan);
    var xhr = new XMLHttpRequest();
        xhr.open('POST', 'removeBan_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        
        var params = 'nic=' + encodeURIComponent(nic);
        
        xhr.send(params);
    
}
      
      google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    fetch('fetch-data.php')
        .then(response => response.json())
        .then(data => {
            const chartData = [['District', 'Ads', 'Users']];
            data.forEach(row => {
                chartData.push([row.district, parseInt(row.ads), parseInt(row.users)]);
            });

            const googleData = google.visualization.arrayToDataTable(chartData);

            const options = {
                chart: {
                    title: 'Website Ads and User Count Overview',
                    subtitle: 'Based on current database update'
                },
                bars: 'vertical',
                hAxis: {
                    textStyle: {
                        fontSize: 8
                    }
                }
            };

            const chart = new google.charts.Bar(document.getElementById('barchart_material'));
            chart.draw(googleData, google.charts.Bar.convertOptions(options));

            window.addEventListener('resize', function() {
                chart.draw(googleData, google.charts.Bar.convertOptions(options));
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}


function hideAndLoadChangePassword() {
            $('#currentContent').hide();
            $('#ban_Users').hide();
            $('#remove_Users').hide();
            $('#nonBid_Ads').hide();
            $('#bid_Ads').hide();
            $('#remove_Ads').hide();
            $('#viewBlacklist').hide();
            
            $('#change_Password').load('change_Password.php .changePw', function() {
                $('#change_Password').show();
            });
}

        $(document).ready(function() {
            $('#changePassword').click(function(e) {
                e.preventDefault();
                hideAndLoadChangePassword();
                });
                
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('showChangePassword')) {
                hideAndLoadChangePassword();
            }
        });
        
function onloading(){
    window.location.href = 'admin_panel.php?showChangePassword=true';
}

$(document).ready(function() {
    $('#viewBlack').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#ban_Users').hide();
        $('#remove_Users').hide();
        $('#nonBid_Ads').hide();
        $('#bid_Ads').hide();
        $('#remove_Ads').hide();
        $('#change_Password').hide();
        
        $('#viewBlacklist').load('view_Blacklist.php .viewBlacklist', function() {
           
            $('#viewBlacklist').show();
        });
    });
});

$(document).ready(function() {
    $('#removeUser').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#ban_Users').hide();
        $('#change_Password').hide();
        $('#nonBid_Ads').hide();
        $('#bid_Ads').hide();
        $('#remove_Ads').hide();
        $('#viewBlacklist').hide();
        
        $('#remove_Users').load('remove_Users.php .removeUser', function() {
            
            $('#remove_Users').show();
        });
    });
});
$(document).ready(function() {
    $('#banUser').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#remove_Users').hide();
        $('#change_Password').hide();
        $('#nonBid_Ads').hide();
        $('#bid_Ads').hide();
        $('#remove_Ads').hide();
        $('#viewBlacklist').hide();
        
        $('#ban_Users').load('ban_Users.php .banUser', function() {
            
            $('#ban_Users').show();
        });
    });
});

$(document).ready(function() {
    $('#bidAd').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#remove_Users').hide();
        $('#change_Password').hide();
        $('#nonBid_Ads').hide();
        $('#ban_Users').hide();
        $('#remove_Ads').hide();
        $('#viewBlacklist').hide();
        
        $('#bid_Ads').load('bid_Ads.php .bidAd', function() {
            
            $('#bid_Ads').show();
        });
    });
});

$(document).ready(function() {
    $('#nonBidAd').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#remove_Users').hide();
        $('#change_Password').hide();
        $('#ban_Users').hide();
        $('#remove_Ads').hide();
        $('#bid_Ads').hide();
        $('#viewBlacklist').hide();
        
        $('#nonBid_Ads').load('nonBid_Ads.php .nonBidAd', function() {
            
            $('#nonBid_Ads').show();
        });
    });
});

$(document).ready(function() {
    $('#removeAd').click(function(e) {
        e.preventDefault();
        
        $('#currentContent').hide();
        $('#remove_Users').hide();
        $('#change_Password').hide();
        $('#bid_Ads').hide();
        $('#nonBid_Ads').hide();
        $('#ban_Users').hide();
        $('#viewBlacklist').hide();
        
        $('#remove_Ads').load('remove_Ads.php .removeAd', function() {
            
            $('#remove_Ads').show();
        });
    });
});
const sidebar = document.getElementById('sidebar');


function adjustSidebarClass() {
    if (window.innerWidth <= 1100) {
        sidebar.classList.remove('expand');
    } else {
        sidebar.classList.add('expand');
    }
}


adjustSidebarClass();


window.addEventListener('resize', adjustSidebarClass);


function openUserDetails(nic,rowNumber) {
    openPopup('userDetails.php?nic=' + encodeURIComponent(nic)+ '&rowNumber=' + rowNumber);
}

function openRemoveUserDetails(nic,rowNumber) {
    openPopup('userRemove_Details.php?nic=' + encodeURIComponent(nic)+ '&rowNumber=' + rowNumber);
}

function openApproveUserDetails(nic,rowNumber) {
    openPopup('userApprove_Details.php?nic=' + encodeURIComponent(nic)+ '&rowNumber=' + rowNumber);
}
function openBannedUserDetails(nic,rowNumber) {
    openPopup('bannedUser_details.php?nic=' + encodeURIComponent(nic)+ '&rowNumber=' + rowNumber);
}
function viewAdDetails(Ad_ID,rowNumber) {
    openPopup('view_ad_admin.php?Ad_ID=' + encodeURIComponent(Ad_ID)+ '&rowNumber=' + rowNumber);
}
function viewNonBidAdDetails(Ad_ID,rowNumber) {
    openPopup('view_NonBidad_admin.php?Ad_ID=' + encodeURIComponent(Ad_ID)+ '&rowNumber=' + rowNumber);
}
function viewApprovalAdDetails(Ad_ID,rowNumber) {
    openPopup('view_approval-ad_admin.php?Ad_ID=' + encodeURIComponent(Ad_ID)+ '&rowNumber=' + rowNumber);
}
function viewRemoveAdDetails(Ad_ID,rowNumber) {
    openPopup('view_remove_ad_admin.php?Ad_ID=' + encodeURIComponent(Ad_ID)+ '&rowNumber=' + rowNumber);
}

function reloadPage() {
    window.location.reload();
}


$(document).ready(function() {
    $('#changePasswordNav').on('click', function(e) {
        e.preventDefault();
        $('#changePassword').click();
    });
});

