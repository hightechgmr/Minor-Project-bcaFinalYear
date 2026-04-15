// Player names
let opp_name = prompt("Enter Your Friend name:");
document.getElementById("play2_name").innerHTML = opp_name;

let usr = document.getElementById("play1_name").innerHTML;

// Score inputs
let totlp1 = document.getElementById("totalp1");
let winp1 = document.getElementById("winp1");
let lostp1 = document.getElementById("lostp1");

// Game variables
let turn = 'O';
let count = 0;
let board = ['', '', '', '', '', '', '', '', ''];

const winPatterns = [
  [0,1,2],[0,3,6],[0,4,8],
  [1,4,7],[2,5,8],[2,4,6],
  [3,4,5],[6,7,8]
];

// Player stats
let totlplay1 = 0;
let winplay1 = 0;
let lostplay1 = 0;

// ---------------- GAME PLAY ----------------
function boxclick(val){
  if (turn === 'O'){
    document.getElementById('box'+val).innerHTML="O";
    board[val]=turn;
    turn='X';
  } else {
    document.getElementById('box'+val).innerHTML="X";
    board[val]=turn;
    turn='O';
  }

  document.getElementById('box'+val).disabled=true;
  count++;
  check_winner();
}

// ---------------- CHECK WINNER ----------------
function check_winner() {
  for (let i = 0; i < winPatterns.length; i++) {
    let [a,b,c] = winPatterns[i];

    if(board[a] && board[a] === board[b] && board[b] === board[c]){
      winner(board[a]);
      return;
    }
  } }

  if(count === 9){
    document.getElementById("msg").innerHTML = "It's a Tie";
  
    totlplay1++;        //increase total
    display_record();   //update UI
  
    sendScore("tie");   // optional
  
    disablebox();
  }

// ---------------- WINNER ----------------
function winner(win){

  if(win === 'O'){
    document.getElementById("msg").innerHTML = "Winner: " + usr;

    winplay1++;      // increase win
  } else {
    document.getElementById("msg").innerHTML = "Winner: " + opp_name;

    lostplay1++;     //increase loss
  }

  totlplay1++;       //increase total matches

  display_record();  //update UI

  sendScore(win === 'O' ? "win" : "loss"); //send to DB

  disablebox();
}

// ---------------- DISABLE ----------------
function disablebox(){
  for(let i=0;i<9;i++){
    document.getElementById("box"+i).disabled=true;
  }
}

// ---------------- RESET ----------------
function reset(){
  turn='O';
  count=0;

  for(let i=0;i<9;i++){
    document.getElementById("box"+i).disabled=false;
    document.getElementById("box"+i).innerHTML='';
    board[i]='';
  }

  document.getElementById("msg").innerHTML='';
}

// ---------------- DISPLAY ----------------
function display_record(){
  totlp1.value = totlplay1;
  winp1.value = winplay1;
  lostp1.value = lostplay1;
}
// ---------------- AJAX SEND ----------------
function sendScore(result){

  let xhr = new XMLHttpRequest();

  let won = 0;
  let lost = 0;

  if(result === "win") won = 1;
  else if(result === "loss") lost = 1;

  let params =
    "game_name=tictactoe" +
    "&won=" + won +
    "&lost=" + lost +
    "&against=" + opp_name;

  xhr.open("POST", "game_score.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function(){
    if(xhr.readyState === 4 && xhr.status === 200){
      console.log(xhr.responseText);
      window.location.href = "score.php";
    }
  };

  xhr.send(params);
}
