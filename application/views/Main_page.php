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


            <link rel="icon" type="image/png" href="<?php echo base_url()?>files/pics/bartlogo.png" />
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
                            <img alt="Brand" src="<?php echo base_url()?>files/pics/bartlogo.png" height = "30px" width="50px">
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main ng-app="instCollection">
            <div class="container" ng-controller = "instCollectionCntrl">
            <div class="jumbotron selection-panel col-md-12" >
<!--                <ul class="nav nav-tabs">-->
<!---->
<!--                    <li role="presentation" class="active"><a data-toggle="tab" href="#get-data-div">Add Tags</a></li>-->
<!--                    <li role="presentation" ><a data-toggle="tab" href="#search">View Collections</a></li>-->
<!---->
<!--                </ul>-->
<!--                <h2>All Bart Stations</h2>-->

<!--                <div class="tab-content">-->
<!--                    <div id="search" class="tab-pane fade ">-->
<!--                        <h2>Choose your stations to get started!</h2>-->
<!--                        <form class="form-inline" style="margin-top: 30px">-->
<!--                            <div class="form-group">-->
<!--                                <!--                        <label for="exampleInputName2">Source</label>-->
<!--                                <input type="text" id="src-input" class="form-control station-box"  placeholder="Source">-->
<!--                                <div class="list-group" id="src-list" style="display: none;">-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="form-group" style="margin-left: 40px">-->
<!--                                <!--                        <label for="exampleInputEmail2">Destination</label>-->
<!--                                <input type="email" id="dest-input" class=" station-box form-control"  placeholder="Destination">-->
<!--                                <div class="list-group" id="dest-list" style="display: none">-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </form>-->
<!--                        <button id="search-submit" type="submit" class="btn btn-default" style="margin-top: 50px">Search Routes</button>-->
<!---->
<!--                        <div id="clock" style="margin-top: 10px"></div>-->
<!---->
<!--                        <div id="route-display" style="display: none">-->
<!---->
<!--                        </div>-->
<!--                        <div id="map" style="height: 400px ; width: inherit;display: none;" ></div>-->
<!--                    </div>-->
                    <div id="get-data-div"  >

                        <div class="form-container col-md-12">
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
                            <md-button ng-click="submit()">Submit</md-button>
                        </div>
                        <div id="alert" class="alert alert-danger col-md-12" style="display: none">
                            <strong>Error!</strong>{{alert}}.
                        </div>
                        <div></div>
                        <input ng-model = "itemsPerPage" type="text"/>
                        <ul class="pager">
                            <li class="previous"><a href="javascript:void(0)" ng-click = "paginatePrev()">Previous</a></li>
                            Displaying {{minIndex+1}} to {{maxIndex}} out of {{allResults.length}} results
                            <li class="next"><a href="javascript:void(0)" ng-click = "paginateNext()">Next</a></li>
                        </ul>
                        <div id="dispImages" class="col-md-12">
<!--                            <div class="col-md-4 imgFrame">-->
<!--                                <div class="frame-header col-md-12">-->
<!--                                    <div class="frame-header-left col-md-9">-->
<!--                                        <img src="https://scontent.cdninstagram.com/t51.2885-19/s150x150/11349312_739459116155811_1310287381_a.jpg" class="img-circle prof-pic" alt=""/>-->
<!--                                        <span class="user-name-text col-md-9">yash.tamakuwalalalalalalal</span>-->
<!--                                    </div>-->
<!--                                    <div class="frame-header-right col-md-3">-->
<!--                                        <span class="date-text">{{dispDate}}</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <img class="img-thumbnail  img" src="https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/12965854_232658923757766_1298186547_n.jpg?ig_cache_key=MTIzNTMwOTE5Nzk4NzI0NDk4NA%3D%3D.2" alt=""/>-->
<!--                                <div class="frame-footer col-md-12">-->
<!--                                    <i class="fa fa-heart" aria-hidden="true"></i>-->
<!--                                    <span class="like-text">10000000</span>-->
<!--                                     &nbsp;-->
<!--                                    <i class="fa fa-map-marker" aria-hidden="true"></i>-->
<!--                                    <span>Taj Mahal</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <image-panel ng-repeat = "img in displayResults" image = "img" base = "{{base}}"></image-panel>




                            </div>
                        </div>
                        <ul class="pager">
                            <li class="previous"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex - itemsPerPage,maxIndex - itemsPerPage)">Previous</a></li>
                            Displaying {{minIndex+1}} to {{maxIndex}} out of {{allResults.length}} results
                            <li class="next"><a href="javascript:void(0)" ng-click = "paginateResults(minIndex + itemsPerPage,maxIndex + itemsPerPage)">Next</a></li>
                        </ul>


            </div>




            </div>
            </div>
        </main>
        <footer>
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