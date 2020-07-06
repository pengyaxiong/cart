// 基于准备好的dom，初始化echarts实例

$.get('/api/sex_count').done(function (data) {
    var myChart = echarts.init(document.getElementById('sex_count'), 'macarons');

    // 指定图表的配置项和数据
    myChart.setOption({
        title: {
            text: '会员性别统计',
            x: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['男', '女']
        },
        series: [
            {
                name: '访问来源',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: [
                    {value: data.male, name: '男'},
                    {value: data.female, name: '女'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    });
});