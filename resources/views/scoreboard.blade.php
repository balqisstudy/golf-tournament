@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Scoreboard for Tournament: {{ $tournament->Name }}</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tournament Details</h4>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $tournament->Desc }}</p>
                    <p><strong>Location:</strong> {{ $tournament->Location }}</p>
                    <p><strong>Start Date:</strong> {{ $tournament->StartDate }}</p>
                    <p><strong>End Date:</strong> {{ $tournament->EndDate }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Player Scores</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Player Name</th>
                                <th>Email</th>
                                <th>Current Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($players as $index => $player)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $player->Name }}</td>
                                <td>{{ $player->Email }}</td>
                                <td>
                                    <input type="number" 
                                           value="{{ $player->getScoreForTournament($tournament->TourID) }}" 
                                           id="score-{{ $player->UserID }}"
                                           class="form-control"
                                           style="width: 100px; display: inline-block;">
                                </td>
                                <td>
                                    <button onclick="updateScore({{ $player->UserID }})" 
                                            class="btn btn-primary btn-sm">
                                        Update Score
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No players registered for this tournament</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateScore(userId) {
    const score = document.getElementById('score-' + userId).value;
    const tournamentId = {{ $tournament->TourID }};
    
    // Show loading state
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Updating...';
    button.disabled = true;
    
    fetch(`/api/players/${userId}/scores`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            score: parseInt(score),
            tour_id: tournamentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Score updated successfully!');
        } else {
            alert('Error updating score: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating score. Please try again.');
    })
    .finally(() => {
        // Reset button state
        button.textContent = originalText;
        button.disabled = false;
    });
}
</script>
@endsection
