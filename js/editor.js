var element = document.getElementById('content-editor');

if (element) {
  var simplemde = new SimpleMDE({ element });
  simplemde.value("");
  console.log("SimpleMDE loaded");
}