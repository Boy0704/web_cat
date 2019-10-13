<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
				<th>Paket Soal</th>
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $siswa_data= $this->db->get('batch')->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->nama_batch ?></td>
			<td style="text-align:center" width="200px">
				<a href="app/detail_rangking_siswa/<?php echo $siswa->batch_id ?>" class="btn btn-info">Pilih</a>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        