@extends('layouts.app')

@section('content')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
              <li class="breadcrumb-item">Users</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	<section class="content">
      	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<a type="button" href="{{ route('user.create')}}" class="btn btn-outline-success btn-sm float-left"><i class="fas fa-users mr-2"></i> Add User</a>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Active Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Inactive Users</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                            <table class="table table-hover table-striped" id="users">
                                                <thead>
                                                    <tr style="text-align:center;">
                                                        <th>FIRSTNAME</th>
                                                        <th>LASTNAME</th>
                                                        <th>EMAIL</th>
                                                        <th>ROLE</th>
                                                        <th>DATE ADDED</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                        <tr>
                                                            <td>{{ $user->first_name }}</td>
                                                            <td>{{ $user->last_name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->role->name}}</td>
                                                            <td>{{ $user->created_at }}</td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab"> 
                                            <table class="table table-hover table-striped" id="inactive-users">
                                                <thead>
                                                    <tr style="text-align:center;">
                                                        <th>FIRSTNAME</th>
                                                        <th>LASTNAME</th>
                                                        <th>EMAIL</th>
                                                        <th>ROLE</th>
                                                        <th>DATE ADDED</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($InactiveUsers as $user)
                                                        <tr>
                                                            <td>{{ $user->first_name }}</td>
                                                            <td>{{ $user->last_name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->role->name}}</td>
                                                            <td>{{ $user->created_at }}</td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix">
							
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
	<!-- /page content -->
	<div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                 <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div id="restoreModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to restore this data?</h4>
                </div>
                <div class="modal-footer">
                <button type="button" name="restore_button" id="restore_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
        @push('scripts')
		<!-- Javascript -->
		<!-- DataTables  & Plugins -->
		<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
		<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
		<script>

            var table = $('#users').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
      			"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url":"<?= route('activeUser') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"}
                },
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        "extend": 'collection',
                        "text": 'Export',
                        "buttons": [
                            {
                                "extend": 'csv',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            },
                            {
                                "extend": 'pdf',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            },
                            {
                                "extend": 'print',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            }
                        ],
                    }
                ],
                "columns":[
                    {"data":"first_name"},
                    {"data":"last_name"},
                    {"data":"email"},
                    {"data":"role"},
                    {"data":"created_at"},
                    {"data":"action","searchable":false,"orderable":false}
                ],
                "columnDefs": [{
					"targets": [4],   // target column
					"className": "textCenter",
				}]
            });

            var tableInactive = $('#inactive-users').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
      			"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url":"<?= route('InactiveUser') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"}
                },
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        "extend": 'collection',
                        "text": 'Export',
                        "buttons": [
                            {
                                "extend": 'csv',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            },
                            {
                                "extend": 'pdf',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            },
                            {
                                "extend": 'print',
                                'title' : 'Users-List',
                                "exportOptions": {
                                    "columns": [0,1,2,3,4]
                                }
                            }
                        ],
                    }
                ],
                "columns":[
                    {"data":"first_name"},
                    {"data":"last_name"},
                    {"data":"email"},
                    {"data":"role"},
                    {"data":"created_at"},
                    {"data":"action","searchable":false,"orderable":false}
                ],
                "columnDefs": [{
					"targets": [4],   // target column
					"className": "textCenter",
				}]
            });

			$(document).on('click', '#show', function(){
                var userId = $(this).attr('data-id');
                window.location.href = 'user/'+userId;
            });

            $(document).on('click', '#edit', function(){
                var id = $(this).attr('data-id');
                window.location.href = 'user/'+id+'/edit';
            });

            
   
            var user_id;
            $(document).on('click', '#delete', function(){
                user_id = $(this).attr('data-id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"user/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
							table.ajax.reload();
                            tableInactive.ajax.reload();
                        }, 2000);
                    }
                })
            });

            var userId;
            $(document).on('click', '#restore', function(){
                userId = $(this).attr('data-id');
                $('#restoreModal').modal('show');
            });

            $('#restore_button').click(function(){
                $.ajax({
                    url:"user/restore/"+userId,
                    beforeSend:function(){
                        $('#restore_button').text('Restoring...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#restoreModal').modal('hide');
                            tableInactive.ajax.reload();
                            table.ajax.reload();
                            $('#restore_button').text('OK');
                        }, 2000);
                    }
                })
            });

            
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                $('.table:visible').each( function(e) {
                    $(this).DataTable().columns.adjust().responsive.recalc();
                });
            });
		</script>
        @endpush('scripts')
@endsection