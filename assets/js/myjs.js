// Get the reclamation link element
var reclamationLink = document.getElementById("reclamation-link");

// Handle the click event for the "Reclamation" link
reclamationLink.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default link behavior (e.g., navigating to a new page)
    alert("Veuillez vous connecter"); // Display an alert message
    // You can add further logic here if needed
});


//form field error handling goes here

  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the form from submitting initially
      
      // Reset any existing error messages
      const errorMessages = document.querySelectorAll('.error-message');
      errorMessages.forEach((element) => {
        element.style.display = 'none';
      });

      // Validate each input field
      const acYear = document.getElementById('ac_year').value;
      const acLevel = document.getElementById('ac_level').value;
      const mat = document.getElementById('mat').value;
      const field = document.getElementById('field').value;
      const speciality = document.getElementById('speciality').value;
      const examType = document.getElementById('exam_type').value;
      const complainType = document.getElementById('complain_type').value;
      const ecueSub = document.getElementById('ecue_sub').value;
      const ecue = document.getElementById('ecue').value;

      if (!acYear) {
        displayError('ac_year', 'Please select an academic year.');
      }

      if (!acLevel) {
        displayError('ac_level', 'Please select an academic level.');
      }

      if (!mat || !/^\d{8}$/.test(mat)) {
        displayError('mat', 'Please enter a valid matricule (8 digits).');
      }

      if (!field) {
        displayError('field', 'Please select a field.');
      }

      if (!speciality) {
        displayError('speciality', 'Please select a speciality.');
      }

      if (!examType) {
        displayError('exam_type', 'Please select a session type.');
      }

      if (!complainType) {
        displayError('complain_type', 'Please select a complaint type.');
      }

      if (!ecueSub) {
        displayError('ecue_sub', 'Please enter a valid UE.');
      }

      if (!ecue) {
        displayError('ecue', 'Please enter a valid ECUE.');
      }

      // If there are no error messages, you can submit the form
      if (document.querySelectorAll('.error-message:hidden').length === 0) {
        form.submit();
      }
    });

    function displayError(inputId, message) {
      const errorMessage = document.getElementById(inputId + '-error');
      errorMessage.textContent = message;
      errorMessage.style.display = 'block';
    }
  });

