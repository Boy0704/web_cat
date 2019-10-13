<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
				<th>Soal</th>
				<th>Total Nilai</th>
				<th>Nilai Lulus</th>
				<th>Keterangan</th>
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            $paket_soal_id = $this->uri->segment(3);
            $user_id = $this->uri->segment(4);
            $sql = "SELECT
						so.soal,
						mp.nilai_lulus,
						so.soal_id 
					FROM
						paket_soal AS ps,
						item_soal AS its,
						soal AS so,
						mapel AS mp 
					WHERE
						its.paket_soal_id = ps.paket_soal_id 
						AND its.soal_id = so.soal_id 
						AND mp.mapel_id = so.mapel_id 
						AND its.paket_soal_id = '$paket_soal_id' ";
            $siswa_data= $this->db->query($sql)->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $siswa->soal ?></td>
			<td><?php echo total_nilai_ujian($user_id, $siswa->soal_id) ?></td>
			<td><?php echo $siswa->nilai_lulus ?></td>
			<td><?php 
			if (total_nilai_ujian($user_id, $siswa->soal_id) >= $siswa->nilai_lulus) {
			 ?>
			<label class="label label-success">LULUS</label>	
		<?php }else{ ?>
			<label class="label label-danger">TIDAK LULUS</label>	
		<?php } ?>

			 </td>
			<td style="text-align:center" width="200px">
				<a href="app/detail_jawaban_soal/<?php echo $siswa->soal_id ?>/<?php echo $user_id ?>" class="btn btn-info">Lihat</a>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        