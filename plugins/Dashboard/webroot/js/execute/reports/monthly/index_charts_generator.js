"use strict";

$(function () {
   const receiptChartData = JSON.parse($('#receipt-chart-data').val());
   const advertisingChartData = JSON.parse($('#advertising-chart-data').val());
   const receiptData = {
      labels: Object.values(receiptChartData.labels),
      series: [Object.values(receiptChartData.series)],
   };
   const advertisingData = {
      labels: Object.values(advertisingChartData.labels),
      series: [Object.values(advertisingChartData.series)]
   }
   const config = {
      low: 0,
      axisY: {
         showLabel: false,
         offset: 0,
      },
   };
   new Chartist.Line('#monthlyReceiptTotals', receiptData, config);
   new Chartist.Line('#monthlyAdvertisingCosts', advertisingData, config);
});