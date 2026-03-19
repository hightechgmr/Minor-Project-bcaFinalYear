//variables of the game
//accessing id's
let opp_name;
 opp_name=prompt("Enter Your Friend name:");
//alert(opp_name);
document.getElementById("play2_name").innerHTML=opp_name;

var usr=document.getElementById("play1_name").innerHTML;



let totlp1=document.getElementById("totalp1");
let winp1=document.getElementById("winp1");
let lostp1=document.getElementById("lostp1");
let totlp2=document.getElementById("totalp2");
let winp2=document.getElementById("winp2");
let lostp2=document.getElementById("lostp2");
let msg=document.getElementById("msg");
let boxes=document.querySelectorAll(".box");
let msgContainer=document.getElementById("msg-container");



//initalising values
let turn= 'O';//player1
let count=0;
let board = ['', '', '', '', '', '', '', '', ''];
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
//player1
let totlplay1=0;let winplay1=0;let lostplay1=0;
//player2
let totlplay2=0;let winplay2=0;let lostplay2=0;




//game play
function boxclick(val){
  if (turn=='O'){
    document.getElementById('box'+val).innerHTML="O";
    board[val]=turn;
    turn='X';
    document.getElementById('box'+val).disabled=true;
    count++;
  }
  else if(turn=='X'){
    document.getElementById('box'+val).innerHTML="X";
    board[val]=turn;
    turn='O';
    document.getElementById('box'+val).disabled=true;
    count++;
  }
  check_winner();
  console.log(board);
}




//winning
function check_winner(){
  for (let i = 0; i <= 7; i++) {
    let a= winPatterns[i][0];
    let b= winPatterns[i][1];
    let c= winPatterns[i][2]; 
    let pos1=board[a];
    let pos2=board[b];
    let pos3=board[c];
    if(pos1==='X' && pos2==='X' && pos3==='X'){
      let win=pos1;
      winner(win);
      break;
    }
    else if(pos1==='O' && pos2==='O' && pos3==='O'){
      let win=pos1;
      winner(win);
      break;
    }
    else if(count===9){
      msg.innerHTML = `Its a tie`;
      disablebox();
    }
  }
}




//winner
function winner(win){
  if(win=='X'){
    msg.innerHTML = `Congratulations, Winner is `+ opp_name;
    winplay2++;
    lostplay1++;  
    disablebox();
  }
  else if(win=='O'){
    msg.innerHTML = `Congratulations, Winner is `+ usr;
    winplay1++;
    lostplay2++;
    disablebox();
  }
  
}




//disable once winner declared
function disablebox(){
  // SToring scores
  checkAjax();
  // --------------
  for(let i=0;i<=8;i++){
    document.getElementById("box"+i).disabled=true;
  }
}




//reset
function reset(){
  totlplay1++;
  totlplay2++;
  turn='O';
  count=0;
  enable();
  document.getElementById("msg").innerHTML='';
  display_record();
}

function enable(){
    for(let i=0;i<=8;i++){
      document.getElementById("box"+i).disabled=false;
      document.getElementById("box"+i).innerHTML='';
      board[i]='';
    }
    checkAjax();
}




//record 
function display_record(){
  totlp1.value= totlplay1;
  winp1.value=winplay1;
  lostp1.value=lostplay1;
  totlp2.value=totlplay2;
  winp2.value=winplay2;
  lostp2.value=lostplay2;
}


function checkAjax(){
  data_['user']= usr;
  data_['against']= opp_name;

  xobj=new XMLHttpRequest();
  xobj.onreadystatechange=function(){
    console.log(xobj.responseText);
  }
  xobj.open('GET','game_score.php?data='+data_,true);
  xobj.send();
}
