<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
                <th>Batch Soal</th>
				<th>Paket Soal</th>
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $sql = "SELECT ps.paket_soal, ps.paket_soal_id, bt.nama_batch FROM paket_soal as ps, batch as bt where ps.batch_id=bt.batch_id ";
            $siswa_data= $this->db->query($sql)->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->nama_batch ?></td>
			<td><?php echo $siswa->paket_soal ?></td>
			<td style="text-align:center" width="200px">
				<a href="app/detail_paket_soal/<?php echo $siswa->paket_soal_id ?>/<?php echo $this->session->userdata('id_user'); ?>" class="btn btn-primary">Pilih</a>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        