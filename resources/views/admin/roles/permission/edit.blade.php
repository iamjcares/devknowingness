<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Update Permission</h4>
</div>

<div class="modal-body">
    <form id="update-permission-form" accept-charset="UTF-8" action="{{ URL::to('admin/permission/update') }}" method="post">
        <label for="name">Permission Name</label>
        <input name="name" id="name" placeholder="Permission Name" class="form-control" value="{{ $permission->name }}" /><br />
        <label for="display_name">Display Name</label>
        <input name="display_name" id="display_name" placeholder="Display name" class="form-control" value="{{ $permission->display_name }}" /><br />
        <label for="description">Description</label>
        <input name="description" id="description" placeholder="Description" class="form-control" value="{{ $permission->description }}" /><br />
        <label for="category">Category</label>
        <input name="category" id="category" placeholder="Category" class="form-control"  value="{{$permission->category}}" /><br />
        <input type="hidden" name="id" id="id" value="{{ $permission->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-info" id="submit-update-permission">Update</button>
</div>

<script>
    $(document).ready(function () {
        $('#submit-update-permission').click(function () {
            $('#update-permission-form').submit();
        });
    });

</script>