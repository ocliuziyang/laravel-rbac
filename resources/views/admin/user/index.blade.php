@extends('admin.layouts.master')

@section('content')

    {{--添加用户模态框--}}
    <div class="container">

        <div class="row">
        {{--//添加用户--}}
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
                添加用户
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">添加用户</h4>
                        </div>
                        <div class="modal-body">
                            {{-- body --}}
                            <form action="{{ route('admin.user.store') }}" method="post">

                                <div class="form-group">
                                    <label for="name" class="">name:</label>
                                    <input name="name" type="text" class="form-control" placeholder="name">
                                </div>

                                <div class="form-group">
                                    <label for="email" class="">email:</label>
                                    <input name="email" type="text" class="form-control" placeholder="email">
                                </div>

                                <div class="form-group">
                                    <label for="password" class="">password:</label>
                                    <input name="password" type="text" class="form-control" placeholder="password">
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="seveChanges" onclick="saveChanges()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{--/.添加用户模态框--}}

    <div class="row" style="margin-top: 10px">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">用户管理</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>name</th>
                            <th>email</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="label label-success">{{ $user->created_at }}</span></td>
                            <td><span class="label label-default">{{ $user->updated_at }}</span></td>
                        </tr>
                            @endforeach
                        </tbody></table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

        function saveChanges() {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();
            $.ajax({
                'type': 'POST',
                'url': '{{ route('admin.user.store') }}',
                'data': {
                    '_token': '{{ csrf_token() }}',
                    'name': name,
                    'email': email,
                    'password': password
                },
                success: function ($data) {
                    if ($data.state == 1) {
                        layer.alert($data.message, {
                            icon: 4,
                            skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                        })
                        //添加数据到 dom 结构中
                        var $admin = $data.user;

                        console.log('$data.user.name='+ $data.user.name);
                        {{--$("tbody").append(' <tr>'+--}}
                            {{--'<td>{{ $admin.id }}</td>'+--}}
                            {{--'<td>{{ $admin.name }}</td>'+--}}
                            {{--'<td>{{ $admin.email }}</td>'+--}}
                            {{--'<td><span class="label label-success">{{ $admin.created_at }}</span></td>'+--}}
                            {{--'<td><span class="label label-default">{{ $admin.updated_at }}</span></td>'+--}}
                            {{--'</tr>');--}}
                        $('#myModal').modal('hide');
                        //添加 user 到tbody当前数组

                    } else {
                        layer.alert('添加失败', {
                            icon: 5,
                            skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                        })
                    }

                },
                'dataType': 'json'
                });
        }

    </script>

    @endsection