</br>
<div class="container">
	<section class="card">
		<div class="card-body">
			<?php echo $this->Form->create('User'); ?>
			<?php
				echo $this->Form->input('name', array('class' => 'form-control'));?></br><?php
				echo $this->Form->input('email', array('class' => 'form-control'));?></br><?php
				echo $this->Form->input('password', array('class' => 'form-control'));?></br><?php
				echo $this->Form->input('password_confirmation', array('type' => 'password','class' => 'form-control'));?></br><?php
			 ?>
			 <button type="submit" class="btn btn-primary">Submit</button>
			<?php echo $this->Form->end(); ?>
		</div>
	</section>
</div>
