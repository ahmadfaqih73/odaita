<!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>admin/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/'); ?>admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script type="text/javascript">


// Area Chart Example
var dt=[];
var lbl=[];

$.ajax({
url : "<?= site_url()?>admin/Fuzzy/getData",
success : function(s)
{
    //alert(s);
    var dat = s.split("|");
    
    
    for(var a =0;a<dat.length;a++)
    {

      if(dat[a] != "")
      {
        var datTemp = dat[a].split("~");
        lbl[a] = datTemp[0];
        dt[a] = datTemp[1];
      }
    }

    var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: lbl,
    datasets: [{
      label: "Jumlah",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.2)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: dt,
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
          
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
            
        }
      }],
      yAxes: [{
        ticks: {
            beginAtZero: true,
            stepSize : 1,
          padding: 10,
        
          
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + tooltipItem.yLabel;
        }
      }
    }
  }
});

}

});

    </script>



    <script type="text/javascript">
  // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';



// Area Chart Example
var dtPie=[];
var lblPie=[];

$.ajax({
url : "<?= site_url()?>admin/Fuzzy/getJkel",
success : function(s)
{
    //alert(s);
    var dat = s.split("|");
    
    
    for(var a =0;a<dat.length;a++)
    {
      if(dat[a] != "")
      {
        var datTemp = dat[a].split("~");
        lblPie[a] = datTemp[0];
        dtPie[a] = datTemp[1];
      }
    }


// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: lblPie,
    datasets: [{
      data: dtPie,
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true
    },
    cutoutPercentage: 80,
  },
});

}
});
  
  </script>