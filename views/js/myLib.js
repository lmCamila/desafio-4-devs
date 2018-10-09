
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
    title: 'Avaliação'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}


window.onload(function(){
  var nsp = parseFloat(document.getElementById("nsp").innerHTML);
  
  if(nsp < 60){
    document.getElementsByClassName('classidicar').css("background-color","#FF0000");
  }else if(nsp >=60 || nsp <= 79.99){
    document.getElementsByClassName('classidicar').css("background-color","#FFFF00") ;
  }
  else if(nsp >= 80){
    document.getElementsByClassName('classidicar').css("background-color","#00FF00");  }
})