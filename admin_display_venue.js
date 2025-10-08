// Function to load image preview
function loadFile(event) {
var output = document.getElementById('output');
output.src = URL.createObjectURL(event.target.files[0]);
output.onload = function() {
URL.revokeObjectURL(output.src); // free memory
}
output.style.display = 'block'; // Show the image
}

// JavaScript to handle modal open and close
document.addEventListener('DOMContentLoaded', (event) => {
const modal1 = document.getElementById('modal1');
const modal2 = document.getElementById('modal2');
const openModal1 = document.getElementById('openModal1');
const openModal2 = document.getElementById('openModal2');
const closeButtons = document.querySelectorAll('.close-button');
const content = document.querySelector('.content');

// Function to open modal
const openModal = (modal) => {
  modal.style.display = 'flex';
  content.style.filter = 'blur(5px)';
};

// Function to close modal
const closeModal = (modal) => {
  modal.style.display = 'none';
  content.style.filter = 'none';
};

// Event listeners to open modals
openModal1.addEventListener('click', () => openModal(modal1));
openModal2.addEventListener('click', () => openModal(modal2));

// Event listeners to close modals
closeButtons.forEach(button => {
  button.addEventListener('click', (e) => {
    e.preventDefault();
    const modal = button.closest('.modal-container');
    closeModal(modal);
  });
});
});

window.addEventListener("resize", resizeFunc);
