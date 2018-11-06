
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var promotores = parseInt(document.getElementById("promotores").innerHTML);
  var detratores = parseInt(document.getElementById("detratores").innerHTML);
  var neutros = parseInt(document.getElementById("neutros").innerHTML);
  
  var data = google.visualization.arrayToDataTable([
    ['Avaliação', 'Notas 0 - 10'],
    ['Promotores',     promotores],
    ['Detratores',     detratores],
    ['Neutros',  neutros]
  ]);

  var options = {
    title: 'Resultados'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}

