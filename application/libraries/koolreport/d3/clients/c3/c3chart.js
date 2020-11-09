var KoolReport = KoolReport || {};
KoolReport.d3 = KoolReport.d3 || {};
KoolReport.d3.C3Chart = KoolReport.d3.C3Chart ||
function (settings) {
    this.settings = settings;
    this.c3chart = c3.generate(settings);
};

KoolReport.d3.C3Chart.prototype = {
    settings: null,
    c3chart: null,
    chart: function () {
      return this.c3chart;
    },
};