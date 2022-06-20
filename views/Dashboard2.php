<?php

namespace PHPMaker2021\eclearance;

// Page object
$Dashboard2 = &$Page;
?>
<style>
li {
    padding: 0px !important;
}

table th,
td {
    width: 120px;
    max-width: 120px;
    min-width: 120px;
    white-space: nowrap;
    text-overflow: ellipsis;
    word-break: break-all;
    overflow: hidden;
}

table tfoot th {
    padding: 0px !important;
}

table tfoot th input {
    width: 100% !important;
    height: 43px !important;
}
</style>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<script src="https://code.jquery.com/jquery-3.6.0.js"
integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.2.0/dist/echarts.min.js"></script>    
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">         
            <div class="card">
                <divv class="card-header bg-transparent border-0">
                    <button class="btn btn-info btn-sm" id="btnBackToYear">
                        <i class="fas fa-chevron-left"></i> Kembali
                    </button>
                </divv>
                <div class="card-body boxChart">
                    <div id="chart1" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {            
        var lebel = []
        var dataSet = []
        var chartReady = false
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var urlApi = "api/"
        var grafikUrlYear = "grafik-tahun"
        var grafikUrlMonth = "grafik-bulan"

        $("#btnBackToYear").hide();

        fetchAPIYear()

        $("#btnBackToYear").click(function(){
            $('#chart1').remove();
            $("#btnBackToYear").hide();
            fetchAPIYear()
        })

        function fetchAPIYear(){
            lebel = []
            dataSet = []
            axios.get(urlApi + grafikUrlYear, function (result) {
            }).then((result) => {
                result.data.sort(function(a, b){return a.tahun - b.tahun});
                result.data.forEach(element => {
                    lebel.push(element.tahun)
                    dataSet.push(parseInt(element.total))
                });
                initChart({ lebel: lebel, dataset: dataSet, isYear : true })
            }).catch((e) => {
                console.log(e)
            });
        }

        function fetchAPIMonth(param){
            lebel = []
            dataSet = []
            axios.get(urlApi + grafikUrlMonth + "?tahun=" + param.tahun, function (result) {
            }).then((result) => {
                result.data.sort(function(a, b){return a.bulan - b.bulan});
                result.data.forEach(element => {
                    lebel.push(bulan[element.bulan - 1]+ " - " +param.tahun)
                    dataSet.push(parseInt(element.total))
                });
                initChart({ lebel: lebel, dataset: dataSet, isYear : false  })
            }).catch((e) => {
                console.log(e)
            });
        }

        function initChart(data) {
            $("#chart1").show();
            $('.boxChart').append('<div id="chart1" style="height: 350px;"><div>');
            var myChart = echarts.init(document.getElementById('chart1'));

            option = {
				title: {
					text: 'Grafik Data Pemohon SKK',
					subtext: 'Klik Bar Untuk Melihat Data per Bulan',
					left: 'center'
				},
				legend: {
					top: 70,
					data: ['Data Pemohon SKK']
				},
				 grid: {
					bottom: 70,
					top: 120
				},
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                xAxis: [
                    {
                        type: 'category',
                        data: data.lebel,
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: 'Data Pemohon SKK',
                        type: 'bar',
						itemStyle: {
							color: '#5d62b5'
						}, 
                        data: data.dataset,
                        barWidth: 70,
                        barCategoryGap: '10%',
                    }
                ]
            };

            myChart.setOption(option);

            myChart.on('click', function (params) {
            	if(data.isYear){
                    showMountChart(params)
                }
            })
        }

        function showMountChart(data) {
            $('#chart1').remove();
            $("#btnBackToYear").show();
            fetchAPIMonth({tahun : data.name});
        }
    })
</script>

<?= GetDebugMessage() ?>
