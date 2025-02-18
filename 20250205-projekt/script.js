const board = document.getElementById("board");
const cells = document.querySelectorAll(".cell");
const statusText = document.getElementById("status");
const resetButton = document.getElementById("reset");
const difficultySelect = document.getElementById("difficulty");

let difficulty = 0.9;

const HUMAN_PLAYER = "X";
const AI_PLAYER = "O";
let currentPlayer = HUMAN_PLAYER;
let gameBoard = Array(9).fill(null);

const WINNING_COMBINATIONS = [
  [0, 1, 2],
  [3, 4, 5],
  [6, 7, 8],
  [0, 3, 6],
  [1, 4, 7],
  [2, 5, 8],
  [0, 4, 8],
  [2, 4, 6],
];


function bgChange(state) {
  switch(state.toLowerCase()){
    case "win":
      document.querySelector(".blobs").classList.remove("x");
      document.querySelector(".blobs").classList.remove("o");
      document.querySelector(".blobs").classList.remove("lose");
      document.querySelector(".blobs").classList.add("win");
      break;
    case "lose":
      document.querySelector(".blobs").classList.remove("x");
      document.querySelector(".blobs").classList.remove("o");
      document.querySelector(".blobs").classList.add("lose");
      document.querySelector(".blobs").classList.remove("win");
      break;
    case "draw":  
      document.querySelector(".blobs").classList.remove("x");
      document.querySelector(".blobs").classList.remove("o");
      document.querySelector(".blobs").classList.add("lose");
      document.querySelector(".blobs").classList.remove("win");
      break;
    case "x":
      document.querySelector(".blobs").classList.add("x");
      document.querySelector(".blobs").classList.remove("o");
      document.querySelector(".blobs").classList.remove("lose");
      document.querySelector(".blobs").classList.remove("win");
      break;
    case "o":
      document.querySelector(".blobs").classList.remove("x");
      document.querySelector(".blobs").classList.add("o");
      document.querySelector(".blobs").classList.remove("lose");
      document.querySelector(".blobs").classList.remove("win");
      break;
    default:
      document.querySelector(".blobs").classList.add("x");
      document.querySelector(".blobs").classList.remove("o");
      document.querySelector(".blobs").classList.remove("lose");
      document.querySelector(".blobs").classList.remove("win");
      break;
  }
  return state;
}

let timerElement;
let timerStart = 0;
let finalTime = 0;
function timeStart(){
  if (timerElement) clearInterval(timerElement);
  timerStart = Date.now();
  timerElement = setInterval(() => {
    const elapsed = Date.now() - timerStart;
    
    const minutes = Math.floor(elapsed / 60000).toString().padStart(2, "0");
    const seconds = Math.floor((elapsed % 60000) / 1000).toString().padStart(2, "0");
    const milliseconds = elapsed % 1000;
    document.querySelector("h2.timer").textContent = `${minutes}:${seconds}.${milliseconds.toString().padStart(3, "0")}`;
  }, 10);
}

function timeStop(){
  clearInterval(timerElement);
  timerElement = null;
  finalTime = Date.now() - timerStart;
  
  document.querySelector("h2.timer").textContent = `${parseTime(finalTime)}`;
}

function initializeGame() {
  cells.forEach((cell) => {
    cell.textContent = "";
    cell.dataset.selected = "";
    cell.addEventListener("click", handleCellClick, { once: true });
  });
  gameBoard.fill(null);
  currentPlayer = HUMAN_PLAYER;
  statusText.dataset.status = currentPlayer;
  bgChange(statusText.dataset.status);
  timeStop();
  document.querySelector("h2.timer").innerHTML = "00:00.000";
}

function parseTime(t){
  const minutes = Math.floor(t / 60000).toString().padStart(2, "0");
  const seconds = Math.floor((t % 60000) / 1000).toString().padStart(2, "0");
  const milliseconds = t % 1000;
  return `${minutes}:${seconds}.${milliseconds.toString().padStart(3, "0")}`
}

