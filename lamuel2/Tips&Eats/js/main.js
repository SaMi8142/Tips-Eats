
const decrement = document.getElementById('decrement');
const increment = document.getElementById('increment');
const counterValue = document.getElementById('counterValue');

decrement.addEventListener('click', (event) => {
  event.preventDefault(); // Prevent default button behavior
  const currentValue = parseInt(counterValue.value, 10);
  if (currentValue > 1) {
    counterValue.value = currentValue - 1;
  }
});

increment.addEventListener('click', (event) => {
  event.preventDefault(); // Prevent default button behavior
  const currentValue = parseInt(counterValue.value, 10);
  counterValue.value = currentValue + 1;
});