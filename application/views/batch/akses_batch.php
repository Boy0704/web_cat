<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Nama Lengkap</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $siswa_data= $this->db->get_where('user', array('akses'=>'siswa'))->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->nama_lengkap ?></td>
			<td style="text-align:center" width="200px">
				<?php
				$cekbatch = $this->db->get_where('akses_batch',array('user_id'=>$siswa->user_id,'batch_id'=>$this->uri->segment(3))); 
				if ($cekbatch->num_rows() == 0) {
				 ?>
				<form action="" method="POST">
					<input type="hidden" name="userid" value="<?php echo $siswa->user_id; ?>">
					<button type="submit" class="btn btn-primary btn-xs">Pilih</button>
				</form>
			<?php } else { ?>
				<a href="app/delete_akses_batch/<?php echo $siswa->user_id.'/'.$this->uri->segment(3) ?>"><span class="label label-success">Terpilih</span></a>
			<?php } ?>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        