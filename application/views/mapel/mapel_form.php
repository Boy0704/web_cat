
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Mapel <?php echo form_error('mapel') ?></label>
            <input type="text" class="form-control" name="mapel" id="mapel" placeholder="Mapel" value="<?php echo $mapel; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Mapel Kategori <?php echo form_error('mapel_kategori') ?></label>
            <!-- <input type="text" class="form-control" name="mapel_kategori" id="mapel_kategori" placeholder="Mapel Kategori" value="<?php echo $mapel_kategori; ?>" /> -->
            <select name="mapel_kategori" class="form-control">
                <option value="<?php echo $mapel_kategori ?>"><?php echo $mapel_kategori ?></option>
                <?php 
                $pengaturan = $this->db->get('pengaturan',4, 2);
                foreach ($pengaturan->result() as $vl) {
                 ?>
                <option value="<?php echo $vl->pengaturan_id ?>"><?php echo $vl->pengaturan_id.'-'.$vl->pengaturan ?></option>
            <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Operator <?php echo form_error('operator') ?></label>
            <input type="text" class="form-control" name="operator" id="operator" placeholder="Operator" value="<?php echo $operator; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Nilai Lulus <?php echo form_error('nilai_lulus') ?></label>
            <input type="text" class="form-control" name="nilai_lulus" id="nilai_lulus" placeholder="Nilai Lulus" value="<?php echo $nilai_lulus; ?>" />
        </div>
	    <input type="hidden" name="mapel_id" value="<?php echo $mapel_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('mapel') ?>" class="btn btn-default">Cancel</a>
	</form>
   