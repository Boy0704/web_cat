<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
				<th>Nama Siswa</th>
				
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $siswa_data= $this->db->get_where('user',array('akses'=>'siswa'))->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->nama_lengkap ?></td>
			<td style="text-align:center" width="200px">
				<a href="app/aksi_reset/<?php echo $siswa->user_id ?>" class="btn btn-danger btn-xs">RESET ALL</a>

                <?php 
                foreach ($this->db->get('batch')->result() as $dt) {
                 ?>

                <a href="app/aksi_reset_batch/<?php echo $dt->batch_id ?>/<?php echo $siswa->user_id ?>" class="btn btn-danger btn-xs"><?php echo $dt->nama_batch ?> </a>

            <?php } ?>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        