function pagination(nbParPage,divSelect,divPager,model)
{
    $('#pagination').empty();
    //Initialisation
    var nbElem = $(divSelect).length;
    var nbPage = Math.ceil(nbElem / nbParPage);
    var pageLoad = 1;
    $(divSelect).each(function(index) {
        if (index < nbParPage)
            $(divSelect).eq(index).show();
        else
            $(divSelect).eq(index).hide();
    });

    //Reset & vérification
    function reset() {
        if (nbPage < 2) $(divPager).hide();
        if (pageLoad == nbPage) $(divPager + ' span.suivant').hide(); else $(divPager + ' span.suivant').show();
        if (pageLoad == 1) $(divPager + ' span.precedent').hide(); else $(divPager + ' span.precedent').show();
        $(divPager + ' ul li').removeClass('selected');
        $(divPager + ' ul li').eq(pageLoad -1).addClass('selected');
    }

    //Pagination génération
    if (model != 1) {
        $(divPager).html('<ul></ul>');
        for(i = 1; i <= nbPage; i++) $(divPager + ' ul').append('<li>' + i + '</li>');

        //Changement click page
        $(divPager + ' ul li').click(function() {
            if ($(this).index() + 1 != pageLoad) {
                pageLoad = $(this).index() + 1;
                $(divSelect).hide();

                $(divSelect).each(function(i) {
                    if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                });

                reset();
            }
        });
    }

    //Suivant Précédent
    if (model == 1) {
        $(divPager).prepend('<span class="precedent">Precedent</span>');
        $(divPager).append('<span class="suivant">Suivant></span>');
    } else if (model == 3) {
        $(divPager + ' ul').before('<span class="precedent">Precedent</span>');
        $(divPager + ' ul').after('<span class="suivant">Suivant</span>');
    }

    //Evènement click sur suivant
    $(divPager + ' span.suivant').click(function() {
        if (pageLoad < nbPage) {
            pageLoad += 1;
            $(divSelect).hide();

            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).fadeIn();
            });

            reset();
        }
    });

    //Evènement click sur précédent
    $(divPager + ' span.precedent').click(function() {
        if (pageLoad -1 >= 1) {
            pageLoad -= 1;
            $(divSelect).hide();

            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).fadeIn();
            });

            reset();
        }
    });

    reset();
}

// Show or hide main menu
$(document).on("click", function (e) {
    e.stopPropagation();
    // TODO: USE JQUERY UI FOR EFFECT() IF POSSIBLE
    if (!$(e.target).parent().children(".dropdown-menu").length) {
        $(".dropdown-menu").hide();
    } else {
        $(e.target).parent().children(".dropdown-menu").toggle();
    }
});

/**************************
    -- DOCUMENT EVENTS --
**************************/

$(function ($) {
    // notifications
    $('#popin-notifications').on("click","a", function() {
        var $a = $(this);
        var id = $a.data("id");
        $.get('/notification/delete/' + id,function(){
        });
    });

    // msg-box
    $(".js-close-msg-box").click(function (ev) {
        $(this).parent().parent().fadeOut();
    });

});


    /**************************
         -- MANAGE ADMIN --
    **************************/
$(function ($) {

    $("#iframeAdmin").hide();

    $("a.addUser").click(function(ev){
        $("#hiddenUsers").hide();
        $("#hiddenTeams").hide();
        $("#iframeAdmin").show();
        $("#frameAdminGlobal").attr("src","../user/subscribe");
        $("#frameAdminGlobal").attr("style","height:500px;left:-65px;top:-200px;position:relative");
    })

    $("a.addTeam").click(function(ev){
        $("#hiddenUsers").hide();
        $("#hiddenTeams").hide();
        $("#iframeAdmin").show();
        $("#frameAdminGlobal").attr("src","../team/create");
        $("#frameAdminGlobal").attr("style","height:300px;left:-65px;top:-70px;position:relative");
    })

    $("a.manageUser").click(function(ev){
        $("#iframeAdmin").hide();
        $("#hiddenTeams").hide();
        $("#hiddenUsers").show();
        $("#frameAdminGlobal").attr("style","height:300px;left:-65px;top:-70px;position:relative");
    })

    $("a.manageTeam").click(function(ev){
        $("#iframeAdmin").hide();
        $("#hiddenUsers").hide();
        $("#hiddenTeams").show();
        $("#frameAdminGlobal").attr("style","height:300px;left:-65px;top:-70px;position:relative");
    })

    $("a.editUser").click(function(ev){
        $("#iframeAdmin").show();
        var userId = $(this).data("user");
        $("#frameAdminGlobal").attr("src","../user/edit/"+userId);
        $("#frameAdminGlobal").attr("style","height:1100px;left:-65px;top:-70px;position:relative");
    })

    $("a.editTeam").click(function(ev){
        $("#iframeAdmin").show();
        var teamId = $(this).data("team");
        $("#frameAdminGlobal").attr("src","../team/edit/"+teamId);
        $("#frameAdminGlobal").attr("style","height:500px;left:-65px;top:-70px;position:relative");
    })

    $("a.deleteUser").click(function(ev){
        var userId = $(this).data("user");
        if (confirm('Are you sure to delete this user ?')) {
            $("#frameAdminGlobal").attr("src","../user/delete/"+userId);
            //window.location.reload();
        }
    })

    $("a.deleteTeam").click(function(ev){
        var teamId = $(this).data("team");
        if (confirm('Are you sure to delete this team ?')) {
            $("#frameAdminGlobal").attr("src","../team/delete/"+teamId);
            window.location.reload();
        }
    })

});


