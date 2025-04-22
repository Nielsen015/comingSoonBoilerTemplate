$(document).ready(function() {
    $('#subscribeForm').submit(function(e) {
        e.preventDefault();
        
        var email = $('#email').val();
        
        if (!email || !email.includes('@')) {
            alert('Please enter a valid email address');
            return;
        }
        
        // For PHP implementation (uncomment this)
        $.ajax({
            url: 'submit.php',
            method: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showSuccessPopup();
                    $('#email').val('');
                } else {
                    alert(response.message || 'There was an error. Please try again.');
                }
            },
            error: function() {
                alert('There was an error connecting to the server. Please try again.');
            }
        });
        
        
        // For Node.js implementation (uncomment this)
        /*
        $.ajax({
            url: 'http://localhost:3000/subscribe',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email: email }),
            success: function(response) {
                if (response.success) {
                    showSuccessPopup();
                    $('#email').val('');
                } else {
                    alert(response.message || 'There was an error. Please try again.');
                }
            },
            error: function() {
                alert('There was an error connecting to the server. Please try again.');
            }
        });
        */
        
        // For demonstration without server (comment this out in production)
        showSuccessPopup();
        $('#email').val('');
    });
    
    function showSuccessPopup() {
        var popup = $('#successPopup');
        popup.css('display', 'block');
        
        setTimeout(function() {
            popup.css('display', 'none');
        }, 5000);
    }
});