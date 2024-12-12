// Close buttons for all modals
document.querySelectorAll('.close-btn').forEach(button => {
    button.addEventListener('click', () => {
        button.closest('.modal').style.display = 'none';
    });
});

// View buttons to open modals
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', () => {
        const targetModal = document.querySelector(button.getAttribute('data-target'));
        targetModal.style.display = 'block';
    });
});

// Close modals when clicking outside of them
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
};
