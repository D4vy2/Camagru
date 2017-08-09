# Camagru

## What's that?

This project is the first web project of 42 school. 
The purpose is to create a web application to make a basic photo editing, using the webcam and some predefinites filters.

## Restrictions

* The language must be PHP.
* No framework, micro-framework, library allowed (No Bootstrap, no jQuery, no Symphony etc...).
* Only native javascript API from Browser are allowed.

## Main parts

The developpement of this project is kind of cut in 3 parts:
* User: Login, logout in any time, register with a strong password and a confirmation email, reinit password.
* Photo editing: The main part is the webcam image with the availables filters, and a lateral section of recents images thumbnails. You can also update your own picture, and delete your edited images.
* Gallery: This is a gallery of all members of the webapp, sorted by the date of creation. Every picture is commentable and likable. There is a notification email when a picture is commented.

## Installing

First you need to start Apache server (I'm using mamp).
To create the database, run in your browser "http://localhost:8080/config/setup.php".
Then if all is ok, you can run "http://localhost:8080/index.php".
