"use strict";

$(function () {
    const receiptRawData = JSON.parse($('#receipt-chart-data').val());
    const receiptChartData = {
        labels: Object.values(receiptRawData.labels),
        series: Object.values(receiptRawData.series),
    };
    const config = {
        low: 0,
        axisY: {
            showLabel: true,
            offset: 60,
        },
    };
    new Chartist.Line('#receipts', receiptChartData, config);
    const advertisingRawData = JSON.parse($("#advertising-chart-data").val());
    const advertisingChartData = {
        labels: Object.values(advertisingRawData.labels),
        series: Object.values(advertisingRawData.series),
    }
    new Chartist.Line("#advertising", advertisingChartData, config);
});