async function handleCellClick(e) {
  const cell = e.target;
  const index = cell.dataset.index;

  if (gameBoard[index] || checkWinner(gameBoard)) return;
  if (!timerElement) timeStart();

  makeMove(index, HUMAN_PLAYER);
  if (checkWinner(gameBoard)) {
    statusText.dataset.status = "win";
    bgChange(statusText.dataset.status);
    timeStop();
    
    const {value:name} = await Swal.fire({
      title: 'Eredmény beküldése',
      input: "text",
      text: `Gratulálunk az eredményedhez (${parseTime(finalTime)})! Add meg a neved az eredményed beküldéséhez!`,
      showCancelButton: true
    })
    if (name) {
      // TODO: ezt majd xddd
    }

    return;
  }

  if (gameBoard.every((cell) => cell !== null)) {
    statusText.dataset.status = "draw";
    bgChange(statusText.dataset.status);
    timeStop();
    return;
  }

  currentPlayer = AI_PLAYER;
  statusText.dataset.status = currentPlayer;
  bgChange(statusText.dataset.status);

  setTimeout(() => {
    const aiMove = getBestMove(gameBoard);
    makeMove(aiMove, AI_PLAYER);

    if (checkWinner(gameBoard)) {
      statusText.dataset.status = "lose";
      bgChange(statusText.dataset.status);
      timeStop();
      return;
    }

    if (gameBoard.every((cell) => cell !== null)) {
      statusText.dataset.status = "draw";
      bgChange(statusText.dataset.status);
      timeStop();
      return;
    }

    currentPlayer = HUMAN_PLAYER;
    statusText.dataset.status = currentPlayer;
    bgChange(statusText.dataset.status);
  }, 500);
}

function makeMove(index, player) {
  gameBoard[index] = player;
  cells[index].textContent = player;
  cells[index].dataset.selected = player;
}

function checkWinner(board) {
  for (const combination of WINNING_COMBINATIONS) {
    const [a, b, c] = combination;
    if (board[a] && board[a] === board[b] && board[a] === board[c]) {
      return board[a];
    }
  }
  return null;
}

function minimax(board, depth, isMaximizing) {
  const winner = checkWinner(board);

  if (winner === AI_PLAYER) return 10 - depth;
  if (winner === HUMAN_PLAYER) return depth - 10;
  if (board.every((cell) => cell !== null)) return 0;

  if (isMaximizing) {
    let bestScore = -Infinity;
    let bestMoves = [];

    for (let i = 0; i < board.length; i++) {
      if (board[i] === null) {
        board[i] = AI_PLAYER;
        const score = minimax(board, depth + 1, false, difficulty);
        board[i] = null;

        if (score > bestScore) {
          bestScore = score;
          bestMoves = [i];
        } else if (score === bestScore) {
          bestMoves.push(i);
        }
      }
    }

    if (Math.random() > 1 - difficulty) {
      return bestMoves[Math.floor(Math.random() * bestMoves.length)];
    }

    return bestScore;
  } else {
    let bestScore = Infinity;
    let bestMoves = [];

    for (let i = 0; i < board.length; i++) {
      if (board[i] === null) {
        board[i] = HUMAN_PLAYER;
        const score = minimax(board, depth + 1, true, difficulty);
        board[i] = null;

        if (score < bestScore) {
          bestScore = score;
          bestMoves = [i];
        } else if (score === bestScore) {
          bestMoves.push(i);
        }
      }
    }

    if (Math.random() > 1 - difficulty) {
      return bestMoves[Math.floor(Math.random() * bestMoves.length)];
    }

    return bestScore;
  }
}

function getBestMove(board) {
  let bestScore = -Infinity;
  let bestMove = null;

  for (let i = 0; i < board.length; i++) {
    if (board[i] === null) {
      board[i] = AI_PLAYER;
      const score = minimax(board, 0, false, difficulty);
      board[i] = null;
      if (score > bestScore) {
        bestScore = score;
        bestMove = i;
      }
    }
  }

  return bestMove;
}

resetButton.addEventListener("click", initializeGame);

difficultySelect.addEventListener("change", () => {
  difficulty = parseFloat(difficultySelect.value);
  initializeGame();
  bgChange(statusText.dataset.status || "x");
});

initializeGame();
bgChange(statusText.dataset.status || "x");

function anim() {
  resetButton.classList.add("spin");
  setTimeout(() => {
    resetButton.classList.remove("spin");
  }, 500);
}