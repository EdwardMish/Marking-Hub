let api_url = 'https://analytics.simplepost.co/api/logVisit';
let apiHeaders = {
    "Content-Type": "application/json"
}

var currentPage = location.href;

function getCurrentPage(ip) {
    generateSessionID(ip, window.location.pathname);
}

function generateSessionID(ip, path) {
    let session = {
        timestamp: new Date().getTime(),
        ip: ip || '',
        path,
    };
    let sessionID = window.btoa(JSON.stringify(session));
    generateVariant(ip, path, sessionID);
}

function listenForVariant(ip, path, sessionID) {
    let urlSearchParams = new URLSearchParams(window.location.search);
    let params = Object.fromEntries(urlSearchParams.entries());
    if (params?.variant) {
        saveCustomerLog(ip, path, sessionID, params.variant);
    }
    else {
        saveCustomerLog(ip, path, sessionID, '');
    }
}

function generateVariant(ip, path, sessionID) {
    listenForVariant(ip, path, sessionID);
}

function getIP() {
    fetch("https://api.ipify.org/?format=json")
        .then((response) => response.json())
        .then((response) => {
            if (response.ip) {
                getCurrentPage(response.ip);
            }
            else {
                getCurrentPage('');
            }
        })
        .catch((error) => {
            getCurrentPage('');
            console.log("Something went wrong while getting the IP Addres");
        });
}

async function saveCustomerLog(ip, path, sessionID, variant) {
    let ipAddress = await fetch("https://api.ipify.org/?format=json");

    await fetch(`${api_url}`, {
        method: 'POST',
        body: JSON.stringify({
            shopName: window.Shopify.shop,
            path: path || window.location.pathname,
            variantId: variant || '',
            sessionId: sessionID || generateSessionID(ipAddress?.json()?.ip, window.location.pathname),
            timestamp: new Date(),
            ip: ip || ipAddress?.json()?.ip,
            type: 'activity'
        }),
        headers: { ...apiHeaders }
    });
}

async function saveCartLog() {
    fetch("https://api.ipify.org/?format=json")
        .then((ipAddress) => ipAddress.json())
        .then((ipRes) => {
            let ip = ipRes?.ip || '';
            let variant = window.meta.product.id;
            let urlSearchParams = new URLSearchParams(window.location.search);
            let params = Object.fromEntries(urlSearchParams.entries());
                if (params?.variant) {
                    variant = params?.variant;
            }
            let session = {
                timestamp: new Date().getTime(),
                ip,
                path: window.location.pathname,
            };
            let sessionID = window.btoa(JSON.stringify(session));
            fetch(`${api_url}saveCustomerLog`, {
                method: 'POST',
                body: JSON.stringify({
                    shopName: window.Shopify.shop,
                    path: window.location.pathname,
                    variantId: variant || '',
                    sessionId: sessionID,
                    timestamp: new Date(),
                    ip,
                    type: 'add to cart'
                }),
                headers: { ...apiHeaders }
            });
        })
}

getIP();

setInterval(function () {
    if (currentPage != location.href) {
        currentPage = location.href;
        listenForVariant();
    }
}, 500);


//every time a customer clicks
window.addEventListener('click', () => {
    
    //check if we're on the product page
    if(window.location.href.indexOf("products") > -1) {
        
        function checkCart(){
            //check if there are items in the cart
            jQuery.getJSON('/cart.js', function(cart) {
                if(cart.item_count > 0){
                    saveCartLog();
                }
            });
        }

        setTimeout(function(){ checkCart(); }, 1000);

    }

});