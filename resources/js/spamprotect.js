async function decrypt(token, encryptionKey) {
    const cipher = JSON.parse(atob(token));
    const iv = new Uint8Array(cipher.iv.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
    const ct = new Uint8Array(atob(cipher.ct).split('').map(c => c.charCodeAt(0)));
    const alg = { name: 'AES-CBC', iv: iv };

    const pwUtf8 = new TextEncoder().encode(encryptionKey);
    const pwHash = await window.crypto.subtle.digest('SHA-256', pwUtf8);
    const key = await window.crypto.subtle.importKey('raw', pwHash, alg, false, ['decrypt']);
    const ptBuffer = await window.crypto.subtle.decrypt(alg, key, ct);
    return new TextDecoder().decode(ptBuffer);
}

function initSpamProtect()
{
    let keyDom = document.getElementById('spamprotect-key');
    if (keyDom !== null && keyDom.hasAttribute('data-spamprotect-token')) {
        let encryptionKey = keyDom.getAttribute('data-spamprotect-token');
        let links = document.querySelectorAll('a[data-spamprotect-token]');
        links.forEach(function (link) {
            if (link.getAttribute('href') === '#' && !link.hasAttribute('data-spamprotect-clickevent')) {
                link.setAttribute('data-spamprotect-clickevent', 'true');
                link.addEventListener("click", (event) => {
                    linkClick(event, link.getAttribute('data-spamprotect-token'), encryptionKey);
                });
            }
        })
    }
}

function linkClick(event, token, encryptionKey) {
    event.preventDefault();
    decrypt(token, encryptionKey).then(function (target) {
        document.location = target;
    });
}

document.addEventListener("DOMContentLoaded", function(event) {
    initSpamProtect();
});

document.addEventListener("livewire:navigated", function() {
    initSpamProtect();
});