/*********************
    AUTO COMPLETION
 *********************/

$(function ($) {

    $("#searchSportInput").keyup(function(){
        var search = $('#searchSportInput').val();
        var width=  $('#searchSportInput').width();

        $('#autocomplete__results').empty();
        if (search.length > 1) {
            $.getJSON(webrootJs+"sport/getSports/"+search, function(sports) {
                    for (var sport in sports) {
                        $('#autocomplete__results').append("<div class='sportDisplayed'>"+sports[sport].name+"</div>");
                        $('.sportDisplayed').width(width);
                    }
                    $(".sportDisplayed").click(function(){
                        $("#searchSportInput").val( $(this).text());
                        $('#autocomplete__results').empty();
                    });
            });
        }

    });

    $

});


/**********************
    -- AJAX FORMS --
**********************/


$(function ($) {

  $("#showUsers").click(function(e){
    $('#showUsers').css('display','none');
    $('.fourUsers').css('display','none');
    $('.allUsers').css('display','inline-block');
  })

  $("#hideAllUsers").click(function(e){
    $('#showUsers').css('display','inline-block');
    $('.fourUsers').css('display','inline-block');
    $('.allUsers').css('display','none');
  })

  $(".askToJoinForm").submit(function(e){
    e.preventDefault();

    var message = $('#message').val();
    var idTeam = $(this).attr('action').split("/");
    idTeam = idTeam[idTeam.length-1];
    if(message === ''){
      message = "J'aimerais vous rejoindre !";
    }
      $.ajax({
        url:$(this).attr('action'),
        type:$(this).attr('method'),
        data:{"message" : message,"idTeam":idTeam},
        success: function(){
          var container = $("#askToJoinHidden");
          container.fadeOut();
        	$('#fade').remove();
            if ($('#askingOrCancel').find(".actif").attr('id') != "cancelShow"){
                $('#askingShow').hide();
                $('#askingShow').attr("class","text-right inactif");
                $('#cancelShow').attr("class","text-right actif");
                $('#cancelShow').show();
                showMessage("Invitation envoyée", "success");
            }

        }
      })

  })
  var nbLetters = 50;
  $('.nbLetters').prepend(nbLetters );
  $.fn.extend({
    limit_characters: function(max, counter){
        $(this).bind("keydown focus", function(){
            var self = this;
            window.setTimeout(function(){
                var chars = self.value.length;
                if(chars > max) {
                    self.value = self.value.substr(0, max);
                    chars = max;
                    $('#message').css('border',"2px solid red");
                }else{
                  $('#message').css('border',"1px solid #8E8D8F");
                }
                if(typeof(counter) != 'undefined') counter.html(max-chars);
            }, 5);
        });
    }
});

  /*$('#message').keypress(function(){
          console.log("g");
      if((nbLetters - $('#message').val().length -1) <0){
        return false;
      }
      $('.nbLetters').empty();
      $('.nbLetters').prepend((nbLetters - $('#message').val().length -1)+" caractères restants");
  })*/
  var elem = $('.nbLetters');
  $('#message').limit_characters(50,elem);

  $("#askToJoin").click(function(e){
    $('#askToJoinHidden').fadeIn();
    //Lorsque vous cliquez sur un lien de la classe poplight et que le href commence par #
  	var popID = $(this).attr('rel'); //Trouver la pop-up correspondante

  	//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
  	var popMargTop = ($('#' + popID).height() + 80) / 2;
  	var popMargLeft = ($('#' + popID).width() + 80) / 2;


  	//Effet fade-in du fond opaque
  	$('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
  	//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
  	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

  	return false;
  });


  $(document).mouseup(function(e){
      var container = $("#askToJoinHidden");
      if(!container.is(e.target) && container.has(e.target).length === 0){
        container.fadeOut();
      	$('#fade').remove();  //...ils disparaissent ensemble
        //$("html").append($('<style>html:after{ content:""; position:"";left:"";right:"";top:"";bottom:"";background:"";}</style>'));
      }
  });

  $(".ajax-form, .ajax-link").on("click submit", function (ev) {
      // Handle click on empty input
      if ($(ev.target).attr("href") == undefined && ev.type == "click") {
          return;
      }
      ev.preventDefault();
      var lock = true;
      var action = $(this).attr("action");
      var method = $(this).attr("method");
      var success = $(this).data("success");
      var data = {};
      data.message = $(this).data("message");
      data.callback = $(this).data("callback");
      //data.callback = $(this).data("callback");
      if(typeof data.message == "undefined") {
          data.message = "Data updated !";
      }

      if ($(this).is(".ajax-link")) {

          data.idUser = $(this).data("user");
          data.idTeam = $(this).data("team");
          data.idEvent = $(this).data("event");
          data.upOrDown = $(this).data("upordown");

          data.type = $(this).data("type");
          data.comment = $(this).data("comment");

          $(this).parents("div.invitationsTo").remove();
          $(document).ready(function() {
              pagination(3,".invitationsTo","#pagination",1);
          });
          if($(this).is(".confirm")) {var tempAction = $(this).data("url")}else{
              action = $(this).data("url");
              action = window.location.origin+"/"+window.location.pathname.split("/",2)[1]+"/"+action;
          }

      } else {
          $.each($(this).find("input, select, textarea"), function () {
              if ($(this).attr("type") == "checkbox" || $(this).attr("type") == "radio") {
                  if ($(this).is(":checked")) {
                      data[$(this).attr("name")] = $(this).val();
                  }
              } else if (($(this).val().length > 0)) {
                  data[$(this).attr("name")] = $(this).val();
              }
          });
      }
      if ($('#askingOrCancel').find(".actif").attr('id') == "cancelShow") {
          $('#cancelShow').hide();
          $('#cancelShow').attr("class", "text-right inactif");
          $('#askingShow').attr("class", "text-right actif");
          $('#askingShow').show();
      }

      if($(this).is(".confirm")) {//confirmPopup
        var lock = false;
        $('#confirmPopup').fadeIn();

        //Effet fade-in du fond opaque
        $('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
        //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
        $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
        $('#validate').click(function(){
          if (!$.isEmptyObject(data)) {
              action = tempAction;
              action = window.location.origin+"/"+window.location.pathname.split("/",2)[1]+"/"+action;
            var container = $("#confirmPopup");
              container.fadeOut();
              $('#fade').remove();
                $.ajax({
                    method: method,
                    url: action,
                    data: data
                }).success(function (data) {
                    showMessage(data.message, "success");
                    triggerCallback(data);
                  // J'aimerais bien rajouter un petit refresh de window ici.
              }).fail(function (jqXHR, textStatus) {
                  var errors = (JSON.parse(jqXHR.responseText));
                  var errorText = "";
                  if (errors.errorText.length > 0) {
                      errorText = errors.errorText;
                  } else {
                      errorText = "Request failed :(";
                  }
                  showMessage(errorText, "danger");
              });
          }
        });
        $('#cancel').click(function(){
          var container = $("#confirmPopup");
            tempAction = '';
            container.fadeOut();
            $('#fade').remove();
        });
      }else{
        if (!$.isEmptyObject(data) && lock == true) {
              $.ajax({
                  method: method,
                  url: action,
                  data: data
              }).success(function (data) {
                  showMessage(data.message, "success",data.other,data.valueWithOther,data.classe);
                  triggerCallback(data);
                // J'aimerais bien rajouter un petit refresh de window ici.
            }).fail(function (jqXHR, textStatus) {
                var errors = (JSON.parse(jqXHR.responseText));
                var errorText = "";
                if (errors.errorText.length > 0) {
                    errorText = errors.errorText;
                } else {
                    errorText = "Request failed :(";
                }
                showMessage(errorText, "danger");
            });
        }
      }
    });
});

/***************************
    -- Message box --
****************************/

function showMessage(msg, code, other,valueWithOther,classe) {
    $box = $(".msg-box");
    $box.find(".text .text-content").html(msg);
    $box.addClass(code);
    $box.fadeIn();
    setTimeout(function () {
        $box.fadeOut();
    }, 5000);

    if(other == "like"){
      updateNumberVote(valueWithOther,classe);
    }

}

function updateNumberVote(upOrDown,classe){
    var valueActuel = parseInt($(classe).find("#compteurLike").text(),10);
    if(upOrDown == 1){
      valueActuel =  valueActuel + 1;
      if(valueActuel == 0){
        valueActuel = 1;
      }
    }else{
      valueActuel = valueActuel - 1;
      if(valueActuel == 0){
        valueActuel = -1;
      }
    }
    $(classe).find("#compteurLike").empty();
    $(classe).find("#compteurLike").text(valueActuel);
}


/***************************
    -- Notification box --
 ****************************/

$(function ($) {
    $("#popin-notifications").append("<ul class='dropdown-menu notifications right' id='liste-notifications' style='width: "+ width +"px'>");
  	var nbNotifications = 0;
    $.getJSON( webrootJs+"notification/list", function(notifications) {
        var nbNotifications = 0;
        $("#liste-notifications").append("<li class=\"notifications-heading global\">Notifications</li></ul><div ><ul id='scroll'>");
        for (var notification in notifications) {
            if (notifications[notification].opened == 1){
              $("#scroll").append("<li id=\"notif\" class=\"notifications-li opened scroll \"><a href="+notifications[notification].action+" data-id=\"" + notifications[notification].id + "\">"+notifications[notification].datetime+ ": "+notifications[notification].message+"</a></li>");
            } else {
              $("#scroll").append("<li id=\"notif\" class=\"notifications-li not-opened scroll \"><a href="+notifications[notification].action+" data-id=\"" + notifications[notification].id + "\">"+notifications[notification].datetime+ ": "+notifications[notification].message+"</a></li>");
                nbNotifications++;
            }
        }
        if(nbNotifications != 0){
            $("#notification-icon").attr("class", "icon-menu fa fa-bell");
        }
        $("#popin-notifications").append("</ul></div>");
    })
    var width = $( window ).width();
    var height = $( window ).height();
     $("#liste-notifications").css("width", width/2);
     $("#scroll").css("max-height", height/2);
     $( window ).resize(function() {
        var width = $( window ).width();
        var height = $( window ).height();
        $("#liste-notifications").css("width", width/2);
        $("#scroll").css("max-height", height/2);
    });
});

/********************
    -- Inbox --
********************/

$(function ($) {
    getDiscussions();
    $(".js-create-discussion").submit(function (ev) {
        getDiscussions();
    });
    var refreshMessagesInterval;
});

function getDiscussions() {
    var $list = $(".js-discussion-list");
    if ($list.length) {
        $.ajax({
            method: "GET",
            url: location.origin + "/inbox/getDiscussions",
        }).success(function (data) {
            //showMessage(data.message, "success");
        }).fail(function (jqXHR, textStatus) {
        }).then(function (data) {
            var currentUserId = Number(data.current_user_id);
            var items = "";
            if (data.message.length) {
                for (i = 0; i < data.message.length; i ++) {
                    items += "<li data-discussion='" + data.message[i].id +
                    "' class='js-discussion-list-item'> To: " +
                    data.message[i].pen_pal + "</li>"
                }
                $list.find("ul").html(items);
            }
            $(".js-discussion-list-item").click(function (ev) {
                var discussionId = $(ev.target).data("discussion");
                refreshMessages(gblCurrentUserId, discussionId);
                if (typeof refreshMessagesInterval != "undefined") {
                    clearInterval(refreshMessagesInterval);
                }
                refreshMessagesInterval = setInterval(function () {
                    refreshMessages(gblCurrentUserId, discussionId);
                }, 5000);
            });
            //listenForChooseDiscussion(currentUserId);
        });
    }
}



function refreshMessages(currentUserId, discussionId) {
    var $chatBody = $(".chat-body");
    $chatBody.attr("data-discussion", discussionId);
    $messageForm = $chatBody.find(".js-inbox-message-form");
    $messageForm.find("input[name='discussion_id']").val(discussionId);
    $.ajax({
        method: "POST",
        url: location.origin + "/inbox/getMessages",
        data: {"discussion_id" : discussionId}
    }).success(function(data) {
        // SUCCESS
    }).fail(function (jqXHR, textStatus) {
        //FAIL
    }).then(function (data) {
        var $messageList = $chatBody.find(".js-message-list");
        $messageList.html("");
        var $messages = [];
        $.each(data, function (index, message) {
            var $messageBox = $("<div></div>");
            $messageBox.data("sender", message.sender_id);
            $messageBox.append(
                "<span class='content'>" +
                message.content +
                "</span>"
            );
            $messageBox.addClass("message");
            if (message.sender_id == currentUserId) {
                $messageBox.addClass("sender-is-current");
            }
            $messages.push($messageBox);
        });
        if ($messages.length > 0) {
            $.each($messages, function (index, $message) {
                $messageList.append($message);
            });
        } else {
            $messageList.html("No message yet.");
        }
    });
}


/*********************
    -- Callbacks --
*********************/

function triggerCallback(data) {
    switch(data.callback) {
        case "discussions":
            getDiscussions();
            break;
        case "messages":
            refreshMessages(data.current_user_id, data.discussion_id);
            break;
        default:
            null
    }
}

/**************************
    -- Inputs hints --
*************************/

$(function ($) {
    $(".js-time-input").click(function(ev) {
        if (!$(ev.target).parent().find(".hintBox").length) {
            $inputGrp = $(ev.target).parent();
            $hintBox = $(document.createElement("div"));
            $hintBox.addClass("hintBox");
            if ($(ev.target).hasClass("js-time")) {
                $hintBox.append("Please respect the following format => hh:mm");
            } else if ($(ev.target).hasClass("js-date")) {
                $hintBox.append("Please respect the following format => dd/mm/yyyy");
            }
            $inputGrp.append($hintBox);
        }
    });
    $(".js-time-input").blur(function(ev) {
        $(ev.target).parent().find(".hintBox").remove();
    });
});

/***************************
 -- Search box --
 ****************************/

$(function ($) {

    $("#select-criteria").change(function(){
        $("#search-content").val("");
        $("#all-content").show();
        $("#pages").show();
    });
    $("#search-content").keyup(function(){
        var search = $('#search-content').val();
        if (search != "") {
            $("#all-content").hide();
            $("#pages").hide();
            if (page == "team"){
                //Recherche Team
                $.getJSON(webrootJs+"team/search/"+search, function(teams) {
                    if (teams != null) {
                        $("#search-content-results").empty();
                        for (var team in teams) {
                            $("#search-content-results").append('<div class="col-sm-6">' +
                                '                            <div class="panel panel-primary">' +
                                '                            <div class="panel-heading"><h3 class="center header-li "><a href="' + webrootJs + 'team/show/' + teams[team].id + '"> ' + teams[team].teamName + '</a></h3></div>' +
                                '                            <div class="panel-body">' +
                                '                            <ul class="header-ul">' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Nom : </span>' +
                                '                        <span class="form-content">' + teams[team].teamName + '</span>' +
                                '                            </li>' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Date de création : </span>' +
                                '                        <span class="form-content">' + teams[team].dateCreated + '</span>' +
                                '                            </li>' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Sports : </span>' +
                                '                        <span class="form-content">' + teams[team].sports + '</span>' +
                                '                            </li>' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Description : </span>' +
                                '                        <span class="form-content">' + teams[team].description + '</span>' +
                                '                            </li>' +
                                '                            </ul>' +
                                '                            </div>' +
                                '                            </div>' +
                                '                            </div>');
                        }
                    } else {
                        $( "#search-content-results" ).empty();
                        $("#search-content-results").append('<div class="col-sm-12">' +
                            '                            <div class="panel panel-primary">' +
                            '                            <div class="panel-heading"><h3 class="center header-li ">No Group found</a></h3></div></div>');
                    }
                });
            } if (page == "user") {
                //Recherche User
                $.getJSON(webrootJs+"user/search/"+search, function(users) {
                    if (users != null) {
                        $("#search-content-results").empty();
                        for (var user in users) {
                            $("#search-content-results").append('<div class="col-sm-6">' +
                                '                            <div class="panel panel-primary2">' +
                                '                            <div class="panel-heading"><h3 class="center header-li "><a href="' + webrootJs + 'user/show/' + users[user].id + '"> ' + users[user].username + '</a></h3></div>' +
                                '                            <div class="panel-body">' +
                                '                            <ul class="header-ul">' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Email : </span>' +
                                '                        <span class="form-content">' + users[user].email + '</span>' +
                                '                            </li>' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Ville : </span>' +
                                '                        <span class="form-content">' + users[user].city  + '</span>' +
                                '                            </li>' +
                                '                            <li class="li-list">' +
                                '                            <span class="form-info">Age : </span>' +
                                '                        <span class="form-content">' + getAge(users[user].birthday)  + '</span>' +
                                '                            </li>' +
                                '                            </ul>' +
                                '                            </div>' +
                                '                            </div>' +
                                '                            </div>'
                            );
                        }
                    } else {
                        $( "#search-content-results" ).empty();
                        $("#search-content-results").append('<div class="col-sm-12">' +
                            '                            <div class="panel panel-primary2">' +
                            '                            <div class="panel-heading"><h3 class="center header-li ">No User found</a></h3></div></div>');
                    }
                });
            } if(page == "event") {
                $.getJSON(webrootJs+"event/search/"+search, function(events) {
                    if (events != null) {
                        $("#search-content-results").empty();
                        $.each(events, function (key, data) {
                            $("#search-content-results").append(' <div class="panel panel-success">' +
                                '                                <div class="panel-heading">'+ data.eventName +'</div>' +
                                '                            <div class="panel-body">' +
                                '                                <p class="underlined">Owner : '+data.ownerName+'</p>' +
                                '                            <div class="row">' +
                                '                                <div class="col-sm-6">' +
                            '                                <div class="tag-box" id="tag-box'+data.id+'">' +
                                '                        </div>' +
                                '                            </div>' +
                            '                            <div class="col-sm-6">' +
                                '                            '+data.description+'' +
                                '                        </div>' +
                                '                            </div>' +
                                '                            <ul class="item-list">' +
                                '                                <li>From : '+data.fromDate+'</li>' +
                                '                            <li>To : '+data.toDate+'</li>' +
                                '                            <li>Joignable until '+data.joignableUntil+'</li>' +
                                '</ul>' +
                                '                                <p>People : </p>' +
                                '<ul class="item-list list-people" id="list-people'+data.id+'"></ul>' +
                                '</div>' +
                                '<div class="panel-footer" id="panel-footer'+data.id+'"></div>' +
                                '');
                            $.each(data.users, function (key, user) {
                                $("#list-people"+data.id).append('<li class="li-people">'+user.username+'</li>');
                            });
                            var tagsSplited = data.tags.split(",");
                            $.each(tagsSplited, function (key, split) {
                                $("#tag-box"+data.id).append('<a href="#">'+split+' </a>');
                            });
                            if (data.owner == sessionId){
                                $("#panel-footer"+data.id).append('<a href="'+webrootJs+'event/update/'+data.id+'" class="btn btn-primary">Manage</a>');
                            }else{
                                for(var user in data.users){
                                    var jORl = "j";
                                    if(sessionId == data.users[user].id && data.owner != sessionId){
                                        jORl = "l";
                                        break;
                                    }
                                }
                                if(jORl == "l"){
                                    $("#panel-footer"+data.id).append('<a href="'+webrootJs+'event/leave/'+data.id+'/'+sessionId+'" class="btn btn-danger">Leave</a>');
                                }else{
                                    $("#panel-footer"+data.id).append('<a href="'+webrootJs+'event/join/'+data.id+'" class="btn btn-success">Join</a>');
                                }
                            }
                            $("#panel-footer"+data.id).append('<a href="'+webrootJs+'event/comment/'+data.id+'" class="btn btn-warning pull-right">Comments</a>');
                      });
                    } else {
                        $( "#search-content-results" ).empty();
                        $("#search-content-results").append('<div class="col-sm-12">' +
                            '                            <div class="panel panel-primary">' +
                            '                            <div class="panel-heading"><h3 class="center header-li ">No Group found</a></h3></div></div>');
                    }
                });

            }
        } else {
            $( "#search-content-results" ).empty();
            $("#all-content").show();
            $("#pages").show();
        }
    });
});


function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if(!isNaN(age)){
      return age+" ans";
    }else{
      return "";
    }
}
