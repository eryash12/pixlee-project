This project is built on LAMP stack.
Front End technologies used are Twitter Bootstrap and AngularJS Framework along with JQuery, Javascript.
Back End technologies Used are PHP, MySql on Apache Web Server.

1)In order to run this project first start you apache and mysql server and place the directory in htdocs and create a schema in your MySql named pixlee_project_db
2)Then import the pixlee_project_db.sql file which will populate all the tables needed for running the application
3)then go to application/config/config.php and change $config['base_url'] = 'http://localhost/pixlee-project/'; according to your server
4)change the rewrite base in .htaccess in pixlee-project/.htaccess RewriteBase /pixlee-project
5)go to config/database.php and update 'username' => 'root', according to your machine.
                                       	'password' => '',
6)now you should see the application when you run localhost/pixlee-project/