let api_url = 'https://local.app.simplepost.co/';
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

    await fetch(`${api_url}saveCustomerLog`, {
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
            let variant = '';
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

let addToCartText = ['Add to cart', 'ADD TO CART', 'Add To Cart', 'add to cart'];

let buttonElem = document.querySelector(`button[aria-label="${addToCartText[0]}"]`) || document.querySelector(`button[aria-label="${addToCartText[1]}"]`) || document.querySelector(`button[aria-label="${addToCartText[2]}"]`) || document.querySelector(`button[aria-label="${addToCartText[3]}"]`);

buttonElem?.addEventListener('click', () => {
    saveCartLog();
})
