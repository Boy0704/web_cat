
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Mapel Id <?php echo form_error('mapel_id') ?></label>
            <input type="text" class="form-control" name="mapel_id" id="mapel_id" placeholder="Mapel Id" value="<?php echo $mapel_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Soal <?php echo form_error('soal') ?></label>
            <input type="text" class="form-control" name="soal" id="soal" placeholder="Soal" value="<?php echo $soal; ?>" />
        </div>
	    <input type="hidden" name="soal_id" value="<?php echo $soal_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('soal') ?>" class="btn btn-default">Cancel</a>
	</form>
   