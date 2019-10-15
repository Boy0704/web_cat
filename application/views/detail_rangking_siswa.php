<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Siswa</th>

                <?php 
                foreach ($this->db->get('mapel')->result() as $key) {
                 ?>
                <th><?php echo $key->mapel ?></th>
            <?php } ?>
                <th>SKD (TWK+TIU+TKP)</th>
                <th>(TPA+TBI)</th>
				<th>Total Nilai</th>
				<!-- <th>Action</th> -->
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
                -- GROUP BY sk.user_id
                GROUP BY sd.user_id,sd.skor_id
                
                ORDER BY total_nilai DESC

            ";
            $siswa_data= $this->db->query($sql)->result();
            foreach ($siswa_data as $siswa)
            {
                $cek_user_id = $this->db->get_where('rangking', array('user_id'=>$siswa->user_id));

                // echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4); exit;
                $data_rangking_update = '';

                if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1) == '0' && cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2) == '0' && cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3) == '0') {
                    $data_rangking_update = array(
                        'tbi' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4),
                        'tpa' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5)
                    );
                } else if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4) == '0' && cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5) == '0') {
                    $data_rangking_update = array(
                        'tiu' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1),
                        'tkp' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2),
                        'twk' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3),
                    );
                }
                

                // $data_rangking_update = array(
                //     'user_id' => $siswa->user_id,
                //     'nama' => $siswa->nama_lengkap,
                //     if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1) == 0) {}else{
                //         'tiu'=> cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1),
                //     }
                //     if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2) == 0) {}else{
                //         'tiu'=> cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2),
                //     }
                //     if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3) == 0) {}else{
                //         'tiu'=> cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3),
                //     }
                //     if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4) == 0) {}else{
                //         'tiu'=> cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4),
                //     }
                //     if (cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5) == 0) {}else{
                //         'tiu'=> cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5),
                //     }

                // );

                $data_rangking_input = array(
                    'user_id' => $siswa->user_id,
                    'nama' => $siswa->nama_lengkap,
                    'tiu' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1),
                    'tkp' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2),
                    'twk' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3),
                    'tbi' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4),
                    'tpa' => cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5),
                    'total'=> $siswa->total_nilai
                );
                if ($cek_user_id->num_rows() > 0) {
                    //update data rangking
                    $this->db->where('user_id', $siswa->user_id);
                    $this->db->get('rangking', $data_rangking_update);
                } else {
                    $this->db->insert('rangking', $data_rangking_input);
                }
            }

                //ambil data rangking
                foreach ($this->db->get('rangking')->result() as $row) {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
            <td><?php echo $row->nama ?></td>

            <!-- revisi baru -->
            <!-- <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 1)+cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 2)+cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 3) ?></td>
            <td><?php echo cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 4)+cek_nilai_permapel($siswa->skor_id, $siswa->user_id, 5) ?></td>
            <td><?php echo $siswa->total_nilai ?></td> -->

            <!-- revisi kedua -->

            <td><?php echo $row->tiu ?></td>
            <td><?php echo $row->tkp ?></td>
            <td><?php echo $row->twk ?></td>
            <td><?php echo $row->tbi ?></td>
            <td><?php echo $row->tpa ?></td>
            <td><?php echo $row->tiu+$row->tkp+$row->twk ?></td>
            <td><?php echo $row->tbi+$row->tpa ?></td>
            <td><?php echo $row->total ?></td>

            <!-- <td><?php echo $siswa->paket_soal ?></td>
			<td><?php echo $siswa->total_nilai ?></td>
			<td style="text-align:center" width="200px">
				<a href="app/detail_nilai_ujian/<?php echo $siswa->skor_id.'/'.$siswa->user_id.'/'.$siswa->paket_soal_id ?>" class="btn btn-info">Pilih</a>
			</td> -->
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        