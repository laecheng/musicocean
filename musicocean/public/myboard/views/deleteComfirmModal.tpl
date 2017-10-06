<!-- Delete modal -->
<div id="deleteModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel2"></h4>
      </div>

      <div class="modal-footer">

      <form action="./action.php" method="POST">
        <input type="hidden" name="board_id" id="deleteConfirm_board_id" value="">
	  	  <input type="hidden" name="sound_id" id="deleteConfirm_sound_id" value="">
	  	  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="delBtnAction" name="action" value="Delete">Delete</button>
       </form>
      </div>
    </div>
  </div>
</div>
