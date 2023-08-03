$(function () {
   const chartDataRaw = JSON.parse($('#chart-data').val());
   const data = {
      labels: Object.values(chartDataRaw.labels),
      series: [Object.values(chartDataRaw.series)],
   };
   console.log(data)
   new Chartist.Line('.ct-chart', data);
});