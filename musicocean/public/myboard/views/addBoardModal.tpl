<!-- Add Board Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>

      <form action="./action.php" method="POST" class="form">
        <div class="modal-body">
          <div class="form-group">
	 	        <label for="board_name">Board Name</label>
	 	        <input type="text" name="board_name" class="form-control" required>
          </div>
          <input type="radio" name="auth" value="public">Public Board<br>
          <input type="radio" name="auth" value="private" checked>Private Board<br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="action" id="actionBtn" value="AddBoard">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
