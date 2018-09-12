<body>
    <p>The job (#{{ $task->number }}) was finished.</p>
    <br>
    <p>Job item : {{ $task->item }}</p>
    <p>Job Location : {{ $task->location }}</p>
    <p>Shop : {{ $task->shop }}</p>
    <p>Job Submit Date : {{ $task->updated_at->format('n M, Y') }}</p>
    <p>GPS Location : {{ $task->lat_long }}</p>
    @if($task->reason != '')
        <p>Item Not Found: {{ $task->reason }}</p>
    @endif
    <br>
    <p>The taken photos are attached here.</p>
</body>