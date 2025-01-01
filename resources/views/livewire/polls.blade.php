<div>
    @forelse ($polls as $poll)
        <div class="mb-4">
            <h3 class="mb-4 text-xl">{{ $poll->title }}</h3>

            @foreach ($poll->options as $option)
                <div class="mb-2 flex items-center">
                    <button class="btn" wire:click="vote({{$option->id}})">Vote</button>
                    <span class="ml-2">{{ $option->name }} ({{ $option->votes->count() }})</span>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500 mt-10">
            No polls available
        </div>
    @endforelse
</div>
