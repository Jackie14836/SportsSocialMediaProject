This project is for the SE 3910 Software Engineering class held in Fall '19 at University of Central Missouri. 
The professor in charge of this class is Dr Taeghyun Kang.  
This web application provides a platform where one can join their friends and talk about their favorite teams and players. 
An individual can create a profile page with their favorite teams and players.
The application also supports multiple simultaneous chat rooms.  
In addition, the application stores the individual’s credentials and preferences in a persistent data store, file or database. 
It also provides some authentication and authorization mechanism.  
The application is in 3 parts, a web UI, a centralized process to manage the chat and chat rooms and persist the credentials and a persistent storage mechanism.

To connect to the database:

1.start your apache server
2.change the MySQL username and password in connection.php 3)Make sure if you do not already, to add the favorite_team (user_name, team) and favorite_player(user_name, player) tables to your database.

To run the public chatroom:

1.go to the folder php-chat in your command prompt/ terminal.
2.Enter "php php-socket.php" in your command prompt/ terminal.
