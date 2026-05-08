(function () {
    const solvedBoard = [1, 2, 3, 4, 5, 6, 7, 8, 0];
    const boardElement = document.getElementById("puzzleBoard");
    const tiles = Array.from(document.querySelectorAll(".puzzle-tile"));
    const startBtn = document.getElementById("startBtn");
    const restartBtn = document.getElementById("restartBtn");
    const shuffleBtn = document.getElementById("shuffleBtn");
    const timerElement = document.getElementById("timer");
    const moveCountElement = document.getElementById("moveCount");
    const gameStatusElement = document.getElementById("gameStatus");
    const statusBox = document.getElementById("statusBox");
    const winMessage = document.getElementById("winMessage");
    const winSummary = document.getElementById("winSummary");
    const closeWinBtn = document.getElementById("closeWinBtn");

    let board = solvedBoard.slice();
    let gameActive = false;
    let timerId = null;
    let elapsedSeconds = 0;
    let moves = 0;
    let scoreSaved = false;

    function pad(value) {
        return String(value).padStart(2, "0");
    }

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;

        return `${pad(minutes)}:${pad(remainingSeconds)}`;
    }

    function updateTimer() {
        timerElement.textContent = formatTime(elapsedSeconds);
    }

    function startTimer() {
        stopTimer();
        timerId = window.setInterval(function () {
            elapsedSeconds += 1;
            updateTimer();
        }, 1000);
    }

    function stopTimer() {
        if (timerId !== null) {
            window.clearInterval(timerId);
            timerId = null;
        }
    }

    function resetCounters() {
        elapsedSeconds = 0;
        moves = 0;
        scoreSaved = false;
        updateTimer();
        moveCountElement.textContent = "0";
    }

    function tilePositionStyle(index) {
        const row = Math.floor(index / 3);
        const col = index % 3;

        return {
            top: `calc(${row} * (((100% - (2 * var(--tile-gap))) / 3) + var(--tile-gap)))`,
            left: `calc(${col} * (((100% - (2 * var(--tile-gap))) / 3) + var(--tile-gap)))`
        };
    }

    function renderBoard() {
        board.forEach(function (value, index) {
            if (value === 0) {
                return;
            }

            const tile = boardElement.querySelector(`[data-tile="${value}"]`);
            const position = tilePositionStyle(index);
            tile.style.top = position.top;
            tile.style.left = position.left;
            tile.disabled = !gameActive;
        });
    }

    function setStatus(text) {
        gameStatusElement.textContent = text;
        statusBox.textContent = text;
    }

    function inversionCount(values) {
        const numbers = values.filter(function (value) {
            return value !== 0;
        });
        let inversions = 0;

        for (let i = 0; i < numbers.length; i += 1) {
            for (let j = i + 1; j < numbers.length; j += 1) {
                if (numbers[i] > numbers[j]) {
                    inversions += 1;
                }
            }
        }

        return inversions;
    }

    function isSolved(values) {
        return values.every(function (value, index) {
            return value === solvedBoard[index];
        });
    }

    function isSolvable(values) {
        return inversionCount(values) % 2 === 0;
    }

    function shuffledBoard() {
        const values = solvedBoard.slice();

        do {
            for (let i = values.length - 1; i > 0; i -= 1) {
                const randomIndex = Math.floor(Math.random() * (i + 1));
                const temp = values[i];
                values[i] = values[randomIndex];
                values[randomIndex] = temp;
            }
        } while (!isSolvable(values) || isSolved(values));

        return values.slice();
    }

    function adjacentToBlank(tileIndex) {
        const blankIndex = board.indexOf(0);
        const tileRow = Math.floor(tileIndex / 3);
        const tileCol = tileIndex % 3;
        const blankRow = Math.floor(blankIndex / 3);
        const blankCol = blankIndex % 3;

        return Math.abs(tileRow - blankRow) + Math.abs(tileCol - blankCol) === 1;
    }

    function shuffleGame(keepRunning) {
        board = shuffledBoard();
        resetCounters();
        gameActive = Boolean(keepRunning);

        if (gameActive) {
            startTimer();
            setStatus("Game started");
        } else {
            stopTimer();
            setStatus("Puzzle shuffled");
        }

        renderBoard();
    }

    function startGame() {
        shuffleGame(true);
    }

    function restartGame() {
        shuffleGame(true);
    }

    function handleInvalidMove(tile) {
        tile.classList.add("invalid-move");
        window.setTimeout(function () {
            tile.classList.remove("invalid-move");
        }, 180);
    }

    function moveTile(tileValue, tile) {
        if (!gameActive) {
            setStatus("Click Start Game");
            return;
        }

        const tileIndex = board.indexOf(tileValue);
        const blankIndex = board.indexOf(0);

        if (!adjacentToBlank(tileIndex)) {
            handleInvalidMove(tile);
            setStatus("Invalid move");
            return;
        }

        board[blankIndex] = tileValue;
        board[tileIndex] = 0;
        moves += 1;
        moveCountElement.textContent = String(moves);
        setStatus("Playing");
        renderBoard();

        if (isSolved(board)) {
            finishGame();
        }
    }

    function finishGame() {
        gameActive = false;
        stopTimer();
        renderBoard();
        setStatus("Solved");

        const summary = `You solved the puzzle in ${formatTime(elapsedSeconds)} with ${moves} moves.`;
        winSummary.textContent = summary;
        winMessage.hidden = false;

        saveScore();
    }

    function saveScore() {
        if (scoreSaved) {
            return;
        }

        scoreSaved = true;

        const formData = new FormData();
        formData.append("action", "save_score");
        formData.append("moves", String(moves));
        formData.append("time_seconds", String(elapsedSeconds));

        fetch(window.eightPuzzleConfig.saveUrl, {
            method: "POST",
            body: formData,
            credentials: "same-origin"
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (!data.success) {
                    setStatus("Solved, score not saved");
                }
            })
            .catch(function () {
                setStatus("Solved, score not saved");
            });
    }

    startBtn.addEventListener("click", startGame);
    restartBtn.addEventListener("click", restartGame);
    shuffleBtn.addEventListener("click", function () {
        shuffleGame(gameActive);
    });

    closeWinBtn.addEventListener("click", function () {
        winMessage.hidden = true;
    });

    tiles.forEach(function (tile) {
        tile.addEventListener("click", function () {
            moveTile(Number(tile.dataset.tile), tile);
        });
    });

    renderBoard();
}());
