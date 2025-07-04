<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> Player List </title>
        <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
    button {
      padding: 6px 10px;
      background-color: red;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
    </head>
    <body>
        <h1> Player List </h1>
        <table id="playerTable">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Name </th>
                    <th> Email </th>
                    <th> Password </th>
                    <th> Role </th>
                    <th> Registration Date </th>
                    <th> Notification ID </th>
                    <th> Action </th>
                </tr>
            </thead>
        <tbody>
            <!--Player rows will be inserted here-->
        </tbody>
    </table>
    <script>
       const API_URL = "http://localhost/api/player"; 
    
       function fetchPlayer(){
        fetch(API_URL)
        .then(res => res.json())
        .then(data => {
            const tableBody = document.querySelector("#playerTable tbody");
            tableBody.innerHTML="";

            data.forEach(player =>{
                const row = document.createElement("tr");
                row.innerHTML = `
                <td>${player.id}</td>
                 <td>${player.name}</td>
                 <td>${player.email}</td>
                 <td>${player.password}</td>
                 <td>${player.role}</td>
                 <td>${new Date(player.created_at).toLocaleDateString()}</td>
                 <td>${player.notification_id}</td>
                 <td><button onclick="deletePlayer(${player.id})">Delete</button></td>
                 `;
                 tableBody.appendChild(row);
            });
            })
            .catch(err => {
                alert("Failed to fetch players: "+ err);
            });
       }
       function deletePlayer(id){
        if(!confirm("Are you sure you want to delete this player?")) return;

        fetch(`${API_URL}/${id}`, {
            method: "DELETE"
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            fetchPlayer();
        })
        .catch(err => {
            alert("Failed to delete player: " + err);
        });
       }
       window.onload =  fetchPlayer;

    <h2> Create New Player </h2>
    <form id="createForm">
        <input type="text" name="name" placeholder="Name" required/>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="text" name="role" placeholder="Role (admin/player)" required />
        <button type="submit">Register Player</button>
    </form>
    <hr />

    <h2>View Player by ID</h2>
    <form id="viewForm">
    <input type="number" name="playerId" placeholder="Enter Player ID" required />
    <button type="submit">Fetch Player</button>
    </form>

    <div id="singlePlayer"></div>

    // Handle create form submission

document.getElementById("createForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  const data = {
    name: formData.get("name"),
    email: formData.get("email"),
    password: formData.get("password"),
    role: formData.get("role")
  };

  fetch("http://localhost/api/players/create.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
    .then(res => res.json())
    .then(response => {
      alert(response.message);
      fetchPlayers(); // Refresh list
      this.reset();
    })
    .catch(err => alert("Error: " + err));
});

// Handle view player by ID form

document.getElementById("viewForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const playerId = new FormData(this).get("playerId");

  fetch(`http://localhost/api/players/show.php?id=${playerId}`)
    .then(res => res.json())
    .then(player => {
      if (player.message) {
        document.getElementById("singlePlayer").innerHTML = `<p>${player.message}</p>`;
      } else {
        document.getElementById("singlePlayer").innerHTML = `
          <h3>Player Detail</h3>
          <ul>
            <li>ID: ${player.player_id}</li>
            <li>Name: ${player.name}</li>
            <li>Email: ${player.email}</li>
            <li>Role: ${player.role}</li>
            <li>Registered: ${player.registration_date}</li>
          </ul>
        `;
      }
    })
    .catch(err => alert("Failed to fetch player: " + err));
});

<hr />
<h2>Update Player Score</h2>
<form id="updateScoreForm">
  <input type="number" name="player_id" placeholder="Player ID" required />
  <input type="number" name="tournament_id" placeholder="Tournament ID" required />
  <input type="number" name="score_value" placeholder="New Score" required />
  <button type="submit">Update Score</button>
</form>

// Handle update score form
document.getElementById("updateScoreForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  const playerId = formData.get("player_id");
  const data = {
    tournament_id: formData.get("tournament_id"),
    score_value: formData.get("score_value")
  };

  fetch(`http://localhost/api/players/update_score.php?player_id=${playerId}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
    .then(res => res.json())
    .then(response => {
      alert(response.message);
      this.reset();
    })
    .catch(err => alert("Failed to update score: " + err));
});