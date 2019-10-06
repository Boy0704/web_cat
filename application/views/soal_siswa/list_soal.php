<div class="row">
  <?php 
  foreach ($query->result() as $row) {
   ?>
  <div class="col-lg-6 col-md-6 col-sm-6 mb">
    <div class="content-panel">
      <a href="app/soal_siswa/<?php echo $row->soal_id ?>">
      <div id="blog-bg">
        <!-- <div class="badge badge-popular">POPULAR</div> -->
        <div class="blog-title"><?php echo $row->soal ?></div>
      </div>
      <div class="blog-text">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>
    </div>
    </a>
  </div>
<?php } ?>
</div>
<div class="row" style="margin: 10px;">
  <button class="btn btn-block btn-primary" onclick="window.history.back()"><< Kembali ke Paket Soal</button>
</div>