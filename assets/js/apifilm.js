import React from 'react'

var API_KEY = '2ee2c5b569240ea2a2a879dd9c8a822c';
var cool=document.querySelector('.rech');
var clef="https://api.themoviedb.org/3/trending/movie/week?api_key="+API_KEY;

$.getJSON(clef,displaytrendingmovies);
if($('.movie-informations')){
	getmovieinformation();
}


// $('.entrer').on('click', researchfilm);
// $(document).on('click', '.results-section li p', getmovieinformation);
// $('#pet-select').on('change',changegenre);

// function changegenre(){
// 	var genre=$('#pet-select').val();
// 	var clef='http://api.themoviedb.org/3/discover/movie?api_key='+API_KEY+'&with_genres='+genre;
// 	console.log(clef);
// 	$.getJSON(clef,displaytrendingmovies);
// }

// function getgenre(response){
// console.log(response);
// }

// researchfilmstrendingintheatres();


// function researchfilm() {
// 	var recherche= cool.value;
// 	var clef='https://api.themoviedb.org/3/search/movie?api_key='+API_KEY+'&language=en-US&query='+recherche+'&page=1&include_adult=false';
// 	$.getJSON(clef, recupFilm);
// }


// function recupFilm(response) {
// 	var list = $('<ul>');
//  	for (var i = 0 ; i < response.results.length; i++) {
// 	 		var li = $('<li>');

// 	 		list.append(li.append('<p data-id="'+response.results[i].id+'">'+response.results[i].original_title+'</p>'));	
//  	}
//  	$('.trending-section').html(list);
// }



function getmovieinformation(){
	console.log($('.movie-id').attr('class'));
	let movieIndex = parseInt($('.movie-id').attr('class').split(' ')[0].split('-')[1]);
  	$('.movie-information').removeClass('hide');
	var clef2 ='https://api.themoviedb.org/3/movie/'+movieIndex+'?api_key='+API_KEY+'';
	$.getJSON(clef2, loadmovieinformation);
  	}


function loadmovieinformation(response){
	console.log(response);
	var list = $('.movie-informations');
	var imglink = '<a><img src=https://image.tmdb.org/t/p/w185_and_h278_bestv2/'+response.poster_path+'></a>'
	$('.movie-informations').prepend(imglink);
	$('.title').append(response.original_title);
	$('.synopsis').append(response.overview);
	$('.release-date').append(response.release_date.split('-')[0]);
	$('.rating').append(response.vote_average);
}

// function researchfilmstrendingintheatres () {
// 	var clef="https://api.themoviedb.org/3/trending/movie/week?api_key="+API_KEY;
// 	$.getJSON(clef,displaytrendingmovies);
// }

function displaytrendingmovies (response){
	var list = $('.movie-display-section');
	var yo=$('<h2 class="trending-title">Trending aka à la mode </h2>');
 	for (var i = 0 ; i < 15 ; i++) {
 		if (i===0) {
 			list.append(yo);
 		}
		var imglink = '<a href="movie/'+response.results[i].id+'"><img class="trending-posters" src=https://image.tmdb.org/t/p/w600_and_h900_bestv2/'+response.results[i].poster_path+' data-id="'+response.results[i].id+' "></a>';
	 		var li = $('<article class="trendingmovie">');
	 		list.append(li.append(imglink+'<div class="movie-title-section"><p data-trendingid="'+response.results[i].id+'" class="movietrending">'+response.results[i].original_title+'</p></div>'));	
 	}
 	$('.results-section').html(list);

}


 export default Element;