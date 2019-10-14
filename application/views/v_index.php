<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Boy Kurniawan">
  <meta name="keyword" content="aplikasi CAT">
  <title>Ujian - CAT</title>
  <base href="<?php echo base_url() ?>">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="assets/lib/gritter/css/jquery.gritter.css" />
  <!-- <link href="assets/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" /> -->
  <!-- <link href="assets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" /> -->
  <!-- <link rel="stylesheet" href="assets/lib/advanced-datatable/css/DT_bootstrap.css" /> -->
  <!-- Custom styles for this template -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/style-responsive.css" rel="stylesheet">
  <script src="assets/lib/chart-master/Chart.js"></script>
  <script src="assets/lib/jquery/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <?php $this->load->view('page/header'); ?>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <?php $this->load->view('page/side'); ?>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!-- <h3><i class="fa fa-angle-right"></i> <?php echo $judul_page ?></h3> -->
        <br>
        <div class="row">
          <div class="col-md-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i> <?php echo $judul_page ?></h4>
              <hr>
              <div style="margin-left: 10px; margin-right: 10px;">
              <?php $this->load->view($konten); ?>
              </div>
              
            </div>
          </div>
          <!-- /col-md-12 -->
          
          <!-- /col-md-12 -->
        </div>
        <!-- row -->
        <!-- /row -->
        
      </section>

    </section>
    <!--main content end-->
    <!--footer start-->
    <?php //$this->load->view('page/footer'); ?>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  
  <!-- <script type="text/javascript" language="javascript" src="assets/lib/advanced-datatable/js/jquery.js"></script>
  <script type="text/javascript" language="javascript" src="assets/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="assets/lib/advanced-datatable/js/DT_bootstrap.js"></script> -->
  <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="assets/lib/jquery.scrollTo.min.js"></script>
  <script src="assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="assets/lib/common-scripts.js"></script>
  <script type="text/javascript" src="assets/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="assets/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="assets/lib/sparkline-chart.js"></script>
  <script src="assets/lib/zabuto_calendar.js"></script>
  <script src="https://cdn.tiny.cloud/1/4mo39ri6dgnfnyfqwhr6nhicdjgg3nckwd3ruoyr8sa3d5z7/tinymce/5/tinymce.min.js"></script>
  <?php 
  if ($this->uri->segment(1) == '') {
  ?>
  <script type="text/javascript">
    $(document).ready(function() {

      var unique_id = $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: 'Selamat Datang <?php echo $this->session->userdata('nama'); ?> !',
        // (string | mandatory) the text inside the notification
        text: '.',
        // (string | optional) the image to display on the left
        image: 'assets/img/user.gif',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: 8000,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
      });

      return false;
    });
  </script>
  <?php } ?>

  <script>
  $(document).ready(function(){
    $('.tabel-data').DataTable();
});
  </script>

  <script type="text/javascript">
    tinymce.init({
        selector: ".textarea_editor",
        plugins: [
             "advlist autolink lists link image charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars code fullscreen",
             "insertdatetime nonbreaking save table contextmenu directionality",
             "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
        images_upload_url: '<?php echo base_url() ?>app/tinymce_upload',
        images_upload_base_path: '<?php echo base_url() ?>',
        images_upload_credentials: true
   });
</script>
  
</body>

</html>
