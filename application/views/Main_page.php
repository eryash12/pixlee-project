<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 2/26/16
 * Time: 6:48 PM
 */?>
<!DOCTYPE html>
    <html lang = "en" >
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
<!--            Bootstrap-->
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

            <!-- Optional theme -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

            <!-- Latest compiled and minified JavaScript -->

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

            <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css"/>
            <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="<?php echo base_url()?>files/styles.css">

        </head>
        <title>
            Instagram Collection
        </title>

        <body id="body" style="z-index: 0">
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?php echo base_url()?>">
                            <b>INSTAGRAM PHOTO VIEWER</b>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main ng-app="instCollection">
            <div class="container" ng-controller = "instCollectionCntrl">
            <div class="jumbotron selection-panel col-md-12" >
                    <div id="get-data-div"  >
                        <div class="form-container col-md-8 col-md-offset-2">
                            <div class="row">
                                <div class="get-started col-md-12 col-sm-12 col-xs-12" style="text-align: center">
                                Choose a tag to get started
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <md-input-container class = 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3'>
                                     <label>Tag</label>
                                     <input ng-model="tag">
                                </md-input-container>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5 col-sm-2 col-sm-offset-5 col-xs-2 col-xs-offset-4">
                                <md-button ng-click="submit()">Submit</md-button>
                                </div>
                            </div>

                        </div>
                        <div id="alert" class="alert alert-danger col-md-12 col-sm-12 col-xs-12" >
                            <strong>Error!</strong>{{alert}}.
                        </div>

                        <div class="loader-div col-md-12" style="display: none">
                            <div class="loader col-md-2 col-md-offset-5"></div>
                        </div>
                        <div id="dispImages" class="col-md-12" style="" >
                            <div class="row">
                                <ul class="pager" class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-2 col-sm-2 col-xs-2"><li class="previous"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex-itemsPerPage,maxIndex-itemsPerPage)">Previous</a></li></div>
                                    <div class="col-md-8 col-sm-8 col-xs-8 pagination-text">Displaying {{minIndex+1}} to {{maxIndex}} out of {{resultSize}} results</div>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><li class="next"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex+itemsPerPage,maxIndex+itemsPerPage)">Next</a></li></div>
                                </ul>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12" id="tag-displaying">{{'#'+displayTag}}</div>
                            <div class ="row">
                                <div ng-repeat = "img in displayResults">
                                    <div class="clearfix" ng-if="$index % 3 == 0"></div>
                                    <image-panel></image-panel>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="pager" class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-2 col-sm-2 col-xs-2"><li class="previous"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex-itemsPerPage,maxIndex-itemsPerPage)">Previous</a></li></div>
                                    <div class="col-md-8 col-sm-8 col-xs-8 pagination-text">Displaying {{minIndex+1}} to {{maxIndex}} out of {{resultSize}} results</div>
                                    <div class="col-md-2 col-sm-2 col-xs-2"><li class="next"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex+itemsPerPage,maxIndex+itemsPerPage)">Next</a></li></div>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
             </div>




            </div>
            </div>
        </main>
        <footer class="col-md-12">
            <hr/>
            <div  style="margin-top: 20px;margin-bottom: 20px;text-align: center">
                    Copyright © 2016 Yash Tamakuwala. All Rights Reserved.
            </div>
            <script>
                var base = "<?php echo base_url();?>";
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
            <script src="<?php echo base_url()?>files/jquery.xml2json.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
            <script src="https://code.angularjs.org/1.5.3/angular-resource.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js" async defer></script>
            <script src="<?php echo base_url()?>files/jquery.countdown.min.js"></script>
            <script src="<?php echo base_url()?>files/Main_page.js"></script>
        </footer>
        </body>
    </html>