@extends('admin.master')

@section('content')

<div class="admin-section-title">
    <div class="row">
        <div class="col-md-8">
            <h3><i class="entypo-user"></i> Roles</h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
        <div class="col-md-4">
            <?php $search = Input::get('s'); ?>
            <form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
        </div>
    </div>
</div>

<!-- Add New Modal -->
<div class="modal fade" id="add-new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Role</h4>
            </div>

            <div class="modal-body">
                <form id="new-role-form" accept-charset="UTF-8" action="{{ URL::to('admin/role/store') }}" method="post">
                    <label for="name">Role Name</label>
                    <input name="name" id="name" placeholder="Role Name" class="form-control"/><br />
                    <label for="display_name">Display Name</label>
                    <input name="display_name" id="display_name" placeholder="Display name" class="form-control"/><br />
                    <label for="description">Description</label>
                    <input name="description" id="description" placeholder="Description" class="form-control"/><br />
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="submit-new-role">Save Role</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="update-role">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="clear"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">User Role</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <table class="table table-striped">
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                        @foreach($roles as $role)
                    <tr>
                        <td>
                            @if(strlen($role->name) > 40) {{substr($role->name, 0, 40)}} ... @else {{$role->name}} @endif
                        </td>
                        <td>
                            @if(strlen($role->display_name) > 40) {{substr($role->display_name, 0, 40)}} ... @else {{$role->display_name}} @endif
                        </td>
                        <td>
                            @if(strlen($role->description) > 40) {{substr($role->description, 0, 40)}} ... @else {{$role->description}} @endif
                        </td>

                        <td>
                            <a href="{{ URL::to('admin/role/edit') . '/' . $role->id }}" class="btn btn-xs btn-info edit"><span class="fa fa-edit"></span> Edit</a>
                            <a href="{{ URL::to('admin/role/delete') . '/' . $role->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@section('javascript')

<script>

    $ = jQuery;
    $(document).ready(function () {


        // Add New Role
        $('#submit-new-role').click(function () {
            $('#new-role-form').submit();
        });

        $('.edit').click(function (e) {
            $('#update-role').modal('show', {backdrop: 'static'});
            e.preventDefault();
            href = $(this).attr('href');
            $.ajax({
                url: href,
                success: function (response)
                {
                    $('#update-role .modal-content').html(response);
                }
            });
        });


        $('.delete').click(function (e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this role?")) {
                window.location = $(this).attr('href');
            }
            return false;
        });
    });

</script>

@stop

@stop

