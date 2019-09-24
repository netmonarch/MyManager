<form method="POST" action="../tasks/{{$task->id}}">
@csrf
@method('PATCH')
	<p>
		<div class="input-group mb-3">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-sizing-default">Task Name</span>
		  </div>
		  <input type="text" name="name" value="{{$task->name}}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
		</div>
	</p>

	<p>
		<div class="input-group">
		  <div class="input-group-prepend">
			<span class="input-group-text">Description</span>
		  </div>
		  <textarea class="form-control" aria-label="Description" name="desc">{{$task->desc}}</textarea>
		</div>
	</p>
	<input type="hidden" name="modal" value="1" />

<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>