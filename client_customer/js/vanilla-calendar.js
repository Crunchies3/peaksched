document.addEventListener('DOMContentLoaded', function () {
  var today = new Date();
  var dd = String(today.getDate() + 1).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var yyyy = today.getFullYear();
  today = yyyy + '-' + mm + '-' + dd;

  fetch('./php_backend/fetchDisabledDates.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data && Array.isArray(data)) {
        // Extract the dates from the data
        const disabledDates = data.map(entry => entry.dates);
        console.log(disabledDates);
        // Initialize the calendar with the disabled dates
        const option = {
          settings: {
            iso8601: false,
            visibility: {
              theme: 'light',
              weekend: false,
            },
            range: {
              min: today,
              disableWeekday: [0],
              disabled: disabledDates, // Use the actual disabled dates
            },
          },
          actions: {
            clickDay(event, self) {
              var element = document.getElementById('selectedDate');
              element.setAttribute('value', self.selectedDates);
            },
          },
        };

        const calendar = new VanillaCalendar('#calendar', option);
        calendar.init();
      } else {
        console.error('Invalid JSON data:', data);
      }
    })
    .catch(error => {
      console.error('Error fetching JSON:', error);
    });
});
