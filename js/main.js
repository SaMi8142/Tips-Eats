
const decrement = document.getElementById('decrement');
const increment = document.getElementById('increment');
const counterValue = document.getElementById('counterValue');
var already_clicked = false;


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

function popup_logout(){
  var popup = document.getElementById("dropdown-content");

  if(already_clicked){
    popup.style.display = "none";
    already_clicked = false;
  } else {
    popup.style.display = "block";
    already_clicked = true;
  }
}