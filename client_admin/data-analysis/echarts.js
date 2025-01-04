
// =============================================

var yearly_service = document.getElementById("yearly_service")
var myChart_yearly_service = echarts.init(yearly_service)
var option_yearly_service


option_yearly_service = {
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: "shadow"
        }
    },
    legend: {
        data: ['Cleaning Service', 'Maintenance Service']
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
            data: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name: "Cleaning Service",
            data: [60, 95, 93, 100, 118, 110, 113, 83, 60, 64, 48, 48],
            type: 'line',
            smooth: true,
            areaStyle: {
                color: '#abc8f7'
            },
            showSymbol: false
        },
        {
            name: "Maintenance Service",
            data: [53, 61, 90, 131, 128, 109, 113, 74, 70, 65, 51, 44],
            type: 'line',
            smooth: true,
            showSymbol: false,
            areaStyle: {
                color: '#aae8a0'
            }
        },
    ]

}
myChart_yearly_service.setOption(option_yearly_service)

// =============================================
