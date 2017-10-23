<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Update Role</h4>
</div>

<div class="modal-body">
    <form id="update-role-form" accept-charset="UTF-8" action="{{ URL::to('admin/role/update') }}" method="post">
        <label for="name">Role Name</label>
        <input name="name" id="name" placeholder="Role Name" class="form-control" value="{{ $role->name }}" /><br />
        <label for="display_name">Display Name</label>
        <input name="display_name" id="display_name" placeholder="Display name" class="form-control" value="{{ $role->display_name }}" /><br />
        <label for="display-name">Description</label>
        <input name="description" id="description" placeholder="Description" class="form-control" value="{{ $role->description }}" /><br />
        <input type="hidden" name="id" id="id" value="{{ $role->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-info" id="submit-update-role">Update</button>
</div>

<script>
    $(document).ready(function () {
        $('#submit-update-role').click(function () {
            $('#update-role-form').submit();
        });
    });

</script>