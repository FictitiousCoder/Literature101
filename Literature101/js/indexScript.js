

var main = function () {

    var body = document.body,
    html = document.documentElement;

    var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );
    document.getElementsByClassName("navLeft")[0].style.height = height;


    //If the user is not entering the page, but is simply refreshing it,
    //set the active/selected category to be the same as it was prior
    //to the refresh.
    if (typeof localStorage.getItem("activeClass") != 'undefined') {
        var previousActive = localStorage.getItem("activeClass");
        previousSubActive = ".sub" + previousActive;
        previousActive = "." + previousActive;

        $(previousActive).addClass('active');
        $(previousSubActive).addClass('subActive');
        $(previousSubActive).removeClass('hidden');

    }
    //Else, direct the user to the "Home" tab by default.
    else {
        $(".Home").addClass('active');
        $(".subHome").addClass('subActive');
        $(".subHome").removeClass('hidden');
        //$(subClass).addClass('subActive');
        var welcome = document.getElementsByClassName("home")[0];
        document.getElementById("currentArticle").value = subject;
        document.getElementById("articleQuery").submit();

        alert("test");
    }
    
    
 
    //---------------------Sub Menu -------------------------------
    
    $( ".sub" ).click(function() {
        
        //Change the active sub-menu element to the one that was clicked
        var tempDom = document.getElementsByClassName('active');
        var aNode = tempDom[0].className;
        var activeClass = aNode.replace("active", "");
        localStorage.setItem("activeClass", activeClass);
        
        //Use the id of the clicked element to fill and send a form to the server
        var subject = $(this).attr('id');
        document.getElementById("currentArticle").value = subject;
        document.getElementById("articleQuery").submit(); //THIS WORKS!
    });
    
    //---------------------Search-------------------------------
    //Function for the search-feature. To be able to search for content without
    //resetting/removing the content the user is currently watching, the currently
    //active content is stored before the form is submitted and the page refreshes.
    $('#searchForm').submit(function(ev) {
        ev.preventDefault();   //To pause the form from submitting
        localStorage.setItem("activeClass", "Search");
        localStorage.setItem("activeArticle", document.getElementById("articleHeader"));
        this.submit();
    });


    
    //---------------------Top Menu -------------------------------

    $( ".navTop li" ).click(function() { 
        
        //Get the class-name for the menu attached to the clicked element.
        var topClass = $(this).attr('class');
        
        //If the clicked option is not already selected, select it.
        if (topClass.indexOf('active') == -1) {
            
            var subClass = ".sub" + topClass;

            //Change active element in the top-navigation bar.
            $(".active").removeClass('active');
            $(this).addClass('active');

            //Change active element in the sub-navigation bar.
            $(".subActive").addClass('hidden');
            $(".subActive").removeClass('subActive');
            $(subClass).addClass('subActive');
            $(".subActive").removeClass('hidden');

            //alert(subClass);
        }
    });

}


$(document).ready(main);