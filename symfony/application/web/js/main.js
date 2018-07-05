var player1Name = "";
var player2Name = "";
var grid = [[0,0,0],[0,0,0],[0,0,0]];
var hasWinner = 0;
var gameId = 0;
var turn = "O";

function boardMsg(x){
    return $("#board").text(x);
}

function init() {
    grid = [[0,0,0],[0,0,0],[0,0,0]];
    boardMsg("");

    $(".col").map(function() {
        $(this).text("");
    }).get();

    hasWinner = 0;

    $.ajax({
        url: "/api/game/new",
        type: "POST",
        contentType: "application/json",
        success: function (data) {
            if (data.type === "success") {
                gameId = data.gameId;
                turn = "X";
            }
        },
        error: function () {
            alert("Error, please try again!");
        }
    });
}

$("#playButton").click(function() {
    init();

    player1Name = "Bot";
    player2Name = $("#player-2-inp").val();

    if (player1Name == "") {
        alert("Please set your name!");
        return;
    }

    hasWinner=0;
    boardMsg(player2Name+"'s turn now!");
});

$(".col").click(function() {
    if (player2Name == "") {
        alert("Please set your name!");
        return;
    }

    if (turn == "O") {
        alert("Please wait your turn!");
        return;
    }

    turn = "O";
    var row = $(this).parent().index();
    var col = $(this).index();

    if (grid[row][col] !== 0) {
        alert("This position is taken. Please try other position.");
        return;
    }

    if (hasWinner == 1) {
        alert("Please click play again");
        return;
    }

    $(this).text("X");
    grid[row][col] = 2;

    boardMsg("Bot's turn now!");
    $.ajax({
        url: "/api/game/"+ gameId +"/play",
        type: "POST",
        data: JSON.stringify({
            move: [row, col, "X"]
        }),
        contentType: "application/json",
        success: function (data) {
            if (data.type === 'success') {

                if (data.action == "PlayNextTime" || data.action == "BotWon") {
                    row = data.move[0];
                    col = data.move[1];

                    grid[row][col] = 1;
                    $(".col-"+row+"-"+col).text("O");
                    turn = "X";
                }

                boardMsg(data.action);

                if (data.action == "BotWon" || data.action == "PlayerWon" || data.action == "Draw") {
                    boardMsg(data.action);
                    hasWinner = 1;
                    turn = "O";
                    alert(data.action + "! Please click play again");
                    return;
                }
            }
        },
        error: function () {
            alert("Error, please try again!");
        }
    });
});