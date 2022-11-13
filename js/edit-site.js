function submitEditSite(e) {
  e.preventDefault();

  // get icon as base64 string
  var _icon = document.getElementById('icon').files[0];
  var reader = new FileReader();
  reader.readAsBinaryString(_icon);
  reader.onload = function () {
    var icon = btoa(reader.result);
  
    // POST request to /handlers/submit-edit-site.php with the form data
    // no jQuery
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './handlers/submit-edit-site.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      // do something to response
    }

    var data = {
      'site_name': document.getElementById('site_name').value,
      'description': document.getElementById('content-editor').value,
      'email': document.getElementById('email').value,
      'icon': icon
    }

    var body = '';
    for (var key in data) {
      if (body != '') {
        body += '&';
      }
      body += key + '=' + encodeURIComponent(data[key]);
    }

    xhr.send(body);
  }
}

document.getElementById('edit-site-form').addEventListener('submit', submitEditSite);