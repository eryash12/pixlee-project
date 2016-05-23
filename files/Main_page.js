//instantiating angular
var app = angular.module("instCollection",['ngMaterial','ngResource']);

//setting up the controller
app.controller('instCollectionCntrl',['$scope','$log','$http','$resource','$sce','$interval',function($scope,$log,$http,$resource,$sce,$interval){


    $scope.tag = "sanfrancisco";
    $scope.alert = "";
    $scope.itemsPerPage = 6;
    //minIndex and maxIndex for pagination
    $scope.minIndex = 0;
    $scope.maxIndex =  $scope.itemsPerPage;
    $scope.displayTag = "";
    $scope.checkTag = "";
    $scope.resultSize ="";
    var loader = $('.loader-div');
    var imgPanel = $('#dispImages');
    var alert = $('#alert');
    alert.hide();
    //displaying default data on page load
    $http.get(base + 'home/get/sanfrancisco').then(function success(data){
        $scope.allResults = data.data;
        $scope.checkTag = $scope.allResults[0].search_tag;
        $scope.paginateResults($scope.minIndex,$scope.maxIndex);
        }, function error (data) {
        $log.error(data);
    });
    // function called when user enters details and clicks submit
    $scope.submit = function(){
        $scope.minIndex = 0;
        $scope.maxIndex = $scope.itemsPerPage;
        //check if tag is filled
        if($scope.tag === ''){
            $scope.alert=' Please enter a Tag';
            alert.fadeIn();
            alert.fadeOut(15000);
            return;
        }
        //replace spaces in the tag
        $scope.tag = $scope.tag.replace(/\s/g, '');

        //url to call the post function used for collection of data
        var post_url = base + 'home/post/'+$scope.tag;
        //var post_url = base + '/post';
        $http.post(post_url).then(function success(data){
            //if the tag contains no data the backend will echo no results
            if(data.data === 'no results'){
                $scope.alert = ' No results found';
                alert.fadeIn();
                alert.fadeOut(15000);
                imgPanel.css('display','none');
                loader.css('display','none');
                return;
            }
        },function error(err){
           $log.error(err);
        });
        imgPanel.css('display', 'none');
        loader.css('display', 'block');
        //url to ask data to the server
        var get_url =  base + 'home/get/'+$scope.tag;
        $scope.getResults(get_url);
        $interval(function(){
            $scope.getResults(get_url);
        },10000)

    }
    //function to query server for data
    $scope.getResults = function(get_url){
        $http.get(get_url).then(function success(data){
            if(data.data.length > 0 && data.data[0].search_tag === $scope.tag) {
                $scope.allResults = data.data;
                $scope.checkTag = $scope.allResults[0].search_tag;
                $scope.paginateResults($scope.minIndex, $scope.maxIndex);
            }
        }, function error (data) {
            $log.error(data);
        });
    };
    $scope.displayResults = [];
    //function which responds to pagination
    $scope.paginateResults = function(minIndex,maxIndex){
        // to filter errand ajax responds
        if($scope.checkTag !== $scope.tag){
            return;
        }
        else{
            $scope.displayTag = $scope.allResults[0].search_tag;
        }
        $scope.resultSize = $scope.allResults.length;
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
        loader.css('display', 'none');
        imgPanel.css('display', 'block');
        console.log($scope.itemsPerPage);
    }

    //function to change unix date to human redable
    $scope.getFormattedDate = function (date) {
        date = new Date(date * 1000);
        return ((date.getMonth()+1)+"/"+date.getDate()+"/"+date.getFullYear());
    }
    // function for angular to trust http:// link
    $scope.trustSrc = function(src) {
        return $sce.trustAsResourceUrl(src);
    }


}]);
//angular custom directive for a single image display panel
app.directive("imagePanel",function(){
    return {
        restrict: 'E',
        templateUrl  : base + "files/directives/img_html.php",
        replace: true


    }
});
//angular directive for src verification
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