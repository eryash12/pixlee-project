//
//$(document).ready(function(){
//    var stations;
//
//    $.get( "http://api.bart.gov/api/stn.aspx?cmd=stns&key=MW9S-E7SL-26DU-VV8V", function( data ) {
//
//        //alert( "Load was performed." );
//        stations = $.xml2json(data);
//        stations = stations['stations'];
//        stations = stations['station'];
//        for(var i = 0 ; i<stations.length ; ++i){
//
//            $("#all-stations").append("<li class=\"list-group-item col-md-6\">"+stations[i].name+" "+"["+stations[i].abbr+"]"+"</li>");
//        }
//
//    });
//    $('#src-input').keyup(function(){
//       var data = $(this).val();
//        var selectedStations =[];
//        if(data !== ""){
//            for(var i = 0 ; i<stations.length ; ++i){
//                var thisStation = stations[i].name;
//
//                if(thisStation.toLowerCase().indexOf(data.toLocaleLowerCase())!=-1){
//                    selectedStations.push(thisStation);
//                }
//            }
//
//        }else{
//            for(var i = 0 ; i<stations.length ; ++i){
//                var thisStation = stations[i].name;
//                selectedStations.push(thisStation);
//            }
//        }
//        populateSourceList(selectedStations);
//
//    });
//    function populateSourceList(selectedStations) {
//        var results = $("#src-list");
//        results.empty();
//        results.css("display","block");
//        href = "javascript:void(0)"
//        for(var i = 0 ; i<selectedStations.length ; ++i){
//            var thisStation = selectedStations[i];
//
//            results.append("<a href=" + href + " style=\"z-index = 1\" class=\"list-group-item src-station\">" + thisStation + "</a>");
//        }
//    }
//    $('#dest-input').keyup(function(){
//        var data = $(this).val();
//        var selectedStations =[];
//        if(data !== ""){
//            for(var i = 0 ; i<stations.length ; ++i){
//                var thisStation = stations[i].name;
//
//                if(thisStation.toLowerCase().indexOf(data.toLowerCase())!=-1){
//                    selectedStations.push(thisStation);
//                }
//            }
//
//        }
//        else {
//            for(var i = 0 ; i<stations.length ; ++i){
//                var thisStation = stations[i].name;
//                selectedStations.push(thisStation);
//            }
//        }
//        populateDestList(selectedStations);
//    });
//    function populateDestList(selectedStations) {
//        var results = $("#dest-list");
//        results.empty();
//        results.css("display","block");
//        href = "javascript:void(0)"
//        for(var i = 0 ; i<selectedStations.length ; ++i){
//            var thisStation = selectedStations[i];
//
//            results.append("<a href=" + href + " style=\"z-index = 1\" class=\"list-group-item dest-station\">" + thisStation + "</a>");
//        }
//    }
//    document.addEventListener('click', function(e){
//
//        if(e.target.id!=="src-input")
//            $("#src-list").css("display","none");
//
//        if(e.target.id==="src-input")
//            $("#src-list").css("display","block");
//        if(e.target.id!=="dest-input")
//            $("#dest-list").css("display","none");
//
//        if(e.target.id==="dest-input")
//            $("#dest-list").css("display","block");
//    });
//    $("#src-list").on('click','.src-station',function(e) {
//
//        $('#src-input').val($(this).text());
//    });
//    $("#dest-list").on('click','.dest-station',function(e) {
//
//        $('#dest-input').val($(this).text());
//    });
//    $("#search-submit").on('click',function(e){
//       displaySchedule();
//
//    });
//    var schedule ;
//    function displaySchedule()
//    {   timeFlag =1;
//        var srcStation =  $('#src-input').val();
//        var desStation = $('#dest-input').val();
//        if(srcStation === ""){
//            alert("Source station is not selected");
//            return;
//        }
//        if(desStation === ""){
//            alert("Destination station is not selected");
//            return;
//        }
//        if(srcStation === desStation){
//            alert("Source and destination stations cannot be same");
//            return;
//        }
//        var srcAbbr;
//        var destAbbr;
//        var srcLat;
//        var srcLng;
//        var desLat;
//        var desLng;
//        for(var i = 0 ; i<stations.length ; ++i){
//            if(srcStation === stations[i].name){
//                srcAbbr = stations[i].abbr;
//                srcLat = parseFloat(stations[i]['gtfs_latitude']);
//                srcLng = parseFloat(stations[i]['gtfs_longitude']);
//            }
//            if(desStation === stations[i].name){
//                destAbbr = stations[i].abbr;
//                desLat = parseFloat(stations[i]['gtfs_latitude']);
//                desLng = parseFloat(stations[i]['gtfs_longitude']);
//            }
//
//        }
//
//
//        //alert(srcAbbr + " " + destAbbr);
//        console.log("http://api.bart.gov/api/sched.aspx?cmd=depart&orig="+srcAbbr+"&dest="+destAbbr+"&date=now&key=MW9S-E7SL-26DU-VV8V&b=0&a=4&l=1");
//        $.get( "http://api.bart.gov/api/sched.aspx?cmd=depart&orig="+srcAbbr+"&dest="+destAbbr+"&date=now&key=MW9S-E7SL-26DU-VV8V&b=0&a=4&l=1", function( data ) {
//
//            //alert( "Load was performed." );
//            schedule = $.xml2json(data);
//            //stations = stations['stations'];
//            //stations = stations['station'];
//            console.log($.xml2json(data));
//
//        var departTimes = [];
//        var routeDiv = $("#route-display");
//        routeDiv.empty();
//        routeDiv.css('display','block');
//        routeDiv.append(" <h3>All routes from "+srcStation+" to "+desStation+"</h3>");
//        var srcdest = schedule.schedule;
//            srcdest = srcdest.request;
//        srcdest = srcdest.trip;
//        for(var i = 0 ; i<srcdest.length ; ++i){
//            var thisTrip = srcdest[i];
//            var legs = srcdest[i].leg;
//
//            //if(i=0)
//            routeDiv.append("<p><b>"+srcStation+"</b> Departure time "+thisTrip.origTimeMin+"  <b>"+desStation+"</b> arrival time "+thisTrip.destTimeMin+" <b>Total Fare</b> = $"+thisTrip.fare+"</p>");
//            console.log("<p>"+srcStation+" Departure time :"+thisTrip.origTimeMin+"  "+desStation+" arrival time :"+thisTrip.destTimeMin+" <b>Total Fare</b> = $"+thisTrip.fare+"</p>");
//            departTimes.push(thisTrip.origTimeMin)
//            var text = "";
//            text = text + " <table class=\"table\"> <thead> <tr> <th>Source</th> <th>Destination</th> <th>Dep Time</th> <th>Arr Time</th> <th>Line</th> <th>Towards</th> </tr> </thead> <tbody>"
//            console.log(legs instanceof Array);
//            console.log(typeof (legs));
//            if(legs instanceof Array) {
//                for (var j = 0; j < legs.length; ++j) {
//                    var thisLeg = legs[j];
//                    text = text + "<tr> <td>" + thisLeg.origin + "</td> <td>" + thisLeg.destination + "</td> <td>" + thisLeg.origTimeMin + "</td> <td>" + thisLeg.destTimeMin + "</td><td>" + thisLeg.line + "</td><td>" + thisLeg.trainHeadStation + "</td> </tr>";
//
//                    if (j === (legs.length - 1)) {
//                        text = text + "</tbody> </table>";
//
//                    }
//                }
//            }
//            else{
//                text = text + "<tr> <td>" + legs.origin + "</td> <td>" + legs.destination + "</td> <td>" + legs.origTimeMin + "</td> <td>" + legs.destTimeMin + "</td><td>" +legs.line + "</td><td>" + legs.trainHeadStation + "</td> </tr>";
//            }
//            routeDiv.append(text);
//
//        }
//            var today = new Date();
//            var dd = today.getDate();
//            var mm = today.getMonth()+1; //January is 0!
//            var yyyy = today.getFullYear();
//            var firstTime = departTimes[0];
//
//            var full_date = yyyy+"/"+mm+"/"+dd+" "+firstTime;
//            $('#clock').countdown(full_date, function(event) {
//                var totalHours = event.offset.totalDays * 24 + event.offset.hours;
//                $(this).html("Time left for your next train <b>"+event.strftime(totalHours + ' hr %M min %S sec')+"</b>");
//            });
//
//            $("#map").css("display","block");
//            initMap(srcLat,srcLng,desLat,desLng);
//        });
//
//    }
//
//    function initMap(srcLat,srcLng,desLat,desLng) {
//        var map;
//        var directionsDisplay = new google.maps.DirectionsRenderer;
//        var directionsService = new google.maps.DirectionsService;
//
//        map = new google.maps.Map(document.getElementById('map'), {
//            center: {lat: 37.3501000, lng: -121.9462250},
//            zoom: 14
//
//        });
//        directionsDisplay.setMap(map);
//        //var transitLayer = new google.maps.TransitLayer();
//        //transitLayer.setMap(map);
//        var selectedMode = 'TRANSIT';
//        var unix = Date.now();
//        directionsService.route({
//            origin: {lat: srcLat, lng: srcLng},
//            destination: {lat: desLat, lng: desLng},
//            travelMode: google.maps.TravelMode.TRANSIT,
//            transitOptions: {
//                departureTime: new Date(unix),
//                //modes: [google.maps.TransitMode.TRAIN],
//                routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
//            },
//            unitSystem: google.maps.UnitSystem.IMPERIAL
//        }, function(response, status) {
//            if (status == google.maps.DirectionsStatus.OK) {
//                directionsDisplay.setDirections(response);
//            } else {
//                window.alert('Directions request failed due to ' + status);
//            }
//        });
//    }
//    var timeFlag = 0;
//    window.setInterval(function(){
//        /// call your function here
//        if(timeFlag === 1 )
//        displaySchedule();
//    }, 30000);
//
//
//});

