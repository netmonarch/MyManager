<h1>{{$project->name}}</h2>
<h5>{{$project->desc}}</h5>


<ul>
@foreach ($project->Tasks($project->id) as $tasks)
	<li>{{$tasks->name}}</li>
	
@endforeach
</ul>
<p>Creator: {{ App\User::find($project->owner)->name }}</p>

<!-- Again, eloquent models seem be having issues, so I resorted to using procedural code. -->