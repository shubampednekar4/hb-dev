"use strict";

$(function () {
    const franchiseChartData = (JSON.parse($("#franchise-chart-data").val()));
    const franchiseData = {
        labels: Object.values(franchiseChartData.labels),
        series: [Object.values(franchiseChartData.series)],
    };
    const config = {
        low: 0,
        axisY: {
            offset: 50,
        },
    };
    let chart = new Chartist.Line("#franchises", franchiseData, config);
    let seq = 0, delays = 80, durations = 500;
    chart.on('created', function () {
        seq = 0;
    });
    chart.on('draw', function (data) {
       seq++;
       if (data.type === 'line') {
           data.element.animate({
               opacity: {
                   // The delay when we like to start the animation
                   begin: seq * delays + 1000,
                   // Duration of the animation
                   dur: durations,
                   // The value where the animation should start
                   from: 0,
                   // The value where it should end
                   to: 1
               }
           });
       } else if (data.type === 'label' && data.axis === 'x') {
           data.element.animate({
               x: {
                   begin: seq * delays,
                   dur: durations,
                   from: data.x - 100,
                   to: data.x,
                   easing: 'easeOutQuart',
               }
           });
       } else if(data.type === 'point') {
           data.element.animate({
               x1: {
                   begin: seq * delays,
                   dur: durations,
                   from: data.x - 10,
                   to: data.x,
                   easing: 'easeOutQuart'
               },
               x2: {
                   begin: seq * delays,
                   dur: durations,
                   from: data.x - 10,
                   to: data.x,
                   easing: 'easeOutQuart'
               },
               opacity: {
                   begin: seq * delays,
                   dur: durations,
                   from: 0,
                   to: 1,
                   easing: 'easeOutQuart'
               }
           });
       } else if(data.type === 'grid') {
           // Using data.axis we get x or y which we can use to construct our animation definition objects
           let pos1Animation = {
               begin: seq * delays,
               dur: durations,
               from: data[data.axis.units.pos + '1'] - 30,
               to: data[data.axis.units.pos + '1'],
               easing: 'easeOutQuart'
           };

           let pos2Animation = {
               begin: seq * delays,
               dur: durations,
               from: data[data.axis.units.pos + '2'] - 100,
               to: data[data.axis.units.pos + '2'],
               easing: 'easeOutQuart'
           };

           let animations = {};
           animations[data.axis.units.pos + '1'] = pos1Animation;
           animations[data.axis.units.pos + '2'] = pos2Animation;
           animations['opacity'] = {
               begin: seq * delays,
               dur: durations,
               from: 0,
               to: 1,
               easing: 'easeOutQuart'
           };
           data.element.animate(animations);
       }
    });
});