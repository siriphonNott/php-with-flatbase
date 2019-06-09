function maxLengthCheck(object) {
  if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
}

$('.profileImg').click(function () {
  $('input[type=file]').click();
});