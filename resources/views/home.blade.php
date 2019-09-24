@extends('layouts.app')

@section('content')

<div ng-app="projectModalApp" ng-controller="myProjectModalApp">
	<div class="container">
		
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item">{{ Auth::user()->name }}</li>
		  </ol>
		</nav>
		
	</div>
	@php $page = (isset($_GET['page']) ? $_GET['page'] : 0); @endphp
	<div class="container ">
		<nav>
			<div class="nav nav-tabs" style="font-weight:bold;" id="nav-tab" role="tablist">
				<a class="nav-item nav-link {{ ($page == 0 ? "active" : "") }}" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Profile</a>
				<a class="nav-item nav-link {{ ($page != 0 ? "active" : "") }}" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Projects</a>
			</div>
		</nav>

		<div class="tab-content" id="nav-tabContent">
			
			<div class="tab-pane bg-light p-4 fade rounded-bottom {{ ($page == 0 ? "show active" : "") }} border-bottom border-right border-left" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			  <h1>Your Profile <i class="fas fa-user"></i></h1>
              <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Edit <i class="far fa-edit"></i></a>
              <hr />
                <ul class="list-group">
                  <li class="list-group-item"> Username: {{ $user->name }} </li>
                  <li class="list-group-item"> E-mail: {{ $user->email }} </li>
                </ul>
				 <hr />
				<ul class="list-group">
                  <li class="list-group-item">
                    <strong> {{ $info->first }} {{ $info->last }}</strong></li>
                  <li class="list-group-item"> Location:<strong> {{ $info->city }}, {{ $info->state }} {{ $info->zip }}</strong></li>
                  <li class="list-group-item"> Phone: <strong>{{ $info->phone }}</strong></li>

                </ul>
				 
			</div>
			  
			<div class="tab-pane p-4 fade bg-light rounded-bottom {{ ($page != 0 ? "show active" : "") }} border-bottom border-right border-left" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">	
				
				
					
				<h1>My Projects</h1>
				<hr />
				
                
				  
					<a class="shadow-lg p-3 mb-5 rounded btn btn-success" href="projects/create">Create New Project</a><br />
				 
                
				@if (!count ($user->Projects()) > 0)
					You currently have no projects.
				@else

                You have <strong>{{ count($user->Projects()) }}</strong> open project(s)
					<div class="container col-10">
						<div class="row">
						@php $rowcount = 0; @endphp
						@foreach ($user->Projects() as $project)

							@php $rowcount++; @endphp
								<div class="card m-4 shadow" style="width: 15rem;" id="project">
								 
								  <div class="card-body border-2">
									<div style="float:right;">
										<form method="post" action="projects/{{ $project->id }}"> @csrf @method('DELETE')
											<button type="submit" class="close text-danger" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</form>
									</div>
									<h5 class="card-title">{{ ($project->name == "" ? "[No Title]" : $project->name) }}</h5>
									<p class="card-text">{{ $project->desc }}</p>
									<a href="projects/{{ $project->id }}/edit/" type="button" class="btn btn-warning">View</a>
									<br />
									
									{{ count ( App\Project::Tasks ($project->id) ) }} Tasks, 
										{{ count (App\Project::UsersOnProject ($project->id) ) }} Users
								  </div>
								</div>
							
							@php if ($rowcount == 3) { echo "</div><div class='row'>"; $rowcount=0; } @endphp
							
						@endforeach
						</div>
						
						
						<ul class="nav text-right border border-0 center">
						  <li class="nav-item">
							{{ $user->Projects()->links() }}
						  </li>
						</ul>
						<nav class="text-center"></nav>
					</div>

				@endif
				

			</div>
			  
			<div class="tab-pane rounded-bottom  bg-light p-4 fade border-bottom border-right border-left" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
			  ...
			</div>
		 
		</div>
		
	</div>

	
	
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Your Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="user/{{auth()->user()->id}}/edit">
      @csrf
      @method('PATCH')
        <ul class="list-group">
                  <li class="list-group-item"> Username: <input name="name" type="text" value="{{ $user->name }}" /> </li>
                  <li class="list-group-item"> E-mail: <input name="email" type="text" value="{{ $user->email }}" /> </li>
                </ul>
				 <hr />
				<ul class="list-group">
                  <li class="list-group-item">
                    First Name: <input name="first" type="text" value="{{ $info->first }}" />
                  </li>

                  <li class="list-group-item"> Last Name: <input name="last" type="text" value="{{ $info->last }}" /></li>
                  <li class="list-group-item"> City: <input name="city" type="text" value="{{ $info->city }}" /></li>
                  <li class="list-group-item"> State: <input name="state" type="text" value="{{ $info->state }}" /></li>
                  <li class="list-group-item"> Zip: <input name="zip" type="text" value="{{ $info->zip }}" /></li>
                  <li class="list-group-item"> Phone: <input name="phone" type="text" value="{{ $info->phone }}" /></li>

                </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
var app = angular.module('projectModalApp', []);
app.controller('myProjectModalApp', function($scope, $http) {
	
	$scope.findProject = function (id) {
	  $http.get("projects/"+id+"/")
	  .then(function(response) {
		$scope.myData = response.data;
		document.getElementById('projectModal').innerHTML = $scope.myData;
	  });
	}
});
</script> 
@endsection
