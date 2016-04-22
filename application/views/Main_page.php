<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 2/26/16
 * Time: 6:48 PM
 */?>
<!DOCTYPE html>
    <html lang = "en">
        <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="<?php echo base_url()?>files/jquery.xml2json.js"></script>

            <script src="https://maps.googleapis.com/maps/api/js" async defer></script>
            <script src="<?php echo base_url()?>files/jquery.countdown.min.js"></script>
            <script src="<?php echo base_url()?>files/Main_page.js"></script>

            <link rel="icon" type="image/png" href="<?php echo base_url()?>files/pics/bartlogo.png" />
<!--            Bootstrap-->
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

            <!-- Optional theme -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="<?php echo base_url()?>files/styles.css">

        </head>
        <title>
            Bart Train Scheduling
        </title>

        <body id="body" style="z-index: 0">
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?php echo base_url()?>">
                            <img alt="Brand" src="<?php echo base_url()?>files/pics/bartlogo.png" height = "30px" width="50px">
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container">
            <div class="jumbotron selection-panel" style="">
                <ul class="nav nav-tabs">

                    <li role="presentation" class="active"><a data-toggle="tab" href="#all-stations-div">All Stations</a></li>
                    <li role="presentation" ><a data-toggle="tab" href="#search">Search Route</a></li>

                </ul>
<!--                <h2>All Bart Stations</h2>-->

                <div class="tab-content">
                    <div id="search" class="tab-pane fade ">
                        <h2>Choose your stations to get started!</h2>
                        <form class="form-inline" style="margin-top: 30px">
                            <div class="form-group">
                                <!--                        <label for="exampleInputName2">Source</label>-->
                                <input type="text" id="src-input" class="form-control station-box"  placeholder="Source">
                                <div class="list-group" id="src-list" style="display: none;">

                                </div>
                            </div>
                            <div class="form-group" style="margin-left: 40px">
                                <!--                        <label for="exampleInputEmail2">Destination</label>-->
                                <input type="email" id="dest-input" class=" station-box form-control"  placeholder="Destination">
                                <div class="list-group" id="dest-list" style="display: none">

                                </div>
                            </div>

                        </form>
                        <button id="search-submit" type="submit" class="btn btn-default" style="margin-top: 50px">Search Routes</button>

                        <div id="clock" style="margin-top: 10px"></div>

                        <div id="route-display" style="display: none">

                        </div>
                        <div id="map" style="height: 400px ; width: inherit;display: none;" ></div>
                    </div>
                    <div id="all-stations-div" class="tab-pane fade in active">

                        <h2 id="welcome-msg"></h2>
                        <script>
                            var last_visited = localStorage.getItem("lastvisited");
                            if(last_visited == null ){
                                $("#welcome-msg").html("Welcome! Looks like its your first time here.");
                                localStorage.setItem("lastvisited",1);
                            }
                            else{
                                last_visited++;
                                $("#welcome-msg").html("Welcome! Looks like you like us. This is your "+last_visited+" visit");
                                localStorage.setItem("lastvisited",last_visited);
                            }
                        </script>
                        <h3>All Bart Stations</h3>
                        <ul id="all-stations" class="list-group"  style="max-height: 700px">

                        </ul>
                    </div>

                </div>


<!--                <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>-->

            </div>
            </div>
        </main>
        <footer>
<!--            Answer to the question-->
<!--            The Same origin policy can be disabled by other domains inorder to be accesible by other domains.
 On of the mechanisms is JSONP which dyanamically injects <script> tags to send a request to any domains along with any parameters.
 Another way is to invoke the Rest APis on other domains is to use the cross origin resource sharing mechanism(CORS) in which the
 browsers dont deny cross-origin requests. The target service tells the browser that it wants to allow cross-origin requests by inserting special HTTP headers in responses:
            Access-Control-Allow-Origin: http://www.example.com  -->

        </footer>
        </body>
    </html>