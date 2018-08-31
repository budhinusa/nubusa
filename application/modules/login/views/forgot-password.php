<div class="login-container">
	<div class="well-login">
    <?php print $this->form_eksternal->form_open()?>
    <?php
    if($pesan){
    ?>
    <blockquote class="quote_blue">
        <?php print $pesan?>
    </blockquote>
    <?php
    }
    ?>
		<div class="control-group">
			<div class="controls">
				<div>
          <?php print $this->form_eksternal->form_input('email', '', 'placeholder="Email" class="login-input mail form-control"')?>
				</div>
			</div>
		</div>
		</br>
		<div class="control-group">
			<div class="controls">
				<div>
					<?php print $this->form_eksternal->form_submit('reset', 'Reset Password', 'class="btn btn-primary login-btn"')?>
          <a class="btn bg-olive pull-right" href="<?php print   site_url("login")?>">Back to login</a>
				</div>
			</div>
		</div>
    </form>
	</div>
</div>