const gameContainer = document.querySelector(".gamecontent");
const gameName = gameContainer?.dataset.gameName || "tictactoe";
const messageBox = document.getElementById("msg");

// All score fields are grouped so future games can reuse the same update flow.
const scoreInputs = {
  player: {
    total: document.getElementById("totalp1"),
    wins: document.getElementById("winp1"),
    losses: document.getElementById("lostp1"),
    draws: document.getElementById("drawp1"),
  },
  opponent: {
    total: document.getElementById("totalp2"),
    wins: document.getElementById("winp2"),
    losses: document.getElementById("lostp2"),
    draws: document.getElementById("drawp2"),
  },
};

let opponentName = "";
let turn = "O";
let count = 0;
let board = ["", "", "", "", "", "", "", "", ""];
let gameOver = false;

const winPatterns = [
  [0, 1, 2],
  [0, 3, 6],
  [0, 4, 8],
  [1, 4, 7],
  [2, 5, 8],
  [2, 4, 6],
  [3, 4, 5],
  [6, 7, 8],
];

document.addEventListener("DOMContentLoaded", startGame);

function startGame() {
  if (!ensureOpponentName()) {
    disableBoxes();
    return;
  }

  resetBoard();
  loadScore();
}

function ensureOpponentName() {
  if (opponentName) {
    return true;
  }

  let enteredName = "";

  while (!enteredName.trim()) {
     enteredName = prompt("Enter opponent name:");

    if (enteredName === null) {
      window.location.href = "indexafterlogin.php";
      return false;
    }

    if (enteredName.trim()) {
      break;
    }

    alert("Please enter opponent name");
  }

  opponentName = enteredName.trim();
  document.getElementById("play2_name").textContent = opponentName;
  messageBox.textContent = "";
  return true;
}

function boxclick(value) {
  const boxIndex = Number(value);

  if (gameOver || !opponentName || board[boxIndex] !== "") {
    return;
  }

  const box = document.getElementById(`box${boxIndex}`);
  board[boxIndex] = turn;
  box.textContent = turn;
  box.disabled = true;
  count++;

  if (!checkWinner()) {
    turn = turn === "O" ? "X" : "O";
  }
}

function checkWinner() {
  for (const [a, b, c] of winPatterns) {
    if (board[a] && board[a] === board[b] && board[b] === board[c]) {
      finishGame(board[a] === "O" ? "win" : "loss");
      return true;
    }
  }

  if (count === 9) {
    finishGame("draw");
    return true;
  }

  return false;
}

function finishGame(result) {
  gameOver = true;
  disableBoxes();

  const messages = {
    win: "You Won!",
    loss: "You Lost!",
    draw: "It's a Draw!",
  };

  messageBox.textContent = messages[result];
  saveScore(result);
}

function disableBoxes() {
  for (let i = 0; i < 9; i++) {
    document.getElementById(`box${i}`).disabled = true;
  }
}

function reset() {
  if (!opponentName && !ensureOpponentName()) {
    disableBoxes();
    return;
  }

  resetBoard();
}

function resetBoard(clearMessage = true) {
  turn = "O";
  count = 0;
  gameOver = false;
  board = ["", "", "", "", "", "", "", "", ""];

  if (clearMessage) {
    messageBox.textContent = "";
  }

  for (let i = 0; i < 9; i++) {
    const box = document.getElementById(`box${i}`);
    box.disabled = false;
    box.textContent = "";
  }
}

function displayRecord(stats) {
  const total = Number(stats.total_matches) || 0;
  const wins = Number(stats.won) || 0;
  const losses = Number(stats.lost) || 0;
  const draws = Number(stats.draws) || Math.max(0, total - wins - losses);

  scoreInputs.player.total.value = total;
  scoreInputs.player.wins.value = wins;
  scoreInputs.player.losses.value = losses;
  scoreInputs.player.draws.value = draws;

  scoreInputs.opponent.total.value = total;
  scoreInputs.opponent.wins.value = losses;
  scoreInputs.opponent.losses.value = wins;
  scoreInputs.opponent.draws.value = draws;
}

// Builds one shared payload shape for loading and saving scores.
function buildScoreRequest(action, result = "") {
  const params = new URLSearchParams();
  params.append("action", action);
  params.append("game_name", gameName);
  params.append("against", opponentName);

  if (result) {
    params.append("result", result);
  }

  return params;
}

async function loadScore() {
  try {
    const response = await fetch("game_score.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: buildScoreRequest("get_stats"),
    });
    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || "Could not load score.");
    }

    displayRecord(data.stats);
  } catch (error) {
    messageBox.textContent = error.message;
  }
}

// Saves the result without redirecting and redraws the score from the database response.
async function saveScore(result) {
  try {
    const response = await fetch("game_score.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: buildScoreRequest("save_score", result),
    });
    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || "Could not update score.");
    }

    displayRecord(data.stats);
    setTimeout(() => resetBoard(false), 1200);
  } catch (error) {
    messageBox.textContent = error.message;
  }
}
