function cryptoJSAesJson() {
    return {
        stringify: function (cipherParams) {
            var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
            if (cipherParams.iv) j.iv = cipherParams.iv.toString();
            if (cipherParams.salt) j.s = cipherParams.salt.toString();
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
            return cipherParams;
        }
    }
}

function initSpamprotect()
{
    let keyDom = document.getElementById('data-spamprotect-key');
    if (keyDom !== null && keyDom.hasAttribute('data-spamprotect-token')) {
        let encryptionKey = keyDom.getAttribute('data-spamprotect-token');
        let links = document.getElementsByTagName('a');
        for (let i = 0; i < links.length; i++) {
            let link = links[i];
            if (link.getAttribute('href') === '#' && link.hasAttribute('data-spamprotect-token')) {
                link.addEventListener("click", (event) => {
                    linkClick(event, encryptionKey);
                });
            }
        }
    }
}

function linkClick(event, encryptionKey)
{
    event.preventDefault();
    document.location = JSON.parse(CryptoJS.AES.decrypt(CryptoJS.enc.Base64.parse(event.currentTarget.getAttribute('data-spamprotect-token')).toString(CryptoJS.enc.Utf8), encryptionKey, {format: cryptoJSAesJson()}).toString(CryptoJS.enc.Utf8));
}

document.addEventListener("DOMContentLoaded", function(event) {
    initSpamprotect();
});

document.addEventListener("livewire:navigated", function() {
    initSpamprotect();
});
