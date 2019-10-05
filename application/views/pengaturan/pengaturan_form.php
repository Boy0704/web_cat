
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="pengaturan">Pengaturan <?php echo form_error('pengaturan') ?></label>
            <textarea class="form-control" rows="3" name="pengaturan" id="pengaturan" placeholder="Pengaturan"><?php echo $pengaturan; ?></textarea>
        </div>
	    <input type="hidden" name="pengaturan_id" value="<?php echo $pengaturan_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('pengaturan') ?>" class="btn btn-default">Cancel</a>
	</form>
   