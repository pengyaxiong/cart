$.get('/api/customer_province').done(function (data) {
   // console.log(data);
    var myChart = echarts.init(document.getElementById('customer_province'), 'macarons');
    // 指定图表的配置项和数据
    myChart.setOption({
        title: {
            text: '会员省份统计',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            x:'right',
            selectedMode:false,
            data: ['会员数量']
        },
        dataRange: {
            orient: 'horizontal',
            min: 0,
            max: 55000,
            text:['高','低'],           // 文本，默认为数值文本
            splitNumber:0
        },
        toolbox: {
            show : true,
            orient: 'vertical',
            x:'right',
            y:'center',
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false}
            }
        },
        series: [
            {
                name: '会员数量',
                type: 'map',
                mapType: 'china',
                mapLocation: {
                    x: 'left'
                },
                selectedMode : 'multiple',
                itemStyle:{
                    normal:{label:{show:true}},
                    emphasis:{label:{show:true}}
                },
                data: data
            }
        ],
        animation: true
    });
});