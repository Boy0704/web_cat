<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Paket Soal</th>
				<th>Total Nilai</th>
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $batch_id = $this->uri->segment(3);
            $start = 0;
            $sql = "
            SELECT
                ps.batch_id, sk.paket_soal_id, sk.skor_id,sk.user_id,ps.paket_soal,us.nama_lengkap ,SUM(sd.nilai) as total_nilai
            FROM
                user as us,
                paket_soal AS ps,
                skor AS sk,
                skor_detail AS sd,
                item_soal AS its 
            WHERE
                sk.paket_soal_id = ps.paket_soal_id 
                AND sk.paket_soal_id=its.paket_soal_id
                AND its.soal_id=sd.soal_id
                AND sk.skor_id=sd.skor_id
                AND sk.user_id=sd.user_id
                and us.user_id=sk.user_id
                AND ps.batch_id = '$batch_id'
                AND sk.`status`='1'
                GROUP BY sk.user_id
                
                ORDER BY total_nilai DESC

            ";
            $siswa_data= $this->db->query($sql)->result();
            foreach ($siswa_data as $siswa)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
            <td><?php echo $siswa->nama_lengkap ?></td>
            <td><?php echo $siswa->paket_soal ?></td>
			<td><?php echo $siswa->total_nilai ?></td>
			<td style="text-align:center" width="200px">
				<a href="app/detail_nilai_ujian/<?php echo $siswa->skor_id.'/'.$siswa->user_id.'/'.$siswa->paket_soal_id ?>" class="btn btn-info">Pilih</a>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        