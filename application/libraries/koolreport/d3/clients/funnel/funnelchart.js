var KoolReport = KoolReport || {};
KoolReport.d3 = KoolReport.d3 || {};
KoolReport.d3.FunnelChart = KoolReport.d3.FunnelChart ||
function (name,data,settings) {
    this.name = name;
    this.data = data;
    this.settings = settings;
    this.coreChart = new D3Funnel('#'+name);
    this.draw();
    window.addEventListener("resize",this.onResize.bind(this));
};

KoolReport.d3.FunnelChart.prototype = {
    coreChart: null,
    data:null,
    settings:null,
    name:null,
    core: function () {
      return this.coreChart;
    },
    draw (data, settings) {
        var d = data?data:this.data;
        var s = settings?settings:this.settings;
        this.coreChart.draw(d,s);
    },
    onResize:function() {
        this.draw();
    }
};