var app = angular.module("instCollection",['ngMaterial','ngResource']);
app.controller('instCollectionCntrl',['$scope','$log','$http','$resource',function($scope,$log,$http,$resource){
    $scope.todaysDate = new Date();
    $scope.maxDate = new Date(
        $scope.todaysDate.getFullYear(),
        $scope.todaysDate.getMonth(),
        $scope.todaysDate.getDate());
    $scope.startDate ="";
    $scope.endDate = "";
    $scope.tag = "";
    $scope.alert = "";
    $scope.submit = function(){

        if($scope.tag === ''){
            $scope.alert=' Please enter a Tag';
            $('#alert').css('display','block');
            return;
        }
        //else if(!compareDates($scope.endDate,$scope.startDate)){
        //    $scope.alert=' Start Date cannot be after the End Date';
        //    $('#alert').css('display','block');
        //    return;
        //}
        var unixStartDate = Math.floor($scope.startDate/1000);
        var unixEndDate = Math.floor($scope.endDate/1000);
        var get_url = base + 'home/get/'+$scope.tag+'/'+unixStartDate+'/'+unixEndDate;
        var post_url = base + 'home/post';
        $http.get(get_url).then(function success(data){
            $log.info(data);
        },function error(err){
           $log.error(err);
        });
        //$resource(url).get( function success(data) {
        //   $log.info(data);
        //}, function error(err){
        //    $log.error(err);
        //});


    }

    function compareDates(date1, date2) {
        return new Date(date1).getDate() > new Date(date2).getDate();
    }


}]);
