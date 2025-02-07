<!DOCTYPE html>
<html>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<body>

<div id="myPlot" style="width:100%;max-width:700px"></div>

<script>
const xArray = ["Italy", "France", "Spain", "USA", "Argentina", "Europe", "Argentina"];
const yArray = [55, 49, 44, 24, 15, 10, 10];

const data = [{
  x:xArray,
  y:yArray,
  type:"bar",
  orientation:"v",
  marker: {color:"rgba(0,0,255,0.6)"}
}];

const layout = {title:"World Wide Wine Production"};

Plotly.newPlot("myPlot", data, layout);


window.addEventListener("unload", function () {
    console.log("User has closed the tab.");
    navigator.sendBeacon("/log_exit", JSON.stringify({ userId: 123 }));
});




</script>

</body>
</html>
