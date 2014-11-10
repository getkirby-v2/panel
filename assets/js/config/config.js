// create a simple new app object
var app = {};

// store the main api url for our $http helper
$http.endpoint = 'api';

// cache the most relevant elements
app.body  = $('body');
app.doc   = $(document);
app.win   = $(window);
app.title = document.title;