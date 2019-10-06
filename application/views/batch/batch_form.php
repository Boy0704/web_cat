
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Batch <?php echo form_error('nama_batch') ?></label>
            <input type="text" class="form-control" name="nama_batch" id="nama_batch" placeholder="Nama Batch" value="<?php echo $nama_batch; ?>" />
        </div>
	    <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('batch') ?>" class="btn btn-default">Cancel</a>
	</form>
   