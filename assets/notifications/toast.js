// Function to create and display a toast notification
function showToast(type, message) {
    const toastContainer = document.getElementById('toast-container');

    // Create a new toast element
    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.innerText = message;

    // Append the toast to the container
    toastContainer.appendChild(toast);

    // Remove the toast after 5 seconds
    setTimeout(() => {
        toast.remove();
    }, 5000); // 5 seconds
}
