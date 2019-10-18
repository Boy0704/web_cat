<?php 
$soal_id = $this->uri->segment(3);
 ?>
<a href="app/tambah_butir_soal/<?php echo $soal_id ?>" class="btn btn-primary">Tambah Pertanyaan</a>
<hr>
<table class="table table-bordered tabel-data" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
				<th>Pertanyaan</th>
				<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 0;
            
            $soal_data= $this->db->get_where('butir_soal', array('soal_id'=>$soal_id))->result();
            foreach ($soal_data as $soal)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $soal->pertanyaan ?></td>
			
			<td style="text-align:center" width="200px">
				<a href="app/ubah_butir_soal/<?php echo $soal->butir_soal_id ?>" class="btn btn-info">Ubah</a>
                | <a href="app/hapus_butir_soal/<?php echo $soal->butir_soal_id.'/'.$soal_id ?>" class="btn btn-danger" onclick="javasciprt: return confirm('Are You Sure ?')">Hapus</a>
            </td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        