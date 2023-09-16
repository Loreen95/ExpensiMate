// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Function to adjust the mainHeader position
    function adjustMainHeaderPosition() {
        var mainHeader = document.querySelector('.mainHeader'); // Replace with your header selector
        var cookieConsent = document.querySelector('.js-cookie-consent');

        if (cookieConsent && window.getComputedStyle(cookieConsent).display !== 'none') {
            // If the cookie consent dialog is visible
            var cookieConsentHeight = cookieConsent.clientHeight;
            mainHeader.style.marginTop = cookieConsentHeight + 'px';
        } else {
            // If the cookie consent dialog is not visible or doesn't exist
            mainHeader.style.marginTop = '0';
        }
    }

    // Call the function when the page loads
    adjustMainHeaderPosition();

    // Call the function when the window is resized (in case the dialog visibility changes)
    window.addEventListener('resize', adjustMainHeaderPosition);
});