// Get the form element
const form = document.getElementById('contact-form');

// Add event listener for form submission
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission

  // Get form data
  const formData = new FormData(form);

  // Validate form data (you can add your own validation logic here)
  const name = formData.get('name');
  const email = formData.get('email');
  const message = formData.get('message');

  if (!name || !email || !message) {
    alert('Please fill in all fields');
    return;
  }

  // Create an AJAX request
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/form/sendEmail.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  const params = new URLSearchParams(formData).toString();

  // Handle AJAX response
  xhr.onload = function() {
    if (xhr.status == 200) {
      alert('Email sent successfully');
      form.reset(); // Reset the form
    } else {
      alert('Failed to send email. Status: ' + xhr.status.toString());
    }
  };

  // Send the AJAX request with form data
  xhr.send(params);
});