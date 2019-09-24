@extends('layouts.app')

@section('content')
<div class="container">
	
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="../">{{ Auth::user()->name }}</a></li>
		<li class="breadcrumb-item active" aria-current="page">Create Project</li>
	  </ol>
	</nav>
	
</div>

<div class="container" ng-app="myApp" ng-controller="myCtrl">

	<div class="row">
		<div class="col-6">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-create-tab" data-toggle="tab" href="#nav-create" role="tab" aria-controls="nav-create" aria-selected="true">Project Descriptors</a>
					<a class="nav-item nav-link" id="nav-tasks-tab" data-toggle="tab" href="#nav-tasks" role="tab" aria-controls="nav-tasks" aria-selected="false">Add Tasks</a>
					<a class="nav-item nav-link" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">Add Users</a>
					<a class="nav-item nav-link" id="nav-finalize-tab" data-toggle="tab" href="#nav-finalize" role="tab" aria-controls="nav-finalize" aria-selected="false">Finalize</a>
				</div>
			</nav>

			<form action="../projects" method="post" id="projectForm">
				@csrf
				<div class="tab-content" id="nav-tabContent">
					
					<!-- Descriptors -->
					<div class="tab-pane p-4 fade show active border-bottom border-right border-left" id="nav-create" role="tabpanel" aria-labelledby="nav-create-tab">
						
						<div class="container">
							<div class="form-group">
								<label for="projectTitle">Project Title *</label>
								<input class="form-control form-control-lg" type="text" placeholder="Project Title" name="projectTitle" id="projectTitle" ng-model="projectTitle">
								<small class="form-text text-muted">
								  Your Title must be 3-100 characters long
								</small>
							</div>
							
							<div class="form-group">
								<label for="projectDescription">Description</label>
								<textarea class="form-control" id="projectDescription" ng-model="projectDescription" rows="4"></textarea>
							</div>
							
							<div class="form-group">
								<a class="btn-lg btn-primary" href="" onclick="document.getElementById('nav-tasks-tab').click(); return false;">Next <i class="fas fa-forward"></i></a>
							</div>
						</div>
						
					</div>
					
					<!-- Add Tasks--->
					  
					<div class="tab-pane p-4 fade border-bottom border-right border-left" id="nav-tasks" role="tabpanel" aria-labelledby="nav-tasks-tab">

						<div class="container">
							<div class="form-group">
								<label for="taskName">Add Task</label>
								<input class="form-control form-control-lg" id="taskName" placeholder="Task Name" ng-model="taskName" />
								<small class="form-text text-muted">
								  Task Names must be 3-100 characters long
								</small>
							</div>
							
							<div class="form-group">
								<label for="taskDescription">Task Description</label>
								<textarea class="form-control" id="taskDescription" ng-model="taskDescription" rows="4"></textarea>
							</div>
							
							<div class="form-group form-check">
								<input type="checkbox" class="form-check-input" ng-model="hasDueDate">
								<label class="form-check-label" for="exampleCheck1">Has a Deadline?</label>
							</div>
								
							<div class="form-group" ng-show="hasDueDate">
								<div class="row">
									<div class="col-6">
										<label for="taskDueDate">Due Date</label>
										<input type="date" class="form-control form-control-lg" id="taskDueDate" ng-model="taskDueDate" />
									</div>
								</div>
							</div>
							
							
							<div >
								<div class="text-right">
									<button class="btn-lg btn-primary" type="button" ng-click="addTask()" onclick="return false;">Add Task</button>
								</div>
							</div>
							
							<div class="form-group">
								<a class="btn-lg btn-primary" href="" onclick="document.getElementById('nav-users-tab').click(); return false;">Next <i class="fas fa-forward"></i></a>
							</div>
						</div>

					</div>
					<!-- Add Users -->
					<div class="tab-pane p-4 fade border-bottom border-right border-left" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
						<h5>Add User</h5><br/>	
						Click from the list below to add users to your project
						<div class="container" style="overflow-y:scroll; height:300px; background-color:lightgray">
							<ul class="list-group list-group-flush">
								@foreach ($users as $u)
								<li class="list-group-item" style=" background-color:lightgray"><strong><a id="myBtn" href="#" ng-click="addUser({{$u->id}}, '{{$u->name}}')">{{ $u->name }}</a></strong></li>
								@endforeach
							</ul>
						</div>
						
						<br />
						<div class="form-group">
							<a class="btn-lg btn-primary" href="" onclick="document.getElementById('nav-finalize-tab').click(); return false;">Next <i class="fas fa-forward"></i></a>
						</div>
					</div>
					
					<!-- Finalize -->
					<div class="tab-pane p-4 fade border-bottom border-right border-left" id="nav-finalize" role="tabpanel" aria-labelledby="nav-finalize-tab">
						<h3>Save your project!</h3>
						<p>Look to the right and make sure everything is correct.</p>
						<p>(Don't worry, you can make changes later if you're unsure!)</p>
						<button class="btn-lg btn-success" type="button" ng-click="createProject()">Save</button>
					</div>

				</div>
				<input id="projectJSON" name="projectJSON" ng-bind="masterProject" ng-value="" type="hidden" />
				@{{masterProject}}
			</form>
			
		</div>
		
		
		<div class="col-6 border-left">
			<h5 class="card-title">@{{ projectTitle }}</h5>
			<div class="card bg-light" style="width: 18rem;">
			  <div class="card-body">

				<p class="card-text" style="white-space: pre-line;">@{{ projectDescription }}</p>
			  </div>
			</div>
			<strong> @{{ (projectTasks.length > 0 ? "Tasks" : "") }}</strong>
			 <ul>
			 
				<li ng-repeat="x in projectTasks">
					@{{x.name}} - @{{x.description}} [<a href="#" style="color:red" ng-click="removeTask(x.tempid)">&times;</a>]<br />
					
					@{{ (x.date != NULL ? 'Due '+x.date : '') }}
				</li>
			</ul>
			
			<strong>@{{ (projectUsers.length > 0 ? "Users" : "") }}</strong>
			<div class="alert alert-danger" role="alert" id="flashShow" style="display:none;" >
				@{{ message }}
			</div>
			
			<ul>
				<li ng-repeat="x in projectUsers">
					@{{ x.name }} [<a href="#" style="color:red" ng-click="removeUser(x.temp)">&times;</a>]
				</li>
			</ul>
			
			
		</div>
		
		
	</div>

