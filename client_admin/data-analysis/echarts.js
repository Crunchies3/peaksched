var chartDom = document.getElementById("demand-per-service")
var myChart = echarts.init(chartDom)
var option

option = {
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: "shadow"
        }
    },
    grid: {
        left: "3%",
        right: "4%",
        bottom: "3%",
        containLabel: true
    },
    xAxis: [
        {
            type: "category",
            data: ["Regular", "Detailed", "Air-BNB", "Carpet", "Move-in/out", "Window", "Bathroom"],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis: [
        {
            type: "value"
        }
    ],
    series: [
        {
            type: "bar",
            barWidth: "60%",
            data: [100, 52, 88, 69, 80, 90, 78]
        }
    ]
}

option && myChart.setOption(option)