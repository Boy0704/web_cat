
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('siswa/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Nama Lengkap</th>
		<th>Email</th>
		<th>No Hp</th>
		<th>Alamat</th>
		<th>Action</th>
            </tr>
            </thead>
            <?php
            $start = 0;
            $siswa_data= $this->db->get_where('user', array('akses'=>'siswa'))->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->nama_lengkap ?></td>
			<td><?php echo $siswa->email ?></td>
			<td><?php echo $siswa->no_hp ?></td>
			<td><?php echo $siswa->alamat ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('siswa/update/'.$siswa->user_id),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('siswa/delete/'.$siswa->user_id),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        
    