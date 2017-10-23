@extends('admin.master')
@section('css')
<style type="text/css">
    .make-switch{
        z-index:2;
    }
</style>
@stop
@section('content')
<style>
    tr.headline, tr.headline:hover {
        background-color:#3498DB;
        color:#ffffff;
    }
</style>
<div class="admin-section-title">
    <div class="row">
        <div class="col-md-12">
            <h3><i class="entypo-user"></i> Permission Roles</h3>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Permission</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <form method="POST" action="{{$perm_post_route}}" role="form" id="add_role_form" accept-charset="UTF-8">
                    <table class="table table-hover">
                        <tr class="table-header">
                            <th>Permission</th>
                            @foreach($roles as $role)
                            <th>{{ ucwords($role->display_name) }}</th>
                            @endforeach
                        </tr>
                        @foreach($permissions as $perm)
                        @if($perm->category != $category)
                        <tr class="headline" style=""><td colspan="{{ count($roles)+2 }} "><strong>{{ TextHelper::toWord($perm->category) }} Module</strong></td></tr>
                        <?php $category = $perm->category; ?>
                        @endif
                        <tr>
                            <td>
                                @if(strlen($perm->display_name) > 40) {{substr($perm->display_name, 0, 40)}} ... @else {{$perm->display_name}} @endif
                            </td>
                            @foreach($roles as $role)
                            <td>
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"  @if(in_array($role->id.'-'.$perm->id,$permission_role))checked="checked" value="1"@else value="0"@endif  name="permission[{{$role->id}}][{{$perm->id}}]" value = '1' />
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </table>
                    <br /><br />
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                    <input type="submit" value="Update Permissions" class="btn btn-success pull-right" />
                </form>
            </div>
        </div>
    </div>
</div>

@section('javascript')
<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
<script>

$ = jQuery;
$(document).ready(function () {
    $('.delete').click(function (e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this user?")) {
            window.location = $(this).attr('href');
        }
        return false;
    });

    $('input[type="checkbox"]').change(function () {
        if ($(this).is(":checked")) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
        console.log('test ' + $(this).is(':checked'));
    });
});

</script>

@stop

@stop

