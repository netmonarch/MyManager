@extends('layouts.app')

@section('content')

<div class="container">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{!! url('/'); !!}">{{ App\User::find($project->owner)->name }}</a></li>
		<li class="breadcrumb-item active" aria-current="page">{{$project->name}}</li>
	  </ol>
	</nav>
</div>

<div class="container border-1" ng-app="editProject" ng-controller="editController">

	<div class="jumbotron">
		Assigned to Users:
		@foreach ($assigned as $a)
		<strong>{{App\User::find($a->user_id)->name}} </strong>&nbsp;&nbsp;&nbsp;&nbsp;
		
		@endforeach
		<h1 class="display-4">{{$project->name}} <a class="text-dark" href="#"><i class="fas fa-edit"></i></a></h1>
		<p class="leadt">
			
			{{$project->desc}}
			
			&nbsp;&nbsp;<a class="text-dark" href="#">
				<i class="fas fa-edit"></i>
			</a>
			
		</p>
		
		<ul>
			@foreach ($project->Tasks($project->id) as $tasks)
				
					
					<table>
						<tr>
							<td width="300px">
								<form method="POST" action="../tasks/{{$tasks->id}}">
									@csrf
									@method("PATCH")
									<input type="checkbox" name="completed" onchange="this.form.submit()" {{ ($tasks->status == 1 ? "checked" : "") }} /> {{ $tasks->name }}
								</form>
							</td>
							<td width="200px">
								<form method="POST" action="../tasks/{{$tasks->id}}/delete">
									@csrf
									@method("DELETE")
									<a href="#">
										<i class="far fa-eye" data-toggle="modal" data-target="#exampleModal" ng-click="taskEditForm({{$tasks->id}})"></i>
									</a>
									<a href="#" class="text-warning" data-toggle="modal" data-target="#exampleModal" ng-click="taskView({{$tasks->id}})">
										<i class="fas fa-edit"></i>
									</a>
									<a href="#" class="text-danger">
										<strong><big>&times;</big></strong>
									</a>
								</form>
							</td>
						</tr>
					</table>
				
			@endforeach
		</ul>

		<form method="post" action="../{{$project->id}}/task">
			@csrf
			
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<button class="btn btn-outline-secondary" type="submit" id="button-addon1">Add Task</button>
			  </div>
			  <input required type="text" name="taskName" class="form-control" placeholder="Enter a task name" aria-label="Example text with button addon" aria-describedby="button-addon1">
			  <input type="hidden" name="taskParent" value="{{$project->id}}" />
			</div>
		</form>
		
		@if (Session::has('status'))
			{{Session::get('status')}}
		@endif
	</div>

	<div>
	
		<ul>
		@if ($errors->any())
			
			@foreach ($errors->all() as $error)
			
			<li>{{$error }}</li>
			
			@endforeach
		</ul>
		@endif
	</div>
	<!-- Button trigger modal -->


	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" id="exBody">
			...
		  </div>

		</div>
	  </div>
	</div>
</div>


<script>
	var app = angular.module("editProject", []);
	
	app.controller ("editController", function ($scope, $http) {
		$scope.taskEditForm = function (id)
		{
			$http.get("../tasks/"+id)
			.then(function(response) {
				$scope.myData = response.data;
				document.getElementById('exBody').innerHTML = $scope.myData;
			});
		}
		
		$scope.taskView = function (id)
		{
			$http.get("../tasks/"+id+"/show/")
			.then(function(response) {
				$scope.myData = response.data;
				document.getElementById('exBody').innerHTML = $scope.myData;
			});
		}
		
		$scope.deleteTask = function ()
		{
		}
	});
</script>
@endsection