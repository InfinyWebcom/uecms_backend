<script src="<?php echo base_url(); ?>app-assets/js/Chart.min.js"></script>

<div id="main">
    <div class="row">
        <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <h5 class="breadcrumbs-title mt-0 mb-0">
                            <span class="highlightedText">Dashboard</span>
                        </h5>
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="card-alert card green lighten-5 flashMsg">
                                <div class="card-content green-text">
                                  <p><?php echo $this->session->flashdata('success'); ?></p>
                                </div>
                            </div>
                        <?php elseif($this->session->flashdata('error')): ?>
                            <div class="card-alert card red lighten-5 flashMsg">
                                <div class="card-content red-text">
                                  <p><?php echo $this->session->flashdata('error'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <div class="row vertical-modern-dashboard">
                        <div class="col s12 m12 l12 animate fadeRight">
                            <div class="card">
                                <div class="card-content">
                                    
                                    <div class="col s6 m3 l3" style="margin-bottom: 20px;">
                                        <select id="month">
                                            <?php if(empty($months)){ ?>
                                                <option value="" selected>Select Month</option>
                                            <?php } ?>
                                            <?php foreach ($months as $key => $value) { ?>
                                                <?php if(date("Y-m-d", strtotime($value)) == $date){ ?>
                                                    <option value="<?php echo date("Y-m-d", strtotime($value)); ?>" selected><?php echo $value; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo date("Y-m-d", strtotime($value)); ?>"><?php echo $value; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="chart-container">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var graphData= <?php echo json_encode($graphData); ?>;
var graphLabels= <?php echo json_encode($graphLabels); ?>;
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: graphLabels,
        datasets: [{
            data: graphData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1,
            showLine: false
        }]
    },
    options: {
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
               label: function(tooltipItem) {
                    return tooltipItem.yLabel;
               }
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    showBorder:true,
                    display:false
                }
            }],
            yAxes: [{
                gridLines: {
                    showBorder:true,
                    display:true
                }   
            }]
        }
    }
});
// function renderGraph(){
//     var date = $(document).find('#month').val();
//     if(date.length>0){
//         $.ajax({
//             url: BASE_URL + 'home/getGraphData',
//             type: 'POST',
//             dataType: "json",
//             data: {date : date},
//             success: function (data) {
//                 if(data.errcode==0){
//                     if(myChart){
//                         myChart.data = data.result.data;
//                         myChart.update();
//                     }else{
//                         console.log('vvv',myChart);
//                         var ctx = document.getElementById('myChart').getContext('2d');
//                         var myChart = new Chart(ctx, {
//                             type: 'bar',
//                             data: {
//                                 labels: data.result.labels,
//                                 datasets: [{
//                                     data: data.result.data,
//                                     backgroundColor: [
//                                         'rgba(255, 99, 132, 0.2)',
//                                         'rgba(54, 162, 235, 0.2)',
//                                         'rgba(255, 206, 86, 0.2)',
//                                         'rgba(153, 102, 255, 0.2)',
//                                     ],
//                                     borderColor: [
//                                         'rgba(255, 99, 132, 1)',
//                                         'rgba(54, 162, 235, 1)',
//                                         'rgba(255, 206, 86, 1)',
//                                         'rgba(153, 102, 255, 1)',
//                                     ],
//                                     borderWidth: 1,
//                                     showLine: false
//                                 }]
//                             },
//                             options: {
//                                 legend: {
//                                     display: false
//                                 },
//                                 tooltips: {
//                                     callbacks: {
//                                        label: function(tooltipItem) {
//                                             return tooltipItem.yLabel;
//                                        }
//                                     }
//                                 },
//                                 scales: {
//                                     xAxes: [{
//                                         gridLines: {
//                                             showBorder:true,
//                                             display:false
//                                         }
//                                     }],
//                                     yAxes: [{
//                                         gridLines: {
//                                             showBorder:true,
//                                             display:true
//                                         }   
//                                     }]
//                                 }
//                             }
//                         });
//                     }
//                 }
//             }
//         });
//     }
    
// }
$(document).ready(function(){
    // renderGraph();
    $(document).on('change', '#month', function(){
        location.href = BASE_URL + 'home/dashboard/'+$(document).find('#month').val();
        // renderGraph();
    });
});
</script>