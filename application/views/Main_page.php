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
                            <b>PIXLEE INSTAGRAM PROJECT</b>
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
                            <div class="get-started">
                                Choose a tag and dates to get started
                            </div>
                            <md-input-container class = 'col-md-4'>
                                 <label>Tag</label>
                                 <input ng-model="tag">
                            </md-input-container>
                            <md-datepicker class="col-md-4" ng-model="startDate"  md-placeholder="Start date"
                                           md-min-date="" md-max-date="maxDate">
                            </md-datepicker>
                            <md-datepicker class="col-md-4" ng-model="endDate"  md-placeholder="End date"
                                           md-min-date="startDate" md-max-date="maxDate">
                            </md-datepicker>
                            <div class="col-md-2 col-md-offset-1">
                            <md-button ng-click="submit()">Submit</md-button>
                            </div>
                        </div>
                        <div id="alert" class="alert alert-danger col-md-12" >
                            <strong>Error!</strong>{{alert}}.
                        </div>

                        <div class="loader-div col-md-12" style="display: none">
                            <div class="loader col-md-2 col-md-offset-5"></div>
                        </div>
                        <div id="dispImages" class="col-md-12" style="" >
                            <div class="col-md-12">
                            <ul class="pager">
                                <li class="previous"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex-itemsPerPage,maxIndex-itemsPerPage)">Previous</a></li>
                                Displaying {{minIndex+1}} to {{maxIndex}} out of {{resultSize}} results
                                <li class="next"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex+itemsPerPage,maxIndex+itemsPerPage)">Next</a></li>
                            </ul>
                            </div>
                            <div id="tag-displaying">{{'#'+displayTag}}</div>
                            <image-panel ng-repeat = "img in displayResults" image = "img" base = "{{base}}"></image-panel>
                            <div class="col-md-12">
                            <ul class="pager">
                                <li class="previous"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex-itemsPerPage,maxIndex-itemsPerPage)">Previous</a></li>
                                Displaying {{minIndex+1}} to {{maxIndex}} out of {{resultsize}} results
                                <li class="next"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex+itemsPerPage,maxIndex+itemsPerPage)">Next</a></li>
                            </ul>
                            </div>
                        </div>

                    </div>
             </div>




            </div>
            </div>
        </main>
        <footer class="col-md-12">
            <hr/>
            <div class="col-md-4 col-md-offset-4" style="margin-top: 20px;margin-bottom: 20px">
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