
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('paket_soal/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('paket_soal/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('paket_soal'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Paket Soal</th>
		<th>Nama Batch</th>
		<th>Soal dipaket ini</th>
		<!-- <th>User Id Tambah</th>
		<th>Waktu Tambah</th>
		<th>User Id Ubah</th>
		<th>Waktu Ubah</th> -->
		<th>Status Paket</th>
		<th>Action</th>
            </tr><?php
            foreach ($paket_soal_data as $paket_soal)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $paket_soal->paket_soal ?></td>
			<td><?php echo batch($paket_soal->batch_id) ?></td>
			<!-- <td><?php echo $paket_soal->user_id_tambah ?></td>
			<td><?php echo $paket_soal->waktu_tambah ?></td>
			<td><?php echo $paket_soal->user_id_ubah ?></td>
			<td><?php echo $paket_soal->waktu_ubah ?></td> -->
			<td><?php echo get_soal_paket($paket_soal->paket_soal_id) ?></td>
			<td><?php echo cek_status($paket_soal->status_paket) ?></td>
			<td style="text-align:center" width="200px">
                <a href="#" data-toggle="modal" data-target="#myModal<?php echo $paket_soal->paket_soal_id ?>"><span class="label label-primary">Tambah Soal</span></a>
				<?php 
				echo anchor(site_url('paket_soal/update/'.$paket_soal->paket_soal_id),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('paket_soal/delete/'.$paket_soal->paket_soal_id),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>

        <!-- Modal -->
        <div id="myModal<?php echo $paket_soal->paket_soal_id ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Soal <?php echo $paket_soal->paket_soal ?></h4>
            </div>
            <div class="modal-body">
               <form action="app/simpan_soal_paket/<?php echo $paket_soal->paket_soal_id ?>" method="post">
                <label for="">Soal</label>
                <select name="soal" class="form-control">
                <?php 
                $data = $this->db->get('soal');
                foreach ($data->result() as $lv) {
                ?>
                    <option value="<?php echo $lv->soal_id ?>"><?php echo $lv->soal ?></option>
                <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary">Simpan</button>
               </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
        </div>

                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    