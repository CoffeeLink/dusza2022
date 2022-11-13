var element = document.getElementById('content-editor');

if (element) {
  var simplemde = new SimpleMDE({ element });
  console.log("SimpleMDE loaded");
}