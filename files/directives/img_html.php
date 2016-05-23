<?php
/**
 * Created by PhpStorm.
 * User: yash
 * Date: 4/25/16
 * Time: 11:45 AM
 */?>
<div class="col-md-4 col-sm-12 col-xs-12 imgFrame">
    <div class="frame-header col-md-12">
        <div class="frame-header-left col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-1 col-xs-9 col-xs-offset-1">
            <div class="row">
            <img ng-src="{{img.user_dp}}" class="img-circle prof-pic" alt=""/>
            <span class="user-name-text col-md-9">{{img.user_name}}</span>
            </div>
        </div>
        <div class="frame-header-right col-md-2 col-sm-2 col-xs-2">
            <div class="row">
            <span class="date-text">{{getFormattedDate(img.time_posted)}}</span>
            </div>
        </div>
    </div>
    <div class="imgFrameBody">
        <img class="img-thumbnail img" ng-if = "img.content_type === 'image'" src="{{img.img_url_std}}" alt=""/>
        <video ng-if = "img.content_type === 'video'" class="img-thumbnail img"  controls>
            <source src="{{trustSrc(img.img_url_std)}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="frame-footer col-md-12">
        <div class="col-md-12" style="padding: 0px">
            <span class="col-md-2 likes" style="padding: 0px">
            <a href="{{img.instagram_link}}" target="_blank" data-toggle="tooltip" title="Instagram link"><i class="fa fa-instagram" aria-hidden="true"></i></a>
             &nbsp;
            <i data-toggle="tooltip" title="Likes" class="fa fa-heart" aria-hidden="true"></i>
            <span class="like-text">{{img.likes}}</span>
            </span>
            &nbsp;
            <span  class="col-md-10 location" ng-if = "img.location !== ''">
            <i data-toggle="tooltip" title="Location" class="fa fa-map-marker" aria-hidden="true"></i>
            <span data-toggle="tooltip" title="{{img.location}}">{{img.location}}</span>
            </span>
        </div>
    </div>
    <hr/>
    <div class="caption col-md-12"><i data-toggle="tooltip" title="caption" class="fa fa-comment" aria-hidden="true"></i><span data-toggle="tooltip" title="{{img.caption}}">&nbsp;{{img.caption}}</span></div>
</div>
