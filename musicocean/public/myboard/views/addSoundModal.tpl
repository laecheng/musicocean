<!-- Add Sound Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>

      <form action="./action.php" method="POST" enctype="multipart/form-data" class="form">
        <div class="modal-body">
          <div class="form-group">
	 	        <label for="sound_name">Sound Name</label>
	 	        <input type="text" name="sound_name" id="sound_name" value="" class="form-control" required>
          </div>
  	      <div class="form-group">
	 	        <label>Choose a image</label>
	 	        <input type="file" name="file_image" accept="image/*" id="file_image"  class="form-control">
	        </div>
	        <div class="form-group">
		        <label>Choose a sound</label>
		        <input type="file" name="file_sound" accept="audio/*" id="file_sound" class="form-control">
	        </div>
          <input type="hidden" name="sound_id" id="sound_id" value="">
          <input type="hidden" name="board_id" id="board_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="action" id="actionBtn" value=""></button>
        </div>
      </form>
    </div>
  </div>
</div>
