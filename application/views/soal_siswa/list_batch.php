<div class="row">
  <?php 
  if ($query->num_rows() == 0) {
  ?>
  <div class="alert alert-info">Anda Tidak memiliki akses Batch, Silahkan hubungi administrator</div>
  <?php 
  } else {
  foreach ($query->result() as $row) {
   ?>
  <div class="col-lg-6 col-md-6 col-sm-6 mb">
    <div class="content-panel">
      <a href="app/paket_soal/<?php echo base64_encode($row->batch_id) ?>">
      <div id="blog-bg">
        <!-- <div class="badge badge-popular">POPULAR</div> -->
        <div class="blog-title"><?php echo $row->nama_batch ?></div>
      </div>
      <div class="blog-text">
        <p><?php echo $row->nama_batch ?></p>
      </div>
    </div>
    </a>
  </div>
<?php } 
  }
?>
</div>