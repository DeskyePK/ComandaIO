document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var errorMessage = document.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }, 3000);
});