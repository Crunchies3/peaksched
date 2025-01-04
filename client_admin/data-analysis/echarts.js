var demand_per_service = document.getElementById("demand-per-service")
var myChart_demand_per_service = echarts.init(demand_per_service)
var option_demand_per_service
option_demand_per_service = {
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
            data: ["Regular", "Detailed", "Air-BNB", "Move-in/out", "Other"],
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
            data: [100, 52, 88, 69, 80, 90]
        }
    ]
}

option_demand_per_service && myChart_demand_per_service.setOption(option_demand_per_service)

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

var yearly_service2 = document.getElementById("yearly_service-2")
var myChart_yearly_service2 = echarts.init(yearly_service2)
var option_yearly_service2


option_yearly_service2 = {
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: "shadow"
        }
    },
    legend: {
        data: ['Regular Cleaning', 'Detailed Cleaning', 'Air-BNB cleaning', 'Move-in/out cleaning', 'Other']
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
            name: "Regular Cleaning",
            data: [69, 93, 132, 161, 152, 133, 111, 113, 92, 75, 60, 55],
            type: 'line',
            smooth: true,
            showSymbol: false
        },
        {
            name: "Detailed Cleaning",
            data: [53, 61, 90, 131, 128, 109, 113, 74, 70, 65, 51, 44],
            type: 'line',
            smooth: true,
            showSymbol: false
        },
        {
            name: "Air-BNB cleaning",
            data: [2, 5, 15, 11, 15, 16, 21, 22, 5, 2, 8, 3],
            type: 'line',
            smooth: true,
            showSymbol: false
        },
        {
            name: "Move-in/out cleaning",
            data: [3, 3, 3, 4, 4, 6, 9, 8, 10, 8, 4, 3],
            type: 'line',
            smooth: true,
            showSymbol: false
        },
        {
            name: "Other",
            data: [6, 5, 2, 3, 4, 2, 3, 1, 4, 7, 5, 3],
            type: 'line',
            smooth: true,
            showSymbol: false
        },



    ]

}
myChart_yearly_service2.setOption(option_yearly_service2)