document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  const alertBox = document.getElementById('alert-box');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch('modifier_nouveau.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showAlert(data.success, 'success');
      } else if (data.error) {
        showAlert(data.error, 'error');
      }
    })
    .catch(err => {
      showAlert("❌ Une erreur s'est produite", 'error');
    });
  });

  function showAlert(message, type) {
    alertBox.textContent = message;
    alertBox.style.display = 'block';
    alertBox.style.backgroundColor = type === 'success' ? '#d4edda' : '#f8d7da';
    alertBox.style.color = type === 'success' ? '#155724' : '#721c24';
    alertBox.style.border = '1px solid ' + (type === 'success' ? '#c3e6cb' : '#f5c6cb');
    alertBox.style.padding = '10px';
    alertBox.style.margin = '15px auto';
    alertBox.style.textAlign = 'center';
    alertBox.style.borderRadius = '5px';

    setTimeout(() => {
      alertBox.style.display = 'none';
    }, 4000);
  }
});
