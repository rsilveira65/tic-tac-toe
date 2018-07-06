[![Build Status](https://travis-ci.com/rsilveira65/tic-tac-toe.svg?token=z2yf7ZpVZudwz9Cxdor9&branch=master)](https://travis-ci.com/rsilveira65/tic-tac-toe)

# tic-tac-toe

## Goal

Customer wants and application - Tic Tac Toe game bot. The application
should have an API that can be called to make the moves, and a web
interface, where the application can be visible. Create a project which:

- 1. has a Tic Tac Toe game inside.
- 2. The application needs to have an API, which could be used to request next move from the application for the game.
- 3. The application needs to have web interface, where game could be played against the bot and viewed in the page. Example: player can select a
move, and then the application makes a move using the same API created previously.

### Application API Should implement

```sh
interface MoveInterface
{
    /**
    * Makes a move using the $boardState
    * $boardState contains 2 dimensional array of the game field
    * X represents one team, O - the other team, empty string means field is not yet taken.
    * example
    * [['X', 'O', '']
    * ['X', 'O', 'O']
    * ['', '', '']]
    * Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.
    * Example: [2, 0, 'O'] - upper right corner - O player
    *
    * @param array $boardState Current board state
    * @param string $playerUnit Player unit representation
    *
    * @return array
    */
    public function makeMove($boardState, $playerUnit = 'X');
}
```
### Considerations:
- Testing
- Versioning (git bundle can be used)
- Code complexity
- Make sure to provide instructions how to view/run the application/service. If you do not complete the whole exercise - make sure to submit whatever you have before deadline. The style of the web interface isirrelevant, as long as it works the way it should.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
Just make sure you have [Docker](https://docs.docker.com/install/) and [Docker Compose](https://docs.docker.com/compose/install/) properly installed.

```sh
docker --version
docker-compose --version
```

### Installing

```sh
docker-compose up -d
```

Create the database schema.

```sh
docker exec application bin/console doctrine:schema:update --force
```

Access your browser on http://localhost

![](http://i.imgur.com/K9jIbUN.gif)

## API Routes
[Download the Postman collection](https://www.getpostman.com/collections/1f42decf154f1d5ab3f1)
### New game
```bash
POST: {{URL}}/api/game/new
```
##### Response:
```bash
{
    "gameId": 108,
    "board": [
        [
            " ",
            " ",
            " "
        ],
        [
            " ",
            " ",
            " "
        ],
        [
            " ",
            " ",
            " "
        ]
    ],
    "message": "Board created/updated successfully!",
    "type": "success",
    "action": "PlayNextTime",
    "move": null,
    "status": "Ongoing"
}
```

### Play game
```bash
POST: {{URL}}/api/game/{{game_id}}/play
```
##### Body:
```bash
{
    "move": [1, 2, "X"]
}
```
##### Response:
```bash
{
    "gameId": 1,
    "board": [
        [
            "O",
            " ",
            "X"
        ],
        [
            "O",
            "X",
            "X"
        ],
        [
            "O",
            " ",
            "O"
        ]
    ],
    "message": "Board created/updated successfully!",
    "type": "success",
    "action": "BotWon",
    "move": [1, 2, "O"]
    "status": "Completed"
}
```

## Unit Tests
Get unit test summary on executing

```sh
docker exec application composer test
```