</div>

<script>

function findUser (userArray, userid)
{
	var found = false;
	var i = 0;
	for (i=0; i < userArray.length; i++)
	{
		if (userArray[i].id == userid) found = true;
	}
	
	return found;
}


var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope) {
	$scope.message ="";
	$scope.alertFlashShow = false;
	
	$scope.projectTitle= "";
	$scope.projectDescription="";
	$scope.projectTasks =[];
	$scope.projectUsers = [];
	$scope.taskDueDate = new Date();
	
	$scope.addTask = function () {
		
		if ($scope.hasDueDate == true)
		{
		$scope.projectTasks.push(
			{
            tempid: $scope.projectTasks.length,
			name: $scope.taskName,
			description: $scope.taskDescription,

			date: $scope.taskDueDate.getMonth()+1 + "/" + $scope.taskDueDate.getDate() + "/" +$scope.taskDueDate.getFullYear()
			});
		} 
		else
		{
		$scope.projectTasks.push({
            tempid: $scope.projectTasks.length,
			name: $scope.taskName,
			description: $scope.taskDescription
			});
		}
		
		$scope.taskName = "";
		$scope.taskDescription = "";
		$scope.taskDueDate = new Date();
	}

    $scope.removeTask = function (t) {

        $scope.projectTasks.splice(t,1)
    }
    
	
	
	$scope.addUser = function (id, name)
	{
		if (!findUser ($scope.projectUsers, id))
		{
			$scope.projectUsers.push(
			{
                tempid: $scope.projectUsers.length,
				id: id,
				name: name
			});
		} else 
		{
			document.getElementById('flashShow').style.display = 'inline';
			$scope.message = "User already added.";
			window.setTimeout(function(){ document.getElementById('flashShow').style.display = 'none'; }, 2000);
		}
	}

    $scope.removeUser = function (u) {

        $scope.projectUsers.splice(u,1);

    }
	
	$scope.createProject = function ()
	{
		var masterProject = {
			
			projectName: $scope.projectTitle,
			projectDesc: $scope.projectDescription,
			projectTasks: $scope.projectTasks,
			projectUsers: $scope.projectUsers
			
		};
		$scope.masterProject = masterProject;
		document.getElementById('projectJSON').value = JSON.stringify($scope.masterProject, null, '');
		document.getElementById('projectForm').submit();
		
	}
});
</script>
@endsection
