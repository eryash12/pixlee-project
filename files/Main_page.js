var app = angular.module("instCollection",['ngMaterial','ngResource']);
app.controller('instCollectionCntrl',['$scope','$log','$http','$resource','$sce','$interval',function($scope,$log,$http,$resource,$sce,$interval){
    $scope.todaysDate = new Date();
    $scope.maxDate = new Date(
        $scope.todaysDate.getFullYear(),
        $scope.todaysDate.getMonth(),
        $scope.todaysDate.getDate());
    $scope.startDate ="";
    $scope.endDate = "";
    $scope.tag = "sanfrancisco";
    $scope.alert = "";
    $scope.itemsPerPage = 6;
    $scope.minIndex = 0;
    $scope.maxIndex =  $scope.itemsPerPage;
    var loader = $('.loader-div');
    var imgPanel = $('#dispImages');

    $http.get(base + 'home/get/sanfrancisco/1461567600/1461654000').then(function success(data){
        $log.info('get');
        console.log(data);
        $scope.allResults = data.data;
        $scope.paginateResults($scope.minIndex,$scope.maxIndex);
    }, function error (data) {
        $log.error(data);
    });
    $scope.submit = function(){

        if($scope.tag === ''){
            $scope.alert=' Please enter a Tag';
            $('#alert').css('display','block');
            return;
        }
        else if(!compareDates($scope.endDate,$scope.startDate)){
            $scope.alert=' Start Date cannot be after the End Date';
            $('#alert').css('display','block');
            return;
        }
        $scope.tag = $scope.tag.replace(/\s/g, '');
        var unixStartDate = Math.floor($scope.startDate/1000);
        var unixEndDate = Math.floor($scope.endDate/1000);
        unixEndDate+= 86400;
        var post_url = base + 'home/post/'+$scope.tag+'/'+unixStartDate+'/'+unixEndDate;
        //var post_url = base + '/post';
        console.log(unixStartDate);
        console.log(unixEndDate);
        $http.post(post_url).then(function success(data){
            $log.info('post');
            $log.info(data);
        },function error(err){
           $log.error(err);
        });

        var get_url =  base + 'home/get/'+$scope.tag+'/'+unixStartDate+'/'+unixEndDate;
        $scope.getResults(get_url);
        $interval(function(){
            $scope.getResults(get_url);
        },10000)

    }

    $scope.getResults = function(get_url){
        if($scope.allResults.length<$scope.itemsPerPage) {
            imgPanel.css('display', 'none');
            loader.css('display', 'block');
        }
        $http.get(get_url).then(function success(data){
            $log.info('get');
            console.log(data);
            $scope.allResults = data.data;
            $scope.paginateResults($scope.minIndex,$scope.maxIndex);
            if($scope.allResults.length>$scope.itemsPerPage) {
                loader.css('display', 'none');
                imgPanel.css('display', 'block');
            }

        }, function error (data) {
            $log.error(data);
        });
    };
    $scope.displayResults = [];
    $scope.paginateResults = function(minIndex,maxIndex){

        if(maxIndex-minIndex < $scope.itemsPerPage){
            maxIndex = minIndex + $scope.itemsPerPage;
        }
        if(minIndex <= 0){
            $('.previous').hide();
            minIndex =0;

        }
        else{
            $('.previous').show();
        }
        if(maxIndex >= $scope.allResults.length ){
            $('.next').hide();

            maxIndex = $scope.allResults.length;

        }
        else{
            $('.next').show();
        }
        $scope.minIndex = minIndex;
        $scope.maxIndex = maxIndex;
        $scope.displayResults = [];
        for(var i = minIndex; i < maxIndex ; ++i){
            $scope.displayResults.push($scope.allResults[i]);
        }
        console.log($scope.itemsPerPage);
    }


    $scope.getFormattedDate = function (date) {

        date = new Date(date * 1000);
        return ((date.getMonth()+1)+"/"+date.getDate()+"/"+date.getFullYear());
    }
    function compareDates(date1, date2) {
        return new Date(date1).getDate() > new Date(date2).getDate();
    }
    $scope.trustSrc = function(src) {
        return $sce.trustAsResourceUrl(src);
    }


}]);
app.directive("imagePanel",function(){
    return {
        restrict: 'E',
        templateUrl  : base + "files/directives/img_html.php",
        replace: true


    }
});
app.directive('fallbackSrc', function () {
    var fallbackSrc = {
        link: function postLink(scope, iElement, iAttrs) {
            iElement.bind('error', function() {
                angular.element(this).attr("src", iAttrs.fallbackSrc);
            });
        }
    }
    return fallbackSrc;
});