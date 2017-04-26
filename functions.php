<?php

# ********login page*******
function loginCheck($login_name, $psw){
	# check name or email
	#test
}


#register page
function register($,$,$,$){
	# insert all register info into USER table
	# check if a duplicate user exist

}

#edit user info page
function userInfoEdit(){
	# update all info for a user
}

#post proj page
function postProj(){
	# inset all proj post info into PROJECT table

}

#*********start page********
#search
function searchingByKeyword($keyword){
	#using like cluse
	#if the result is not none, save the keyword into SearchingHistory table for the current user.


}

#show brief information for a project(after click "show detail button", use function showDetail)
function projBriefInfo(){
	#show some important info for a project
}


#show myProj info
function myProj(){

}

#show recent info
function recentProj(){
	# get the most recent n Proj record
}


#show project detail informations
function showDetail(){
	#query all information for the project
}


#show project update page(materials)
function showMaterials(){
	#list all materials and info
}


#show comments
function showComments(){

}

#show recent comments
function showRecentComment(){

}

#show recent pledge information
function showRecentPledge(){

}


#show recent like
function showRecentLike(){

}


# save the tags into tag history table(when user click a tag OR when user click a proj)
function tagHistory($tags){
	# if there are several tags for a project, save as several history records

}

# 
function showRecommand(){
	#based on tag history table and keyword history table
	#give n recommand results(use function projBriefInfo)
	#the recommand projects should be in pledging status, and the current user hasn't pledged money for it.

}



#*******pledge & like & comment********
#check if a project is finished
function checkProjStatus($project){
	#return the state of the project

}


#pledge money
function pledge($user,$project,$amount){
	#if the Project status is incomplete
	#if this user have the pledge for the record, then add the money to the previous amount
	#if user doesn't have record for this project, insert one
	# we can use trigger to update current_amount in table project
}



#like the project
function likeProj($user, $project){
	#user may like the project at any time

}


#comment the project
function postComment($user, $project, $comment){
	#user may post comment at any time

}


#post new material
function postMaterial(){

}




#*******rate********
#show all project can be reated for the current user
function showRateProj($user){
	
}


#rate the project
function rateProj($user, $proj, $star, $review){

}




?>