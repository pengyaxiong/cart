$.get('/api/statistics_product').done(function (data) {
  console.log(data);
    var product = [];
    var num = [];
    var name = [];

    $.each(data, function (k, v) {
        product.push(v.nickname);
        num.push(v.products_count)
        name.push(v.nickname)
    })

    var myChart = echarts.init(document.getElementById('statistics_product'), 'macarons');
    myChart.setOption(
        {
            title: {
                text: '用户上传情况',
                subtext: '上传数量'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['用户']
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            xAxis: [
                {
                    type: 'category',
                    data: product
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name:  '上传数量',
                    type: 'bar',
                    data: num,
                    markPoint: {
                        data: [
                            {type: 'max', name: '最大值'},
                            {type: 'min', name: '最小值'}
                        ]
                    },
                    markLine: {
                        data: [
                            {type: 'average', name: '平均值'}
                        ]
                    }
                }
            ]
        }
    );
});