// Example: Form validation for payment
document.querySelector('form').addEventListener('submit', function (event) {
    const billId = document.getElementById('bill_id').value;
    const amount = document.getElementById('amount').value;

    if (!billId || !amount) {
        alert('Please fill in all fields.');
        event.preventDefault();
    }
});