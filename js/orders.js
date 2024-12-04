const loadOrders = (status = "Pending") => {
  fetch('path/to/your/php/file.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ status }),
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === 'success') {
          document.querySelector('.orders-section').innerHTML = data.html;
      } else {
          console.error(data.message);
      }
  })
  .catch(error => {
      console.error('Fetch error:', error);
  });
};

// Load pending orders by default
document.addEventListener('DOMContentLoaded', () => {
  loadOrders();
});

// Add event listener to buttons to load orders based on status
document.querySelectorAll('.order-btn').forEach(button => {
  button.addEventListener('click', () => {
      loadOrders(button.value);
  });
});
