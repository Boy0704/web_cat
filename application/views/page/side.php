<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href=""><img src="assets/img/user.gif" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $this->session->userdata('nama'); ?></h5>
          <?php 
          if ($this->session->userdata('level') == 'admin') {
            ?>
          <li class="mt">
            <a href="">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li>
            <a href="siswa">
              <i class="fa fa-user"></i>
              <span>Siswa</span>
              </a>
          </li>
          <li>
            <a href="guru">
              <i class="fa fa-users"></i>
              <span>Guru</span>
              </a>
          </li>
          <li>
            <a href="mapel">
              <i class="fa fa-paste"></i>
              <span>Mata Pelajaran</span>
              </a>
          </li>
          <li>
            <a href="batch">
              <i class="fa fa-paperclip"></i>
              <span>Batch Soal</span>
              </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-paperclip"></i>
              <span>Paket Soal</span>
              </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-list-alt"></i>
              <span>Daftar Semua Soal</span>
              </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-star-half-o"></i>
              <span>Skor / Rangking</span>
              </a>
          </li>
          <li>
            <a href="app/update_profil">
              <i class="fa fa-key"></i>
              <span>Ubah Password</span>
              </a>
          </li>
          <li>
            <a href="Pengaturan">
              <i class="fa fa-suitcase"></i>
              <span>Pengaturan</span>
              </a>
          </li>
          
          <!-- <li>
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Reset</span>
              </a>
          </li> -->

            <?php
          } elseif ($this->session->userdata('level') == 'siswa') {
           ?>

          <li class="mt">
            <a href="">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li>
            <a href="app/list_batch">
              <i class="fa fa-paste"></i>
              <span>Daftar Ujian</span>
              </a>
          </li>
          <li>
            <a href="app/rangking_siswa">
              <i class="fa fa-star-half-o"></i>
              <span>Skor / Rangking</span>
              </a>
          </li>
          <li>
            <a href="app/ujian_selesai">
              <i class="fa fa-paperclip"></i>
              <span>Ujian Selesai</span>
              </a>
          </li>
          <li>
            <a href="app/update_profil">
              <i class="fa fa-suitcase"></i>
              <span>Ubah Profil</span>
              </a>
          </li>
          
          


          <?php } ?>
          <!-- <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-comments-o"></i>
              <span>Chat Room</span>
              </a>
            <ul class="sub">
              <li><a href="lobby.html">Lobby</a></li>
              <li><a href="chat_room.html"> Chat Room</a></li>
            </ul>
          </li>
          <li>
            <a href="google_maps.html">
              <i class="fa fa-map-marker"></i>
              <span>Google Maps </span>
              </a>
          </li> -->
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>