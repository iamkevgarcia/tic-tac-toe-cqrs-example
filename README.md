# Tic Tac Toe CQRS Example [![Build Status](https://travis-ci.org/kev93/tic-tac-toe-cqrs-example.svg?branch=master)](https://travis-ci.org/kev93/tic-tac-toe-cqrs-example)

## Quick Start
This is a simple tic tac toe app (only code that is prepared to manage games) made by following a simple CQRS architecture.

Note that code focuses on the Tic Tac Toe game bounded context, so there is no framework installed 
in order to answer http requests, there is no database, there are some php files that you can execute from the CLI instead.

### 1.- Clone this repo
Execute: `git clone https://github.com/kev93/tic-tac-toe-cqrs-example.git`

### 2.- Set up the project dependencies
Composer is used to handle the dependencies. You can download it executing:
`curl -sS https://getcomposer.org/installer | php`

And then you can install all the dependencies and setting your parameters executing:
`php composer.phar install`

OR

You can use the docker-compose included in the project and avoid installation with `docker-compose up`.

### 3.- Execute unit tests
Execute the unit tests by doing `vendor/bin/phpunit`

### 4.- Execute php files from CLI
Keep in mind that you need to pass valid uuid to create resources.

**- create user [UserId]:** `php applications/cli/createUser.php 63c29b4e-d2f7-11e7-9296-cec278b6b50a` 
 
**- delete user [UserId]:**  `php applications/cli/deleteUser.php 63c2b322-d2f7-11e7-9296-cec278b6b50a`
 
**- start new game [GameId] [XPlayerId] [OPlayerId]:** `php applications/cli/startGame.php f795dc8b-0900-412f-9d32-3e612da1bee0 63c29b4e-d2f7-11e7-9296-cec278b6b50a 78c29b4e-d2f7-11e7-9296-cec278b6b50a`
 
**- player move [MoveId] [GameId] [PlayerId] [Position]:** `php applications/cli/makeAMove.php f795dc8b-0900-412f-9d32-3e612da1bee0 63c2b07a-d2f7-11e7-9296-cec278b6b50a a795dc8b-0900-412f-9d32-3e612da1bee0 1`
 
**- check if game has finished [GameId]:** `php applications/cli/gameIsFinished.php f795dc8b-0900-412f-9d32-3e612da1bee0`
 
**- check if there is a winner [GameId]:** `php applications/cli/gameHasWinner.php f795dc8b-0900-412f-9d32-3e612da1bee0`

### Extra
This directory structure has been made taking some ideas and helper classes from [CodelyTv CQRS example](https://github.com/CodelyTV/cqrs-ddd-php-example)
and also some ideas of implementation and project structure from [Last wishes DDD example](https://github.com/dddinphp/last-wishes)
