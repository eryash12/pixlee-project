This project is built on <strong>LAMP stack</strong>.</br>
<strong>Front End technologies used are Twitter Bootstrap and AngularJS Framework along with JQuery, Javascript.</strong></br>
<strong>Back End technologies Used are PHP, MySql on Apache Web Server.</strong></br>
</br>
1)In order to run this project first start you apache and mysql server and place the directory in htdocs and create a schema in your MySql named pixlee_project_db </br>
2)Then import the pixlee_project_db.sql file which will populate all the tables needed for running the application</br>
3)then go to application/config/config.php and change $config['base_url'] = 'http://localhost/pixlee-project/'; according to your server</br>
4)change the rewrite base in .htaccess in pixlee-project/.htaccess RewriteBase /pixlee-project</br>
5)go to config/database.php and update 'username' => 'root', according to your machine.</br>
                                       	'password' => '',
6)now you should see the application when you run localhost/pixlee-project/</br>
</br></br>
Details about files</br></br>
1) The html page is stored in /pixlee-project/application/views/Main_page.php</br>
2) The js and css files are /pixlee-project/files/Main_page.js</br>
                            /pixlee-project/files/styles.css</br>
3) Angular directives are stored in /pixlee-project/files/directives</br>
4) Controllers are in /pixlee-project/application/controllers/Home.php</br>
5) Sql queries are in /pixlee-project/application/models/User_model.php</br>

The live project is hosted on http://insta.yashtam.info on AWS EC2 server.</br>
