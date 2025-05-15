$(document).on('click', '.receive-btn', function(e) {
    e.preventDefault();
    const transferItemId = $(this).data('tid');
    if (transferItemId) {
        window.location.href = REC_ADD_URL + transferItemId;
    } else {    
        alert('Transfer Item ID is missing.');
    }
});