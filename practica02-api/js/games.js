const gamesList = document.querySelector('#games-list');
const games = gamesList.getElementsByTagName('li');

for(let i = 0; i < games.length; i++){
    games[i].addEventListener('click', function(){
        conectar(games[i].id);
    });
}
function conectar(game){
    const gameEncoded = encodeURIComponent(game);
    window.location.href = `get_scores.php?game=${gameEncoded}`;
}