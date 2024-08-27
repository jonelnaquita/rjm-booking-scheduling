document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-minus').addEventListener('click', function() {
      var passengerCount = document.getElementById('passenger-count');
      var passengerNumber = document.getElementById('passenger-number');
      var currentValue = parseInt(passengerCount.value);
      if (currentValue > 1) {
        passengerCount.value = currentValue - 1;
        passengerNumber.textContent = passengerCount.value;
      }
    });
  
    document.getElementById('btn-plus').addEventListener('click', function() {
      var passengerCount = document.getElementById('passenger-count');
      var passengerNumber = document.getElementById('passenger-number');
      var currentValue = parseInt(passengerCount.value);
      passengerCount.value = currentValue + 1;
      passengerNumber.textContent = passengerCount.value;
    });
  });
  