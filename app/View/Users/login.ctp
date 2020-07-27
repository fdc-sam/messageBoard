

<br>
<div class="container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Login</h5>
      <?php echo $this->Form->create(); ?>
        <div class="form-group">
          <?php echo $this->Form->input('username', array('class'=>'form-control')); ?>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
        <?php echo $this->Form->input('password', array('class'=>'form-control')); ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
