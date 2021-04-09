function closeModal(nameElement, areaId) {
  $(nameElement).click(function () {
    $('#' + areaId).modal('hide');
  });
}
