//constants
var CLICK_TO_EXPAND = "Click to Expand";
var CLICK_TO_COLLPASE = "Click to Collapse";
var DISPLAY_NONE = "display: none;";
var DISPLAY_BLOCK = "display: block;";

//forms & buttons
var userForm, lotForm, reportsForm;
var userButton, lotButton, reportsButton, Register;

//whether or not a form is being displayed
var showingUser, showingLot, showingReports;

//form fields
var firstName, lastName, userBuyerID, userSellerID, email;
var lotNumber, lotBuyerID, lotSellerID, lotSellercheckID, lotPrice, lotTitle, lotPaid, lotQty, lotReserve, itemNumber;
//, itemNumber
//user "load" functions
var userLoads = new Array();

//lot "load" functions
var lotLoads = new Array();

//item "load" functions
var itemLoads = new Array();

var onLoadFunction = function() {
  showingUser = false;
  showingLot = false;
  showingReports = false;
  showingTools = false;
  showingCheckout = false;
  showingCheckoutsell = false;

  userForm = document.getElementById("userInfo");
  lotForm = document.getElementById("lotInfo");
  reportsForm = document.getElementById("reportsInfo");
  toolsForm = document.getElementById("toolsInfo");
  checkoutForm = document.getElementById("checkoutInfo");
  checkoutsellForm = document.getElementById("checkoutsellInfo");

  //userForm.style = DISPLAY_NONE;
  //lotForm.style = DISPLAY_NONE;
  //reportsForm.style = DISPLAY_NONE;

  document.getElementById("smallFont").onclick = smallerButton;
  document.getElementById("medFont").onclick = medButton;
  document.getElementById("bigFont").onclick = bigButton;

  userButton = document.getElementById("userButton");
  //Register = document.getElementById("Register");
  //lotButton = document.getElementById("lotButton");
  reportsButton = document.getElementById("reportsButton");
  toolsButton = document.getElementById("toolsButton");
  checkoutButton = document.getElementById("checkoutButton");
  checkoutsellButton = document.getElementById("checkoutsellButton");

  //userButton.onclick = userInfo;
  //Register.onclick = Register;
  //lotButton.onclick = lotInfo;
  //reportsButton.onclick = reportsInfo;
  //toolsButton.onclick = toolsInfo;
  //checkoutButton.onclick = checkoutInfo;
  //checkoutsellButton.onclick = checkoutsellInfo;

  //var fistName, lastName, userBuyerID, userSellerID, email;
  firstName = document.getElementById("userFirstName");
  lastName = document.getElementById("userLastName");
  userBuyerID = document.getElementById("userBuyerID");
  userSellerID = document.getElementById("userSellerID");
  email = document.getElementById("userEmail");
  //userNotes = document.getElementById("userNotes")

  //var lotNumber, lotBuyerID, lotSellerID, lotPrice, lotTitle, lotPaid, lotSellercheckID, lotQty, lotReserve, itemNumber;
  lotNumber = document.getElementById("lotNumber");
  itemNumber = document.getElementById("itemNumber");
  lotBuyerID = document.getElementById("lotBuyerID");
  lotSellerID = document.getElementById("lotSellerID");
  lotSellercheckID = document.getElementById("lotSellercheckID");
  lotPrice = document.getElementById("lotPrice");
  lotTitle = document.getElementById("lotTitle");
  lotPaid = document.getElementById("lotPaid");
  lotQty = document.getElementById("lotQty");
  lotReserve = document.getElementById("lotReserve");


  //register the onkeyup events for the fields
  //document.getElementById("userFirstName").onkeyup = ???;
  /*
   * names are a problem with this but they didn't ask for it so they don't need
   * it.
   */

  lotNumber.onkeyup = lotNumberLoad;
  itemNumber.onkeyup = itemNumberLoad;
};


function openMain(evt, mainName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(mainName).style.display = "block";
    evt.currentTarget.className += " active";
}


var smallerButton = function() {
  document.body.style = "font-size: medium;";
};

var medButton = function() {
  document.body.style = "font-size: x-large;";
};

var bigButton = function() {
  document.body.style = "font-size: xx-large;";
};

var userInfo = function() {
  showingUser = !showingUser;

  if (showingUser) {
    userForm.style = DISPLAY_BLOCK;
  } else {
    userForm.style = DISPLAY_NONE;
  }
};

var lotInfo = function() {
  showingLot = !showingLot;

  if (showingLot) {
    lotForm.style = DISPLAY_BLOCK;
  } else {
    lotForm.style = DISPLAY_NONE;
  }
};


var reportsInfo = function() {
  showingReports = !showingReports;

  if (showingReports) {
    reportsForm.style = DISPLAY_BLOCK;
  } else {
    reportsForm.style = DISPLAY_NONE;
  }
};

var toolsInfo = function() {
  showingTools = !showingTools;

  if (showingTools) {
    toolsForm.style = DISPLAY_BLOCK;
  } else {
    toolsForm.style = DISPLAY_NONE;
  }
};

var checkoutInfo = function() {
  showingCheckout = !showingCheckout;

  if (showingCheckout) {
    checkoutForm.style = DISPLAY_BLOCK;
  } else {
    checkoutForm.style = DISPLAY_NONE;
  }
};

var checkoutsellInfo = function() {
  showingCheckoutsell = !showingCheckoutsell;

  if (showingCheckoutsell) {
    checkoutsellForm.style = DISPLAY_BLOCK;
  } else {
    checkoutsellForm.style = DISPLAY_NONE;
  }
};

var lotNumberLoad = function() {
  if (lotNumber.value === "") return;
  if (lotLoads[lotNumber.value]) lotLoads[lotNumber.value]();
};

var itemNumberLoad = function() {
  if (itemNumber.value === "") return;
  if (itemLoads[itemNumber.value]) itemLoads[itemNumber.value]();
};

function myFunction() {
    // Declare variables
    var input, filter, ul, li, div, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');
    div = ul.getElementsByTagName('div');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function mynewFunction() {
    // Declare variables
    var input, filter, ul, li, div, a, i;
    input = document.getElementById('myuserInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myULA");
    li = ul.getElementsByTagName('li');
    div = ul.getElementsByTagName('div');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function resetForm(form) {
    // clearing inputs
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i<inputs.length; i++) {
        switch (inputs[i].type) {
            // case 'hidden':
            case 'text':
                inputs[i].value = '';
                break;
            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;
        }
    }

    // clearing selects
    var selects = form.getElementsByTagName('select');
    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;

    // clearing textarea
    var text= form.getElementsByTagName('textarea');
    for (var i = 0; i<text.length; i++)
        text[i].innerHTML= '';

    return false;
}
